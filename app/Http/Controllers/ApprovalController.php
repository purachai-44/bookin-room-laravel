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
        $reservation->update(['status' => 'approved']);
        Approval::create([
            'reservation_id' => $reservation->reservation_id,
            'approval_status' => 'approved',
        ]);

        return redirect()->route('approvals.index')->with('success', 'Reservation approved successfully.');
    }

    public function reject(Request $request, Reservation $reservation)
    {
        $reservation->update(['status' => 'rejected']);
        Approval::create([
            'reservation_id' => $reservation->reservation_id,
            'approval_status' => 'rejected',
        ]);

        return redirect()->route('approvals.index')->with('success', 'Reservation rejected successfully.');
    }
}

