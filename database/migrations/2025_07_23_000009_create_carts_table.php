<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('carts', function (Blueprint $table) {
$table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('product_id');
        $table->integer('quantity');

        $table->foreign('user_id')->references('id')->on('users');
        $table->foreign('product_id')->references('id')->on('products');
        });
    }

    public function down(): void {
        Schema::dropIfExists('carts');
    }
};
