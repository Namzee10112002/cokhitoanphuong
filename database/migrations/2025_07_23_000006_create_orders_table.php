<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
$table->id();
        $table->unsignedBigInteger('user_id');
        $table->tinyInteger('method_pay')->default(0)->comment('0 là thanh toán khi nhận hàng, 1 là chuyển khoản, 2 là ví điện tử');
        $table->tinyInteger('status_order')->default(0)->comment('0 là chờ xác nhận, 1 đã xác nhận, 2 đang vận chuyển, 3 đã giao hàng, 4 Hủy');
        $table->string('address_order');
        $table->string('phone_order', 10);
        $table->float('total_order');
        $table->string('note_order');
        $table->dateTime('date_order')->default(DB::raw('CURRENT_TIMESTAMP'));

        $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
