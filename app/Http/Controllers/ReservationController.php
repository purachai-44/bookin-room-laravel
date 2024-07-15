<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::where('status', 'approved')->get();
        return view('welcome', compact('reservations'));
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
        return redirect()->route('reservations.index')->with('success', 'Reservation request submitted successfully');
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
        return redirect()->route('reservations.index')->with('success', 'Reservation updated successfully');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservation canceled successfully');
    }

    public function events()
    {
        $reservations = Reservation::where('status', 'approved')->get();
        $events = [];

        foreach ($reservations as $reservation) {
            $events[] = [
                'title' => $reservation->purpose,
                'start' => $reservation->start_date . 'T' . $reservation->start_time,
                'end' => $reservation->end_date . 'T' . $reservation->end_time,
                'description' => $reservation->room->room_name,
            ];
        }

        return response()->json($events);
    }
}

