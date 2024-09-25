<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_id',
        'price',
        'qty',
    ];

    /**
     * Get the product for the detail.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the client for the detail.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
