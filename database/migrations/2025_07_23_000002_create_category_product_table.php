<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('category_product', function (Blueprint $table) {
$table->id();
        $table->string('name_category');
        $table->tinyInteger('status_category')->default(0);
        });
    }

    public function down(): void {
        Schema::dropIfExists('category_product');
    }
};
