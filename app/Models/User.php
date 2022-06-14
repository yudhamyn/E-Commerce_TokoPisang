<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function address()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function default_address()
    {
        return $this->hasOne(UserAddress::class)->where('default',1);
    }

    public function chat()
    {
        return $this->hasMany(Chat::class,'sender_id','id');
    }
}
