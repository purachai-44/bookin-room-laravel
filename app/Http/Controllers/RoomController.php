<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

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

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'ลบสำเร็จ');
    }
}

