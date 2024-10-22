<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'status',
    ];

    /**
     * Get the category for the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function kardexes()
    {
        return $this->hasMany(Kardex::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function stock()
    {
        return $this->purchases()->sum('stock');
    }

    public function balance()
    {
        return $this->purchases()->sum('balance');
    }

    public function currentProductEntry()
    {
        return $this->kardexes()->sum('product_entry');
    }

    public function currentProductExit()
    {
        return $this->kardexes()->sum('product_exit');
    }

    public function currentEntry()
    {
        return $this->kardexes()->sum('amount_entry');
    }

    public function currentExit()
    {
        return $this->kardexes()->sum('amount_exit');
    }
}
