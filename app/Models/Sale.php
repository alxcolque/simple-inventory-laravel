<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'client_id',
        'total',
        'status',
    ];



    /**
     * Get the client for the sale.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the user for the sale.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }
    public function details()
    {
        return $this->hasMany(Detail::class);
    }

}
