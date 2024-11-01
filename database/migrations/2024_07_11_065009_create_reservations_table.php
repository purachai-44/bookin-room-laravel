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
        Schema::dropIfExists('reservations');  
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('reservation_id');
            $table->string('purpose');
            $table->time('start_time');
            $table->time('end_time');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('member_id');
            $table->unsignedBigInteger('room_id');
            $table->string('status')->default('pending');
            $table->foreign('member_id')->references('member_id')->on('members');
            $table->foreign('room_id')->references('room_id')->on('rooms');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
