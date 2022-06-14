<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $start  = $request->input('start',0);
        $length = $request->input('length',10);
        $draw   = $request->input('draw');
        $search = $request->input('search.value');

        $transaction = Transaction::with('user_address','details','details.product','user');

        if(!empty($search))
        {
            $transaction = $transaction->where(function($query) use ($search){
                $query->whereRelation('user','name','like',"%$search%")
                ->orWhere('total','like',"%$search%")
                ->orWhere('courier','like',"%$search%")
                ->orWhere('waybill','like',"%$search%");
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

    public function reject(Request $request,$id)
    {

        $transaction = Transaction::find($id);
        if(!$transaction)
        {
            $result['status'] = false;
            $result['message'] = "Transaksi tidak ditemukan";
            return response($result);
        }

        if($transaction->status != 0)
        {
            $result['status'] = false;
            $result['message'] = "Transaksi tidak dapat ditolak";
            return response($result);
        }

        $up = $transaction->update([
            'status' => 5
        ]);
        
        if($up)
        {
            $result['status'] = true;
            $result['message'] = "Transkasi berhasil ditolak";
            return response($result);
        }

        $result['status'] = false;
        $result['message'] = "Gagal membatalkan transaksi";
        return response($result);
    }
    
    public function process(Request $request,$id)
    {

        $transaction = Transaction::find($id);
        if(!$transaction)
        {
            $result['status'] = false;
            $result['message'] = "Transaksi tidak ditemukan";
            return response($result);
        }

        if($transaction->status != 0)
        {
            $result['status'] = false;
            $result['message'] = "Transaksi tidak dapat diproses";
            return response($result);
        }

        $up = $transaction->update([
            'status' => 1
        ]);
        
        if($up)
        {
            $result['status'] = true;
            $result['message'] = "Transkasi berhasil diproses";
            return response($result);
        }

        $result['status'] = false;
        $result['message'] = "Gagal membatalkan transaksi";
        return response($result);
    }
    
    public function sent(Request $request,$id)
    {

        $transaction = Transaction::find($id);
        if(!$transaction)
        {
            $result['status'] = false;
            $result['message'] = "Transaksi tidak ditemukan";
            return response($result);
        }

        $request->validate([
            'waybill' => 'required|unique:App\Models\Transaction,waybill'
        ]);

        if($transaction->status != 1)
        {
            $result['status'] = false;
            $result['message'] = "Transaksi tidak dapat dikirim";
            return response($result);
        }

        $up = $transaction->update([
            'status' => 2,
            'waybill' => $request->waybill
        ]);
        
        if($up)
        {
            $result['status'] = true;
            $result['message'] = "Transkasi berhasil dikirim";
            return response($result);
        }

        $result['status'] = false;
        $result['message'] = "Gagal membatalkan transaksi";
        return response($result);
    }

    public function export()
    {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(base_path('public/storage/document/template-export-product.xlsx'));
        $spreadsheet->setActiveSheetIndex(0);
        
        $sheet = $spreadsheet->getActiveSheet();
        $data_no = 2;
        $transaction = Transaction::get();

        foreach ($transaction as $key) {

            $status = 'Tidak diketahui';

            if($key->status == '0')
            {
                $status = 'Menunggu';
            }elseif($key->status == '1')
            {
                $status = 'Diproses';
            }elseif($key->status == '2')
            {
                $status = 'Dikirim';
            }elseif($key->status == '3')
            {
                $status = 'Diterima';
            }elseif($key->status == '4')
            {
                $status = 'Selesai';
            }elseif($key->status == '5')
            {
                $status = 'Ditolak';
            }elseif($key->status == '6')
            {
                $status = 'Dibatalkan';
            }

            $sheet->setCellValue("A$data_no", $key->purchase_order);
            $sheet->setCellValue("B$data_no", $key->user->name);
            $sheet->setCellValue("C$data_no", $key->courier);
            $sheet->setCellValue("D$data_no", $key->shipping_price);
            $sheet->setCellValue("E$data_no", $key->waybill);
            $sheet->setCellValue("F$data_no", $key->created_at);
            $sheet->setCellValue("G$data_no", $key->total);
            $sheet->setCellValue("H$data_no", "Cash On Delivery (COD)");
            $sheet->setCellValue("I$data_no", $status);

            $data_no++;
        }
        
        $spreadsheet->setActiveSheetIndex(0);
        $writer = new Xlsx($spreadsheet);
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment; filename="' . "Data Transaksi - ".date('d-M-Y').".xlsx");
        $writer->save("php://output");
        die;
    }
}
