<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('order_feedbacks', function (Blueprint $table) {
$table->id();
        $table->unsignedBigInteger('order_id');
        $table->string('message', 1000);
        $table->dateTime('time_message')->default(DB::raw('CURRENT_TIMESTAMP'));
        $table->tinyInteger('belong')->comment('0 là khách, 1 là admin');

        $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    public function down(): void {
        Schema::dropIfExists('order_feedbacks');
    }
};
