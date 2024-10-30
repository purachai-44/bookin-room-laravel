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
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed', 
        ]);

        $member = auth()->user();

        // ตรวจสอบว่ามีการกรอกรหัสผ่านปัจจุบัน
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $member->password)) {
                throw ValidationException::withMessages([
                    'current_password' => ['รหัสผ่านปัจจุบันไม่ถูกต้อง'],
                ]);
            }

            // อัปเดตรหัสผ่านใหม่ถ้าผ่านการตรวจสอบ
            $member->password = Hash::make($request->password);
        }

        // อัปเดตข้อมูลอื่นๆ
        $member->first_name = $request->first_name;
        $member->last_name = $request->last_name;
        $member->phone = $request->phone;

        $member->save();

        return redirect()->route('members.edit')->with('success', 'โปรไฟล์ได้รับการอัพเดทเรียบร้อยแล้ว');
    }

    public function destroy()
    {
        $member = Auth::user();
        $member->delete();
        return redirect('/');
    }

    public function upadmin()
    {
        // ดึงข้อมูลสมาชิกทั้งหมด
        $members = Member::all();
        return view('members.upadmin', compact('members'));
    }

    public function adminEdit($id)
    {
        \Log::info('ID received: ' . $id);

        $member = Member::findOrFail($id); 
        return view('members.adminedit', compact('member')); 
    }

    public function updateAdmin(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        
        // ตรวจสอบการ validate ข้อมูล
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'role' => 'required|string',
            'password' => 'nullable|string|min:8',
        ]);

        // อัปเดตรหัสผ่านถ้ามีการกรอก
        if ($request->filled('password')) {
            $member->password = Hash::make($request->password);
        }

        // อัปเดตข้อมูลอื่นๆ
        $member->first_name = $request->first_name;
        $member->last_name = $request->last_name;
        $member->phone = $request->phone;
        $member->role = $request->role;

        $member->save();

        return redirect()->route('members.upadmin')->with('success', 'ข้อมูลสมาชิกถูกอัพเดทเรียบร้อยแล้ว');
    }
    

    
    // public function updateRole(Request $request, $memberId)
    // {
    //     $request->validate([
    //         'role' => 'required|string|in:student,admin', // ตรวจสอบว่า role ต้องเป็น student หรือ admin เท่านั้น
    //     ]);
    
    //     $member = Member::findOrFail($memberId);
    //     $member->role = $request->role; // อัปเดต role ของสมาชิก
    //     $member->save();
    
    //     return redirect()->back()->with('success', 'Role ได้รับการอัปเดตเรียบร้อยแล้ว'); // ส่งข้อความแจ้งเตือน
    // }
    
    

}