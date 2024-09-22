<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Products extends Model
{
    public $timestamps = false;
    public function category()
    {
        return $this->belongsTo(Categories::class, 'cat_id');
    }
    public function orders()
    {
        return $this->hasMany(Orders::class);
    }

}
