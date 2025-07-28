<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $table = 'promotion';

    protected $fillable = [
        'name_promotion',
        'value',
        'status_promotion'
    ];
    public $timestamps = false;
    public function products()
    {
        return $this->hasMany(Product::class, 'promotion_id');
    }
}
