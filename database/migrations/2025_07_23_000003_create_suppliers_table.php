<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('suppliers', function (Blueprint $table) {
$table->id();
        $table->string('name_supplier');
        $table->tinyInteger('status_supplier')->default(0);
        });
    }

    public function down(): void {
        Schema::dropIfExists('suppliers');
    }
};
