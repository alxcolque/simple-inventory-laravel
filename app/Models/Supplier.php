<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'cinit',
        'full_name',
        'email',
        'phone',
    ];



    /**
     * Get the purchases for the supplier.
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
