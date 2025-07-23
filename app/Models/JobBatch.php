<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobBatch extends Model
{
    use HasFactory;

    protected $table = 'job_batches';

    protected $guarded = []; // Cho phép mass-assignment tất cả các trường

    // Thêm các quan hệ nếu cần (hasMany, belongsTo, etc.)
}
