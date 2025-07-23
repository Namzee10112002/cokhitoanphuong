<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('order_details', function (Blueprint $table) {
$table->id();
        $table->unsignedBigInteger('order_id');
        $table->unsignedBigInteger('product_id');
        $table->integer('quantity');
        $table->float('total_detail');
        $table->tinyInteger('status_detail')->default(0)->comment('0 là sản phẩm oke, 1 là sản phẩm có lỗi chờ thu hồi, 2 sản phẩm được thu hồi chờ xử lý,3 đã xử lý xong.');

        $table->foreign('order_id')->references('id')->on('orders');
        $table->foreign('product_id')->references('id')->on('products');
        });
    }

    public function down(): void {
        Schema::dropIfExists('order_details');
    }
};
