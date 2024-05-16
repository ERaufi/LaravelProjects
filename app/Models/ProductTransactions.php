<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransactions extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
