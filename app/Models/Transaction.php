<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'date:d M Y, H:i'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function user_address()
    {
        return $this->belongsTo(UserAddress::class);
    }

    protected static function boot()
    {
        parent::boot();
        if(auth()->check())
        {
            self::creating(function($model){
                $model->number = Transaction::where('user_id',$model->user_id)->max('number') + 1;
                $model->purchase_order = "PO-".$model->user_id.'-'.str_pad($model->number, 5, 0, STR_PAD_LEFT);
            });
        }
    }

}
