<?php

namespace App\Http\Controllers;

use App\Models\VerifyFingerprint;
use App\Models\Reservation;  // ตรวจสอบว่าคุณใช้โมเดล Reservation
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // เพิ่มการอิมพอร์ต Auth
use Carbon\Carbon;
use TCPDF;

class VerifyFingerprintController extends Controller 
{
    public function index(Request $request)
    {
        // ดึงข้อมูลสมาชิกที่เข้าสู่ระบบ
        $user = Auth::user();
    
        // เริ่มต้น query การจองที่ตรงกับสมาชิกที่เข้าสู่ระบบ
        $query = Reservation::where('member_id', $user->member_id)
                            ->where('status', 'approved');  // เฉพาะการจองที่อนุมัติแล้ว
    
        // ถ้ามีการเลือกวันที่ ให้กรองข้อมูลตามวันที่
        if ($request->has('date')) {
            $date = Carbon::parse($request->input('date'))->setTimezone('Asia/Bangkok')->startOfDay();  // ตั้ง timezone สำหรับวันที่
            $query->whereDate('start_date', '<=', $date)
                  ->whereDate('end_date', '>=', $date);  // กรองรายการจองที่อยู่ในช่วงวันที่
        }
    
// ดึงข้อมูลการจอง
        $reservations = $query->get();

        // วนลูปเพื่อตรวจสอบการสแกนลายนิ้วมือที่ตรงกับช่วงเวลาของการจอง
        foreach ($reservations as $reservation) {
            // ดึงข้อมูลการสแกนลายนิ้วมือที่มี time_in ในช่วงเวลาการจองสำหรับแต่ละ reservation
            $fingerprintScans = VerifyFingerprint::where('fingerprint_data', $user->fingerprint_data)  // กรองตามลายนิ้วมือของผู้ใช้ที่เข้าสู่ระบบ
                ->where(function ($query) use ($reservation) {
                    $query->where(function ($q) use ($reservation) {
                        $q->whereDate('time_in', '=', $reservation->start_date) // ตรวจสอบวันที่ตรงกับ start_date
                        ->whereTime('time_in', '>=', $reservation->start_time)  // ตรวจสอบว่า time_in มากกว่าหรือเท่ากับ start_time
                        ->whereTime('time_in', '<=', $reservation->end_time);  // ตรวจสอบว่า time_in น้อยกว่าหรือเท่ากับ end_time
                    })->orWhere(function ($q) use ($reservation) {
                        $q->whereDate('time_in', '>=', $reservation->start_date) // ตรวจสอบว่า time_in อยู่ในช่วง start_date
                        ->whereDate('time_in', '<=', $reservation->end_date)  // ตรวจสอบว่า time_in อยู่ในช่วง end_date
                        ->where(function ($subQuery) use ($reservation) {
                            $subQuery->whereTime('time_in', '>=', $reservation->start_time)  // ตรวจสอบว่า time_in อยู่ในช่วงเวลา start_time
                                    ->whereTime('time_in', '<=', $reservation->end_time);  // ตรวจสอบว่า time_in อยู่ในช่วงเวลา end_time
                        });
                    });
                })
                ->get();

    // ตรวจสอบว่ามีการสแกนลายนิ้วมือในช่วงเวลาของการจอง
    $reservation->is_verified = $fingerprintScans->isNotEmpty();
}

    
        // ส่งข้อมูลไปยัง view
        return view('fingerprints.index', compact('reservations'));
    }
    
    
    

    public function v_pdf(Request $request)
    {
        // ตรวจสอบว่ามีการส่งค่า date หรือไม่
        $query = VerifyFingerprint::select('first_name', 'last_name', 'time_in');
    
        if ($request->has('date')) {
            $date = \Carbon\Carbon::parse($request->input('date'))->startOfDay();
            $query->whereDate('time_in', $date);
        }
    
        // ดึงข้อมูลที่ถูกกรองแล้ว
        $fingerprints = $query->get();
    
        // Create a new TCPDF instance
        $pdf = new TCPDF();
        $pdf->AddPage();
    
        // ตรวจสอบว่าได้เพิ่มฟอนต์ภาษาไทย (THSarabun) อย่างถูกต้องหรือไม่
        $pdf->SetFont('thsarabun', '', 12); // ใช้ฟอนต์ภาษาไทยที่ถูกติดตั้ง
    
        // Set content
        $html = '<h2>รายชื่อที่เข้าห้อง</h2>';
        $html .= '<table border="1" cellpadding="4">';
        $html .= '<thead>
                    <tr>
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>วันและเวลาที่เข้า</th>
                    </tr>
                  </thead><tbody>';
    
        foreach ($fingerprints as $fingerprint) {
            $html .= '<tr>
                        <td>' . $fingerprint->first_name . '</td>
                        <td>' . $fingerprint->last_name . '</td>
                        <td>' . \Carbon\Carbon::parse($fingerprint->time_in)->locale('th')->translatedFormat('j F Y H:i น.') . '</td>
                      </tr>';
        }
    
        $html .= '</tbody></table>';
    
        // Write HTML to the PDF
        $pdf->writeHTML($html, true, false, true, false, '');
    
        // Output the PDF to browser
        $pdf->Output('fingerprint_report.pdf', 'I'); 
    }
}
