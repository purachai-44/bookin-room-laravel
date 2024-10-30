<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation; 
use App\Models\Room;
use Carbon\Carbon;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_name' => 'required',
            'capacity' => 'required|integer',
            'equipment' => 'nullable',
        ]);

        Room::create($data);
        return redirect()->route('rooms.index')->with('success', 'เพิ่มห้องเรียนสำเร็จ!');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'room_name' => 'required',
            'capacity' => 'required|integer',
            'equipment' => 'nullable',
        ]);

        $room->update($data);
        return redirect()->route('rooms.index')->with('success', 'แก้ไขสำเร็จ');
    }

    public function show()
    {
        $currentDateTime = Carbon::now()->setTimezone('Asia/Bangkok');  
    
    
        $rooms = Room::all();
        
        foreach ($rooms as $room) {
    
        
            $currentReservation = Reservation::where('room_id', $room->room_id)
                ->where('status', 'approved')
                ->where(function ($query) use ($currentDateTime) {
                    $query->where(function ($q) use ($currentDateTime) {
                        $q->whereDate('start_date', '=', $currentDateTime->toDateString()) 
                          ->whereTime('start_time', '<=', $currentDateTime->toTimeString())  
                          ->whereTime('end_time', '>', $currentDateTime->toTimeString());  
                    })->orWhere(function ($q) use ($currentDateTime) {
                        $q->whereDate('start_date', '<=', $currentDateTime->toDateString()) 
                          ->whereDate('end_date', '>=', $currentDateTime->toDateString()) 
                          ->where(function ($subQuery) use ($currentDateTime) {
                              $subQuery->whereTime('start_time', '<=', $currentDateTime->toTimeString()) 
                                       ->whereTime('end_time', '>', $currentDateTime->toTimeString());
                          });
                    });
                })
                ->first();

            $room->is_occupied = $currentReservation !== null;
        }
    

        return view('rooms.show', compact('rooms', 'currentDateTime'));
    }
    
    
    

}
