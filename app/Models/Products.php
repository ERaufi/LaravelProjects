<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'quantity',
        'buyingPrice',
        'sellingPrice',
        'description',
        'weight',
        'image_url',
    ];


    // protected $appends = ['buyingPriceWithCurrency'];
    public function getbuyingPriceWithCurrencyAttribute()
    {
        return formatCurrency($this->attributes['buyingPrice'], 'AFN', 6);
    }
}
