<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_name',
        'sale_price',
        'stock',
    ];

    public function client_products()
    {
        return $this->hasMany(ClientProduct::class);
    }
}
