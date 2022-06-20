<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use DB;

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

    public function transactionProduct(Request $request, Product $product)
    {

        if($product->count())
        {

            $data = DB::table("transactions")
            ->selectRaw("COUNT(id) as total_monthly,MONTH(created_at) as month")
            ->groupByRaw("MONTH(created_at), YEAR(created_at)")->get();
            
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
