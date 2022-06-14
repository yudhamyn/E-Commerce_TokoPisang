<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $productCount = Product::count();
        $transactionIncome = Transaction::sum('total');
        $transactionCount = Transaction::count();
        $transactionPendingCount = Transaction::where(['status' => 0])->count();

        $result['status'] = true;
        $result['message'] = "OK";
        $result['data'] = compact('productCount','transactionIncome','transactionCount','transactionPendingCount');
        return response($result);

    }

    public function interestedProduct(Request $request, Product $product)
    {

        if($product->count())
        {

            $data = [];
            foreach($product->get() as $key){
                $sold = $key->transaction_detail->sum('qty');
                $percent = ($key->stock == 0? 100 : round(($sold/$key->stock)*100));
                $data[] = [
                    'name' => $key->name,
                    'stock' => $key->stock,
                    'sold' => $sold,
                    'percent' => $percent
                ];
            }
            return response([
                'status' => true,
                'message' => "OK",
                'data' => $data
            ]);

        }

        return response([
            'status' => false,
            'message' => "Belum ada produk",
        ]);

    }
}
