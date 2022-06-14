<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $start  = $request->input('start',0);
        $length = $request->input('length',10);
        $draw   = $request->input('draw');
        $search = $request->input('search.value');

        $user = User::with('level');

        if(!empty($search))
        {
            $user = $user->where(function($query) use ($search){
                $query->where('name','like',"%$search%")
                ->orWhere('phone','like',"%$search%")
                ->orWhere('email','like',"%$search%");
            });
        }

        $total = $user->count();

        if($total == 0)
        {
            $result['recordsTotal']     = 0;
            $result['recordsFiltered']  = 0;
            $result['draw']             = $draw;
            $result['data']             = [];
            $result['status']           = false;
            $result['message']          = "Data tidak ditemukan";
            return response($result);
        }
        $data = $user->orderBy('id','desc');
        $data = $data->offset($start)->limit($length)->get();

        $result['recordsTotal']     = $total;
        $result['recordsFiltered']  = $total;
        $result['draw']             = $draw;
        $result['data']             = $data;
        $result['status']           = true;
        $result['message']          = "OK";
        return response($result);
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|exists:App\Models\Level,id',
            'name' => 'required',
            'phone' => 'nullable',
            'email' => 'required|email|unique:App\Models\User,email',
            'password' => 'required|min:5',
            'password_confirmation' => 'required|same:password',
        ]);

        $remember_token = Str::random(74);

        if($request->role == '1')
        {
            $remember_token = Str::random(92);
        }

        $sv = User::create([
            'level_id' => $request->role,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => $remember_token
        ]);

        if($sv)
        {
            return response([
                'status' => true,
                'message' => "Berhasil menambahkan pengguna"
            ]);
        }
        return response([
            'status' => false,
            'message' => "Gagal menambahkan pengguna"
        ]);

    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return response([
                'status' => false,
                'message' => "Pengguna tidak ditemukan"
            ]);
        }

        $request->validate([
            'role' => 'required|exists:App\Models\Level,id',
            'name' => 'required',
            'phone' => 'nullable',
            'email' => 'required|email',
            'password' => 'nullable|min:5',
            'password_confirmation' => 'nullable|same:password',
        ]);

        if($request->email != $user->email)
        {
            $request->validate(['email' => 'unique:App\Models\User,email']);
        }

        if(!empty($request->password))
        {
            $request->validate([
                'password' => 'required|min:5',
                'password_confirmation' => 'required|same:password',
            ]);
        }

        $password = $user->password;

        if(!empty($request->password))
        {
            $password = Hash::make($request->password);
        }

        $sv = $user->update([
            'level_id' => $request->role,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $password
        ]);

        if($sv)
        {
            return response([
                'status' => true,
                'message' => "Berhasil mengubah pengguna"
            ]);
        }
        return response([
            'status' => false,
            'message' => "Gagal mengubah pengguna"
        ]);

    }

    
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return response([
                'status' => false,
                'message' => "Pengguna tidak ditemukan"
            ]);
        }

        try {
            $del = $user->delete();

            if($del)
            {
                return response([
                    'status' => true,
                    'message' => "Berhasil menghapus pengguna"
                ]);
            }
            return response([
                'status' => false,
                'message' => "Gagal menghapus pengguna"
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => "Gagal menghapus pengguna"
            ]);
        }

    }


}
