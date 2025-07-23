<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
$table->id();
        $table->string('code_product')->unique();
        $table->string('image_product', 1000);
        $table->string('description', 1000);
        $table->string('name_product');
        $table->float('price');
        $table->unsignedBigInteger('promotion_id');
        $table->unsignedBigInteger('category_id');
        $table->unsignedBigInteger('supplier_id');
        $table->integer('quantity');
        $table->string('unit');
        $table->tinyInteger('status_product')->default(0)->comment('0 là khả dụng, 1 là bị khóa, 2 là đang sale');

        $table->foreign('promotion_id')->references('id')->on('promotion');
        $table->foreign('category_id')->references('id')->on('category_product');
        $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};
