<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    // Tên bảng
    protected $table = 'invoices';

    // Khóa chính
    protected $primaryKey = 'id';

    // Không dùng timestamps
    public $timestamps = false;

    // Các field cho phép fill
    protected $fillable = [
        'order_id',
        'invoice_pdf',
        'date_export',
        'user_id',
    ];

    /**
     * Quan hệ: Mỗi hóa đơn thuộc về một đơn hàng
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Quan hệ: Mỗi hóa đơn được xuất bởi một user (nhân viên/admin)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
