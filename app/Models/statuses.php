<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statuses extends Model
{
    public $timestamps = false;
    public function order()
    {
        return $this->belongsTo(Orders::class);
    }
}
