<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;

    protected $table = 'category_product';

    protected $fillable = [
        'name_category',
        'status_category'
    ];
    public static function getActiveCategories()
{
    return self::where('status_category', 0)
        ->orderBy('id', 'asc')
        ->get();
}

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
