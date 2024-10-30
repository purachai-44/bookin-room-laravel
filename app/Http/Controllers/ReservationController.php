<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Approval;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use TCPDF;


class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'admin';
        
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');
        $room = $request->input('room');
    
        $query = Reservation::with('room');
        
        // กรองข้อมูลเฉพาะผู้ใช้ปัจจุบัน ถ้าไม่ใช่แอดมิน
        if (!$isAdmin) {
            $query->where('member_id', $user->member_id);
        }
    
        // ค้นหาตามวัตถุประสงค์
        if ($search) {
            $query->where('purpose', 'like', "%{$search}%");
        }
    
        // ค้นหาตามวันที่เริ่มต้น
        if ($startDate) {
            $query->where('start_date', '>=', $startDate);
        }
    
        // ค้นหาตามวันที่สิ้นสุด
        if ($endDate) {
            $query->where('end_date', '<=', $endDate);
        }
    
        // ค้นหาตามสถานะการจอง
        if ($status) {
            $query->where('status', $status);
        }
    
        // ค้นหาตามห้อง
        if ($room) {
            $query->whereHas('room', function($q) use ($room) {
                $q->where('room_name', 'like', "%{$room}%");
            });
        }
    
        $reservations = $query->paginate(10);
    
        foreach ($reservations as $reservation) {
            $reservation->formatted_start_date = Carbon::parse($reservation->start_date)->translatedFormat('j M') .' '. (Carbon::parse($reservation->start_date)->year + 543);
            $reservation->formatted_end_date = Carbon::parse($reservation->end_date)->translatedFormat('j M') .' '. (Carbon::parse($reservation->end_date)->year + 543);
        }

        
    
        return view('reservations.index', compact('reservations'));
    }
    
    
    


    public function create()
    {
        $rooms = Room::all();
        return view('reservations.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'purpose' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'room_id' => 'required|exists:rooms,room_id',
        ]);
    
  
        $existingReservation = Reservation::where('room_id', $data['room_id'])
            ->where('status', 'approved')
            ->where(function ($query) use ($data) {
                $query->where(function ($query) use ($data) {

                    $query->where('start_date', $data['start_date'])
                          ->where('end_date', $data['end_date'])
                          ->where(function ($q) use ($data) {
    
                              $q->where('start_time', '<', $data['end_time'])
                                ->where('end_time', '>', $data['start_time']);
                          });
                });
            })
            ->first();
    
        if ($existingReservation) {
            return redirect()->route('reservations.index')->with('error', 'ช่วงเวลานี้ถูกจองไปแล้ว กรุณาเลือกช่วงเวลาอื่น');
        }
    

        $data['member_id'] = Auth::id();
        $data['status'] = 'pending'; 
    
        Reservation::create($data);
    

        return redirect()->route('reservations.index')->with('success', 'การจองสำเร็จ');
    }
    
    
    

    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }
 
    public function edit(Reservation $reservation)
    {
        if ($reservation->status === 'approved') {
            return redirect()->route('reservations.index')->with('error', 'การจองนี้ได้รับการอนุมัติแล้ว ไม่สามารถแก้ไขได้');
        } 

        $rooms = Room::all();
        return view('reservations.edit', compact('reservation', 'rooms'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $data = $request->validate([
            'purpose' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'room_id' => 'required|exists:rooms,room_id',
        ]);

        $reservation->update($data);
        return redirect()->route('reservations.index')->with('success', 'อัพเดทสำเร็จ');
    }

    public function destroy(Reservation $reservation)
    {
 
        if ($reservation->status === 'approved') {
            return redirect()->route('reservations.index')->with('error', 'การจองนี้ได้รับการอนุมัติแล้ว ไม่สามารถยกเลิกได้');
        }

        Approval::where('reservation_id', $reservation->reservation_id)->delete();

        $reservation->delete();
    
        return redirect()->route('reservations.index')->with('success', 'ลบสำเร็จ');
    }
    

    

    public function getEvents()
    {
        $reservations = Reservation::with('room')
            ->where('status', 'approved')
            ->select('purpose', 'start_date', 'start_time', 'end_date', 'end_time', 'room_id', 'status')
            ->get();
    
        $events = [];
    
        foreach ($reservations as $reservation) {
            $events[] = [
                'title' => $reservation->purpose,
                'start' => $reservation->start_date . 'T' . $reservation->start_time,
                'end' => $reservation->end_date . 'T' . $reservation->end_time,
                'extendedProps' => [
                    'description' => $reservation->room->room_name
                ],
                'color' => $this->getStatusColor($reservation->status),
            ];
        }
    
        return response()->json($events);
    }
    
    
    
    

    private function getStatusColor($status)
    {
        switch ($status) {
            case 'approved':
                return 'green';
            case 'rejected':
                return 'red';
            case 'pending':
            default:
                return 'blue';
        }
    }

    
    // public function generatePdf($id)
    // {
    //     // ดึงข้อมูลการจองที่มี reservation_id ตรงกับที่เลือก
    //     $reservation = Reservation::with('member', 'room')->findOrFail($id);
    
    //     // สร้าง instance ของ TCPDF
    //     $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, [80, 200], true, 'UTF-8', false);

    
    //     // ตั้งค่าเอกสาร
    //     $pdf->SetCreator(PDF_CREATOR);
    //     $pdf->SetAuthor('Your Company');
    //     $pdf->SetTitle('Reservation Details');
    //     $pdf->SetSubject('Reservation Details');
    //     $pdf->SetHeaderData('', 0, 'IT', 'Rajamangala University of Technology Lanna Tak');
    //     $pdf->setFooterData('', array(0,64,0), array(0,64,128));
    
    //     // ตั้งค่าฟอนต์
    //     $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    //     $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    //     $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    //     $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    //     $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    //     $pdf->SetFont('thsarabun', '', 12); // ใช้ฟอนต์ THSarabun
    
    //     // เพิ่มหน้าใหม่
    //     $pdf->AddPage();
    
    //     // สร้าง HTML สำหรับ PDF
    //     $html = '
    //     <h1>รายละเอียดการจอง</h1>
    //     <p><strong>ชื่อผู้จอง :</strong> ' . ($reservation->member ? $reservation->member->first_name . ' ' . $reservation->member->last_name : 'ไม่ทราบชื่อ') . '</p>
    //     <p><strong>วัตถุประสงค์ :</strong> ' . $reservation->purpose . '</p>
    //     <p><strong>ห้องที่ใช้ :</strong> ' . $reservation->room->room_name . '</p>
    //     <p><strong>เวลา :</strong> ' . $reservation->start_time . ' <strong>ถึง :</strong> ' . $reservation->end_time . '</p>
    //     <p><strong>วันที่ :</strong> ' . $reservation->start_date . ' <strong>ถึง :</strong> ' . $reservation->end_date . '</p>
    //     <p><strong>สถานะ :</strong> ';
    
    //         if ($reservation->status == 'pending') {
    //             $html .= '<span class="badge rounded-pill bg-primary p-2 text-white">รออนุมัติ</span>';
    //         } elseif ($reservation->status == 'approved') {
    //             $html .= '<span class="badge rounded-pill bg-success p-2 text-white">อนุมัติ</span>';
    //         } elseif ($reservation->status == 'rejected') {
    //             $html .= '<span class="badge rounded-pill bg-danger p-2 text-white">ไม่อนุมัติ</span>';
    //         }
            
    //         $html .= '</p>';
    
    
    //     // เขียน HTML ลงใน PDF
    //     $pdf->writeHTML($html, true, false, true, false, '');
    
    //     // ส่ง PDF ไปยัง browser
    //     $pdf->Output('reservation_' . $id . '.pdf', 'I');
    // }
    

    public function pdf2(Request $request)
    {
        // รับค่าการกรองจาก request
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $status = $request->input('status');
        $room = $request->input('room');
        $search = $request->input('search');
        $user = Auth::user();
        $isAdmin = $user->role === 'admin';
        
        // สร้าง query ดึงข้อมูลการจอง
        $query = Reservation::with('room', 'member');

        if (!$isAdmin) {
            $query->where('member_id', $user->member_id);
        }
    
        // กรองตามวันที่
        if ($start_date && $end_date) {
            $query->whereBetween('start_date', [$start_date, $end_date]);
        }
    
        // กรองตามสถานะ
        if ($status) {
            $query->where('status', $status);
        }
    
        // กรองตามห้อง
        if ($room) {
            $query->whereHas('room', function($q) use ($room) {
                $q->where('room_name', 'like', "%{$room}%");
            });
        }
    
        // กรองตามวัตถุประสงค์
        if ($search) {
            $query->where('purpose', 'like', "%{$search}%");
        }
    
        // ดึงข้อมูลตามเงื่อนไข
        $reservations = $query->get();
    
        // สร้าง TCPDF instance
        $pdf = new TCPDF();
        $pdf->AddPage();
    
        // ตั้งค่าฟอนต์
        $pdf->SetFont('thsarabun', '', 12);
    
        // สร้าง header ของตาราง
        $html = '<h1>รายงานการจอง</h1>';
        $html .= '<table border="1" cellpadding="4">
            <thead>
                <tr>
                    <th class="text-nowrap">วัตถุประสงค์</th>
                    <th>ชื่อผู้จอง</th>
                    <th>เวลาเริ่ม</th>
                    <th>เวลาสิ้นสุด</th>
                    <th class="text-nowrap">วันที่เริ่ม</th>
                    <th class="text-nowrap">วันที่สิ้นสุด</th>
                    <th class="text-nowrap">ห้อง</th>
                    <th>สถานะ</th>
                </tr>
            </thead>
            <tbody>';
    
       
        if ($reservations->isEmpty()) {
            $html .= '<tr><td colspan="8" class="text-center">ไม่พบการจอง</td></tr>';
        } else {

            foreach ($reservations as $reservation) {
                $html .= '<tr>
                    <td class="text-nowrap">' . $reservation->purpose . '</td>
                    <td>' . ($reservation->member ? $reservation->member->first_name . ' ' . $reservation->member->last_name : 'ไม่ทราบชื่อ') . '</td>
                    <td>' . Carbon::parse($reservation->start_time)->format('H:i') . '</td>
                    <td>' . Carbon::parse($reservation->end_time)->format('H:i') . '</td>
                    <td class="text-nowrap">' . Carbon::parse($reservation->start_date)->translatedFormat('j M Y') . '</td>
                    <td class="text-nowrap">' . Carbon::parse($reservation->end_date)->translatedFormat('j M Y') . '</td>
                    <td class="text-nowrap">' . $reservation->room->room_name . '</td>
                    <td>' . ($reservation->status == 'pending' ? 'รออนุมัติ' : ($reservation->status == 'approved' ? 'อนุมัติ' : 'ไม่อนุมัติ')) . '</td>
                </tr>';
            }
        }
    
        $html .= '</tbody></table>';
    
        // เขียน HTML ลงใน PDF
        $pdf->writeHTML($html, true, false, true, false, '');
    
        // สร้างไฟล์ PDF
        $pdf->Output('reservations_report.pdf', 'I'); // แสดงใน browser
    }
    

    

    
}
