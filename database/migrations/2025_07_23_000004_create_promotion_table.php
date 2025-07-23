<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('promotion', function (Blueprint $table) {
$table->id();
        $table->string('name_promotion');
        $table->integer('value');
        $table->tinyInteger('status_promotion')->default(0);
        });
    }

    public function down(): void {
        Schema::dropIfExists('promotion');
    }
};
