<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user();

        $cart = Cart::with('product')->where(['user_id' => $user->id]);

        if($request->input('checked',0) == 1)
        {
            $cart->where('chosen',1);
        }

        $cart_count = $cart->count();

        if($cart_count)
        {
            $carts = $cart->orderBy('id','desc')->get();
            
            $subtotal_chosen = 0;
            $subtotal_all = 0;

            $cart_chosen = Cart::where(['user_id' => $user->id])->get();
            foreach($cart_chosen as $key)
            {
                $subtotal_all += ($key->qty * $key->product->price);
                if($key->chosen == '1')
                {
                    $subtotal_chosen += ($key->qty * $key->product->price);
                }
                
            }

            $result['status'] = true;
            $result['message'] = "OK";
            $result['data'] = $carts;
            $result['details'] = [
                'subtotal' => $subtotal_chosen,
                'subtotal_all' => $subtotal_all,
            ];
            return response($result);
        }

        return response([
            'status' => false,
            'data' => [],
            'message' => "Belum ada produk di keranjang"
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'product' => 'required|exists:App\Models\Product,id',
            'qty' => 'required|numeric'
        ]);

        $product = Product::find($request->product);

        $cek = Cart::where(['user_id' => $user->id,'product_id' => $request->product]);

        if($cek->count())
        {

            $cart = $cek->first();

            if($product->stock < $cart->qty+$request->qty)
            {
                $result['status'] = false;
                $result['message'] = "Jumlah melebihi stok produk yaitu $product->stock";
                return response($result);
            }

            $cek->update([
                'qty' => $cart->qty+$request->qty
            ]);
            $result['status'] = true;
            $result['message'] = "Berhasil menambahkan ke keranjang";
            return response($result);

        }

        if($product->stock < $request->qty)
        {
            $result['status'] = false;
            $result['message'] = "Jumlah melebihi stok produk yaitu $product->stock";
            return response($result);
        }

        $sv = Cart::create([
            'user_id' => $user->id,
            'product_id' => $request->product,
            'qty' => $request->qty,
            'chosen' => 0
        ]);

        if($sv)
        {
            $result['status'] = true;
            $result['message'] = "Berhasil menambahkan ke keranjang";
            return response($result);
        }

        $result['status'] = false;
        $result['message'] = "Gagal menambahkan ke keranjang";
        return response($result);

    }
    
    public function destroy(Request $request,$id)
    {

        $user = auth()->user();

        $cart = Cart::where(['id' => $id,'user_id' => $user->id]);
        if($cart->first())
        {
            $cart->delete();
            $result['status'] = true;
            $result['message'] = "Berhasil menghapus produk dari keranjang";
            return response($result);
        }

        $result['status'] = false;
        $result['message'] = "Gagal menghapus produk dari keranjang";
        return response($result);

    }

    public function upQty(Request $request,$id)
    {

        $user = auth()->user();

        $request->validate([
            'qty' => 'required|numeric'
        ]);

        $cart = Cart::where(['id' => $id,'user_id' => $user->id]);
        if($cart_row = $cart->first())
        {

            if($cart_row->product->stock < $request->qty)
            {
                $stock = $cart_row->product->stock;
                $result['status'] = false;
                $result['message'] = "Jumlah melebihi stok produk yaitu $stock";
                $result['stock'] = $stock;
                return response($result);
            }

            $cart->update([
                'qty' => $request->qty
            ]);

            $result['status'] = true;
            $result['message'] = "Berhasil mengubah jumlah";
            return response($result);
        }

        $result['status'] = false;
        $result['message'] = "Gagal mengubah jumlah";
        return response($result);

    }

    public function checked(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'id' => 'required|exists:App\Models\Cart,id'
        ]);

        $cart = Cart::where(['id' => $request->id,'user_id' => $user->id]);
        if($cart_row = $cart->first())
        {
            $up = $cart->update([
                'chosen' => !$cart_row->chosen
            ]);
            if($up)
            {
                $result['status'] = true;
                $result['message'] = "OK";
                $result['checked'] = (!$cart_row->chosen == '1'? true : false);
                return response($result);
            }
        }

        $result['status'] = false;
        $result['message'] = "Gagal";
        return response($result);

    }

    public function checked_all(Request $request)
    {
        $user = auth()->user();

        $checked = $request->input('checked',0);

        $cart_up = Cart::where(['user_id' => $user->id])->update([
            'chosen' => ($checked == '1'? 1 : 0)
        ]);
        if($cart_up)
        {
            $result['status'] = true;
            $result['message'] = "OK";
            return response($result);
        }

        $result['status'] = false;
        $result['message'] = "Gagal";
        return response($result);

    }
    
}
