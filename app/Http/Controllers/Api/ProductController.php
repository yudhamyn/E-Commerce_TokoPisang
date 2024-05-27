<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $limit = $request->input('limit',10);
        $page = $request->input('page',1);

        $product = new Product;

        $product_count = $product->count();

        $pagination = generate_pagination($product_count,$limit,$page);


        if($product_count)
        {
            $products = $product->offset($pagination['start'])->limit($limit)->get();

            $result['status'] = true;
            $result['message'] = "OK";
            $result['data'] = $products;
            $result['action'] = ($user? ($user->level_id == 1? false : true) : false);
            $result['pagination'] = $pagination;
            return response($result);
        }

        return response([
            'status' => false,
            'data' => [],
            'message' => "Belum ada produk",
            'pagination' => $pagination
        ]);
        
    }
}
