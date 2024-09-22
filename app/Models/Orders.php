<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Orders extends Model
{

    public $timestamps = false;
    protected $fillable= [
        'product_id',
        'user_id',
        'orderDate',
        'deliveryDate',
        'price',
        'quantityProduct',
        'status_id',
        ];
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function status()
    {
        return $this->belongsTo(statuses::class);
    }
}
