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
        Schema::dropIfExists('verify_fingerprint');  
        Schema::create('verify_fingerprint', function (Blueprint $table) {
            $table->id();  // ตั้งค่า primary key เป็น id
            $table->string('fingerprint_data');  // ต้องมีชนิดข้อมูลเหมือนกับในตาราง `fingerprints`
            $table->string('first_name');
            $table->string('last_name');
            $table->timestamp('time_in')->nullable();  // เพิ่มคอลัมน์ time_in ที่เป็น timestamp
            $table->timestamps();  // คอลัมน์ created_at และ updated_at จะถูกสร้างโดยอัตโนมัติ
        
            // สร้าง foreign key เชื่อมกับ `fingerprints`
            $table->foreign('fingerprint_data')->references('fingerprint_data')
                  ->on('fingerprints')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verify_fingerprint');
    }
};
