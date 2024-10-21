<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'operation_date',
        'detail',
        'product_entry',
        'product_exit',
        'product_stock',
        'cost_unit',
        'amount_entry',
        'amount_exit',
        'amount_stock',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
