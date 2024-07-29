<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Approval;
use Illuminate\Support\Facades\Auth;
use PDF;


class ReservationController extends Controller
{
    public function index(Request $request)
    {
    
        $user = Auth::user();
        $isAdmin = $user->role === 'admin';


        $search = $request->input('search');


        $query = Reservation::with('room');

        if (!$isAdmin) {

            $query->where('member_id', $user->member_id);
        }

        if ($search) {

            $query->whereHas('member', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%");
            });
    }


    $reservations = $query->paginate(10);

    return view('reservations.index', compact('reservations', 'search'));
}


    public function create()
    {
        $rooms = Room::all();
        return view('reservations.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'purpose' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'room_id' => 'required|exists:rooms,room_id',
        ]);

        $data['member_id'] = Auth::id();
        $data['status'] = 'pending';

        Reservation::create($data);
        return redirect()->route('reservations.index')->with('success', 'การบันทึกสำเร็จ');
    }

    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }
 
    public function edit(Reservation $reservation)
    {
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

        Approval::where('reservation_id', $reservation->reservation_id)->delete();


        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'ลบสำเร็จ');
    }

    

    public function getEvents()
    {
        $reservations = Reservation::where('status', 'approved')->get();
    
        $events = [];
    
        foreach ($reservations as $reservation) {
            $events[] = [
                'title' => $reservation->purpose,
                'start' => $reservation->start_date . 'T' . $reservation->start_time,
                'end' => $reservation->end_date . 'T' . $reservation->end_time,
                'description' => $reservation->room->room_name,
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

    public function exportPdf(){
        $reservations = Reservation::with(['member','room'])->get();
        $pdf = PDF::loadView('reservations.pdf',compact('reservations'));
        return $pdf->download('reservations.pdf');
    }
}
