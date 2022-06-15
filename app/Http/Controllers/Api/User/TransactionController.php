<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $start  = $request->input('start',0);
        $length = $request->input('length',10);
        $draw   = $request->input('draw');
        $search = $request->input('search.value');

        $transaction = Transaction::where(['user_id' => $user->id])->with('user_address','details','details.product');
        if(!empty($search))
        {
            $transaction = $transaction->where(function($query) use ($search){
                $query->orWhere('total','like',"%$search%")
                ->orWhere('purchase_order','like',"%$search%");
            });
        }

        $total = $transaction->count();

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

        $data = $transaction->orderBy('id','desc');
        $data = $data->offset($start)->limit($length)->get();

        $result['recordsTotal']     = $total;
        $result['recordsFiltered']  = $total;
        $result['draw']             = $draw;
        $result['data']             = $data;
        $result['status']           = true;
        $result['message']          = "OK";
        return response($result);
    }

    public function cancel(Request $request,$id)
    {

        $user = auth()->user();

        $transaction = Transaction::where(['id' => $id,'user_id' => $user->id]);
        $transaction_row = $transaction->first();
        if(!$transaction_row)
        {
            $result['status'] = false;
            $result['message'] = "Transaksi tidak ditemukan";
            return response($result);
        }

        if($transaction_row->status != 0)
        {
            $result['status'] = false;
            $result['message'] = "Transaksi tidak dapat dibatalkan";
            return response($result);
        }

        $up = $transaction->update([
            'status' => 6
        ]);
        
        if($up)
        {
            $result['status'] = true;
            $result['message'] = "Transkasi berhasil dibatalkan";
            return response($result);
        }

        $result['status'] = false;
        $result['message'] = "Gagal membatalkan transaksi";
        return response($result);
    }

    public function received(Request $request,$id)
    {

        $user = auth()->user();

        $transaction = Transaction::where(['id' => $id,'user_id' => $user->id]);
        $transaction_row = $transaction->first();
        if(!$transaction_row)
        {
            $result['status'] = false;
            $result['message'] = "Transaksi tidak ditemukan";
            return response($result);
        }

        if($transaction_row->status != 2)
        {
            $result['status'] = false;
            if($transaction_row->status < 2)
            {
                $result['message'] = "Pesanan tidak dapat diterima, karena admin belum mengirim barang";
            }else{
                $result['message'] = "Pesanan tidak dapat diterima";
            }
            return response($result);
        }

        $up = $transaction->update([
            'status' => 3
        ]);
        
        if($up)
        {
            $result['status'] = true;
            $result['message'] = "Barang berhasil diterima";
            return response($result);
        }

        $result['status'] = false;
        $result['message'] = "Gagal menerima barang";
        return response($result);
    }

    public function finish(Request $request,$id)
    {

        $user = auth()->user();

        $transaction = Transaction::where(['id' => $id,'user_id' => $user->id]);
        $transaction_row = $transaction->first();
        if(!$transaction_row)
        {
            $result['status'] = false;
            $result['message'] = "Transaksi tidak ditemukan";
            return response($result);
        }

        if($transaction_row->status != 3)
        {
            $result['status'] = false;
            if($transaction_row->status < 3)
            {
                $result['message'] = "Transaksi belum dapat selesaikan, karena anda belum menerima barang";
            }else{
                $result['message'] = "Transaksi tidak dapat diselesaikan";
            }
            return response($result);
        }

        $up = $transaction->update([
            'status' => 4
        ]);
        
        if($up)
        {
            $result['status'] = true;
            $result['message'] = "Transaksi berhasil di selesaikan";
            return response($result);
        }

        $result['status'] = false;
        $result['message'] = "Gagal menyelesaikan transaksi";
        return response($result);
    }
}
