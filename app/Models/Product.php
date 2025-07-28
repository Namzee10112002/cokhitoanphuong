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
        'sold',
        'unit',
        'status_product'
    ];
    public $timestamps = false;
    public static function getActiveProducts($limit = 20)
    {
        return self::select(
            'products.*',
            'promotion.name_promotion',
            'promotion.value'
        )
            ->leftJoin('promotion', function ($join) {
                $join->on('products.promotion_id', '=', 'promotion.id')
                    ->whereNotNull('products.promotion_id');
            })
            ->where('products.status_product', '!=', 1)
            ->orderBy('products.id', 'desc')
            ->limit($limit)
            ->get();
    }
    public static function getProductWithRelationsById($id)
    {
        return self::select(
            'products.*',
            'category_product.name_category',
            'suppliers.name_supplier',
            'promotion.name_promotion',
            'promotion.value'
        )
            ->join('category_product', 'products.category_id', '=', 'category_product.id')
            ->join('suppliers', 'products.supplier_id', '=', 'suppliers.id')
            ->leftJoin('promotion', function ($join) {
                $join->on('products.promotion_id', '=', 'promotion.id')
                    ->whereNotNull('products.promotion_id');
            })
            ->where('products.id', $id)
            ->where('products.status_product', '!=', 1)
            ->first();
    }
    public static function getRelatedProducts($categoryId, $currentProductId, $limit = 4)
    {
        return self::select(
            'products.*',
            'promotion.name_promotion',
            'promotion.value'
        )
            ->leftJoin('promotion', function ($join) {
                $join->on('products.promotion_id', '=', 'promotion.id')
                    ->whereNotNull('products.promotion_id');
            })
            ->where('products.category_id', $categoryId)
            ->where('products.status_product', '!=', 1)
            ->where('products.id', '!=', $currentProductId)
            ->orderBy('products.id', 'desc')
            ->limit($limit)
            ->get();
    }

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
    public function importProducts()
    {
        return $this->hasMany(ImportProduct::class);
    }
}
