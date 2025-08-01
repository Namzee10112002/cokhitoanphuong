<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('jobs', function (Blueprint $table) {
$table->id();
        $table->string('queue');
        $table->longText('payload');
        $table->tinyInteger('attempts');
        $table->unsignedInteger('reserved_at')->nullable();
        $table->unsignedInteger('available_at');
        $table->unsignedInteger('created_at');
        $table->index('queue');
        });
    }

    public function down(): void {
        Schema::dropIfExists('jobs');
    }
};
