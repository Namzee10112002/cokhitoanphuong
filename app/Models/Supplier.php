<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = [
        'name_supplier',
        'status_supplier'
    ];
    public $timestamps = false;
    public function products()
    {
        return $this->hasMany(Product::class, 'supplier_id');
    }
}
