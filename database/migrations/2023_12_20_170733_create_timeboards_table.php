<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timeboards', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('hour_start');
            $table->string('hour_end');
            $table->bigInteger('user_id')->unsigned();
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('user_id_sign')->unsigned();
            $table->index('user_id_sign');
            $table->foreign('user_id_sign')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('warehouse_id')->unsigned();
            $table->index('warehouse_id');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('timeboards');

    }
};
