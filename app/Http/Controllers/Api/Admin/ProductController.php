<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $start  = $request->input('start',0);
        $length = $request->input('length',10);
        $draw   = $request->input('draw');
        $search = $request->input('search.value');

        $product = new Product;

        if(!empty($search))
        {
            $product = $product->where(function($query) use ($search){
                $query->where('name','like',"%$search%")
                ->orWhere('description','like',"%$search%")
                ->orWhere('price','like',"%$search%");
            });
        }

        $total = $product->count();

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
        $data = $product->orderBy('id','desc');
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
            'image' => 'required|image|mimes:png,jpg',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'weight' => 'required',
        ]);

        $file_path = $request->file('image')->store('public/product-image');

        if($file_path)
        {

            $sv = Product::create([
                'image' => '/storage'.str_replace('public','',$file_path),
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'weight' => $request->weight,
            ]);

            if($sv)
            {
                $result['status'] = true;
                $result['message'] = "Berhasil menambah produk";
                return response($result);
            }

            $result['status'] = false;
            $result['message'] = "Gagal menambah produk";
            return response($result);

        }
        $result['status'] = false;
        $result['message'] = "Gagal mengupload gambar";
        return response($result);

    }

    public function update(Request $request,$id)
    {

        $product = Product::find($id);
        if(!$product)
        {
            $result['status'] = false;
            $result['message'] = "Produk tidak ditemukan";
            return response($result);
        }

        $request->validate([
            'image' => 'nullable|image|mimes:png,jpg',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'weight' => 'required',
        ]);

        if($request->image)
        {
            $file_path = $request->file('image')->store('public/product-image');

            if($file_path)
            {

                $sv = Product::create([
                    'image' => '/storage'.str_replace('public','',$file_path),
                    'name' => $request->name,
                    'description' => $request->description,
                    'price' => $request->price,
                    'stock' => $request->stock,
                    'weight' => $request->weight,
                ]);

                if($sv)
                {
                    $result['status'] = true;
                    $result['message'] = "Berhasil mengubah produk";
                    return response($result);
                }

                $result['status'] = false;
                $result['message'] = "Gagal mengubah produk";
                return response($result);

            }
            $result['status'] = false;
            $result['message'] = "Gagal mengupload gambar";
            return response($result);

        }

        $sv = $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'weight' => $request->weight,
        ]);

        if($sv)
        {
            $result['status'] = true;
            $result['message'] = "Berhasil mengubah produk";
            return response($result);
        }

        $result['status'] = false;
        $result['message'] = "Gagal mengubah produk";
        return response($result);
        
    }

    public function destroy(Request $request,$id)
    {
        $product = Product::find($id);
        if(!$product)
        {
            $result['status'] = false;
            $result['message'] = "Produk tidak ditemukan";
            return response($result);
        }

        try {
            $del = $product->delete();
            if($del)
            {
                $result['status'] = true;
                $result['message'] = "Produk berhasil dihapus";
                return response($result);
            }
            $result['status'] = false;
            $result['message'] = "Produk gagal dihapus";
            return response($result);
        } catch (\Throwable $th) {
            $result['status'] = false;
            $result['message'] = "Produk gagal dihapus";
            return response($result);
        }
        
    }
}
