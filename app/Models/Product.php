<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'code_product',
        'image_product',
        'description',
        'name_product',
        'price',
        'promotion_id',
        'category_id',
        'supplier_id',
        'quantity',
        'unit',
        'status_product'
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function category()
    {
        return $this->belongsTo(CategoryProduct::class, 'category_id');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
