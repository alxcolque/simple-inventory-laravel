<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'cinit',
        'website',
    ];

    /**
     * Get the orders for the client.
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
