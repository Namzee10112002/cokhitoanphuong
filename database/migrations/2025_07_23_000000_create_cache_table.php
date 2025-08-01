<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('cache', function (Blueprint $table) {
$table->string('key')->primary();
        $table->mediumText('value');
        $table->integer('expiration');
        });
    }

    public function down(): void {
        Schema::dropIfExists('cache');
    }
};
