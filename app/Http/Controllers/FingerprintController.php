<?php

namespace App\Http\Controllers;

use App\Models\Fingerprint;
use Illuminate\Http\Request;
 
class FingerprintController extends Controller
{

        public function store(Request $request)
        {
            // รับข้อมูลลายนิ้วมือ
            $fingerprintData = $request->input('fingerprint_data');
    
            // ตรวจสอบและบันทึกข้อมูลลายนิ้วมือ
            $fingerprint = new Fingerprint();
            $fingerprint->user_id = auth()->id(); // เชื่อมโยงกับผู้ใช้ปัจจุบัน
            $fingerprint->data = $fingerprintData;
            $fingerprint->save();
    
            return response()->json(['message' => 'บันทึกลายนิ้วมือสำเร็จ']);
        }
    
    
}



