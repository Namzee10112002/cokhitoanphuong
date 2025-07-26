<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderFeedback extends Model
{
    use HasFactory;

    protected $table = 'order_feedbacks';

    protected $fillable = [
        'order_id',
        'message',
        'time_message',
        'belong'
    ];

    protected $casts = [
        'time_message' => 'datetime'
    ];
 public $timestamps = false;
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
