<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'supplier_id',
        'price',
        'revenue',
        'qty',
        'stock',
        'unit',
        'expiration_date',
        'iva',
        'balance',
        'created_at',
    ];

    /**
     * Get the product for the purchase.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the supplier for the purchase.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
