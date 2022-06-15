<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'address' => 'required',
            'address.name' => 'required|string',
            'address.phone' => 'required|string',
            'address.address' => 'required',
        ],[
            'address.required' => 'Alamat wajib diisi',
            'address.name.required' => "Nama penerima wajib diisi",
            'address.phone.required' => "No HP penerima wajib diisi",
            'address.address.required' => "Alamat penerima wajib diisi",
        ]);

        $cart = Cart::where(['user_id' => $user->id,'chosen' => 1]);

        if($cart->count())
        {

            UserAddress::where(['user_id' => $user->id])->update(['default' => 0]);

            $address_sv = UserAddress::create([
                'user_id' => $user->id,
                'name' => $request->input('address.name'),
                'phone' => $request->input('address.phone'),
                'address' => $request->input('address.address'),
                'default' => 1
            ]);

            if($address_sv)
            {
                $carts = $cart->get();

                $total = 0;

                foreach($carts as $key)
                {
                    $total += ($key->qty * $key->product->price);
                }

                $transaction_create = Transaction::create([
                    'user_id' => $user->id,
                    'user_address_id' => $address_sv->id,
                    'status' => 0,
                    'total' => $total,
                ]);

                if($transaction_create)
                {

                    $transaction_id = $transaction_create->id;

                    $transaction_detail = [];

                    foreach($carts as $key)
                    {
                        $total += ($key->qty * $key->product->price);

                        $transaction_detail[] = [
                            'transaction_id' => $transaction_id,
                            'product_id' => $key->product_id,
                            'price' => $key->product->price,
                            'qty' => $key->qty,
                            'subtotal' => ($key->qty * $key->product->price),
                        ];

                        Product::find($key->product_id)->update([
                            'stock' => ($key->product->stock - $key->qty)
                        ]);

                    }

                    TransactionDetail::insert($transaction_detail);

                    Cart::where(['user_id' => $user->id,'chosen' => 1])->delete();

                    $result['status'] = true;
                    $result['message'] = "Berhasiil membuat pesanan";
                    return response($result);

                }
            }

        }

        $result['status'] = false;
        $result['message'] = "Gagal membuat pesanan";
        return response($result);

    }
}
