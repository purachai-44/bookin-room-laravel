<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyFingerprint extends Model
{
    use HasFactory;

    // ชื่อตารางที่เชื่อมโยง
    protected $table = 'verify_fingerprint';

    // ฟิลด์ที่สามารถเพิ่มข้อมูลได้
    protected $fillable = ['fingerprint_data', 'first_name', 'last_name'];

    // เปิดการใช้งาน timestamps
    public $timestamps = true;
}
