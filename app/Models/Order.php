<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'method_pay',
        'status_order',
        'address_order',
        'phone_order',
        'name_order',
        'total_order',
        'note_order',
        'date_order'
    ];

    protected $casts = [
        'date_order' => 'datetime'
    ];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(OrderFeedback::class, 'order_id');
    }
}
