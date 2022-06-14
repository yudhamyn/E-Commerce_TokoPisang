<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:App\Models\User,email',
            'phone' => 'required|max:13',
            'password' => 'required|min:5',
            'password_confirmation' => 'required|same:password'
        ],[
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'phone.required' => 'No Hp wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password_confirmation.required' => 'Konfirmasi Password wajib diisi.',
        ]);

        $sv = User::create([
            'level_id' => 2,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(74)
        ]);

        if($sv)
        {
            $result['status'] = true;
            $result['message'] = "Berhasil mendaftar silahkan login.";
            return response($result);
        }
        $result['status'] = false;
        $result['message'] = "Gagal mendaftar mohon cek data anda.";
        return response($result);

    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ],[
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where(['email' => $request->email])->first();
        if(!$user)
        {
            $result['status'] = false;
            $result['message'] = "Email atau password yang anda masukkan salah.";
            return response($result);

        }

        if(!Hash::check($request->password,$user->password))
        {
            $result['status'] = false;
            $result['message'] = "Email atau password yang anda masukkan salah.";
            return response($result);
        }

        $result['status'] = true;
        $result['message'] = "Berhasil login";
        $result['data']['token'] = $user->remember_token;
        $result['data']['primary'] = $user->level->primary == '1'? true : false;
        return response($result);

    }

    public function profile()
    {
        $user_id = auth()->id();

        $find = User::with('level')->find($user_id);
        if($find)
        {
            $result['status'] = true;
            $result['message'] = "OK";
            $result['data'] = $find;
            return response($result);
        }

        $result['status'] = false;
        $result['message'] = "Data tidak ditemukan";
        $result['data'] = null;
        return response($result);

    }
}
