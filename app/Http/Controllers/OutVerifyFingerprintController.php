<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OutVerifyFingerprint;
use App\Models\VerifyFingerprint;

class OutVerifyFingerprintController extends Controller
{
    public function index()
    {
        // Fetch data from both tables
        $outFingerprints = OutVerifyFingerprint::select('first_name', 'last_name', 'time_out')->get();

        // Pass the data to the view
        return view('fingerprints.index', compact('outFingerprints'));
    }
}

