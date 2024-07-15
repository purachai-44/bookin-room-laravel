<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function edit()
    {
        $member = Auth::user();
        return view('members.edit', compact('member'));
    }

    public function update(Request $request)
    {
        $member = Auth::user();
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
        ]);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $member->update($data);
        return redirect()->route('members.edit')->with('success', 'Profile updated successfully');
    }

    public function destroy()
    {
        $member = Auth::user();
        $member->delete();
        return redirect('/');
    }
}

