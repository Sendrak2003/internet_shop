<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Categories extends Model
{
    public $timestamps = false;
    public function product()
    {
        return $this->hasOne(Products::class, 'cat_id');
    }

}
