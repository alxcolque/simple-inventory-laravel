<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'client_id',
        'quantity',
        'price',
        'total',
        'status',
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
