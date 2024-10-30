<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Approval;
use App\Models\Reservation;

class ApprovalController extends Controller
{
    public function index()
    {
        $reservations = Reservation::where('status', 'pending')->get();
        
        return view('approvals.index', compact('reservations'));
    }

    public function approve(Request $request, Reservation $reservation)
    {
        // ตรวจสอบว่ามีการจองที่ซ้อนทับกับห้องเดียวกันและสถานะ 'approved' หรือไม่
        $overlap = Reservation::where('room_id', $reservation->room_id)
            ->where('status', 'approved')
            ->where(function($query) use ($reservation) {
                $query->where(function($query) use ($reservation) {
                    // กรณีที่การจองซ้อนทับกันในวันเดียวกัน
                    $query->where('start_date', $reservation->start_date)
                          ->where('end_date', $reservation->end_date)
                          ->where(function ($query) use ($reservation) {
                              $query->where(function($q) use ($reservation) {
                                  // ตรวจสอบว่าเวลาทับซ้อนกันหรือไม่
                                  $q->where('start_time', '<', $reservation->end_time)
                                    ->where('end_time', '>', $reservation->start_time);
                              });
                          });
                });
            })
            ->exists();
    
        if ($overlap) {
            // ถ้ามีการจองซ้อนทับ ให้แสดงข้อความแจ้งข้อผิดพลาด
            return redirect()->route('approvals.index')->with('error', 'ห้องนี้ไม่ว่างในเวลาที่คุณต้องการจอง');
        }
    
        // ถ้าไม่มีการซ้อนทับ ให้อนุมัติการจอง
        $reservation->update(['status' => 'approved']);
        Approval::create([
            'reservation_id' => $reservation->reservation_id,
            'approval_status' => 'approved',
        ]);
    
        return redirect()->route('approvals.index')->with('success', 'การจองได้รับการอนุมัติ');
    }
    
    public function reject(Request $request, Reservation $reservation)
    {
        $reservation->update(['status' => 'rejected']);
        Approval::create([
            'reservation_id' => $reservation->reservation_id,
            'approval_status' => 'rejected',
        ]);

        return redirect()->route('approvals.index')->with('reject', 'ยกเลิกแล้ว');
    }
}

