<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fingerprint extends Model
{
    use HasFactory;

    // ชื่อของตารางที่ต้องการเชื่อมโยง
    protected $table = 'fingerprints';

    // ฟิลด์ที่สามารถเพิ่มข้อมูลได้
    protected $fillable = ['fingerprint_data', 'first_name', 'last_name'];

    // เปิดการใช้งาน timestamps
    public $timestamps = true;
}
