<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
$table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('phone', 10);
        $table->string('address');
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
        $table->tinyInteger('role')->default(0)->comment('0 khách hàng, 1 nhân viên, 2 quản trị viên');
        $table->tinyInteger('status')->default(0)->comment('0 là hoạt động, 1 bị khóa');
        $table->dateTime('last_login');
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};
