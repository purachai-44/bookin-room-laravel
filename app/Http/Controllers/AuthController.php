<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;

class AuthController extends Controller
{
    public function showLoginForm() 
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->only('member_id', 'password');

    $request->validate([
        'member_id' => 'required',
        'password' => 'required',
    ],[
        'member_id.required' => 'กรุณาใส่รหัสนักศึกษา',
        'password.required' => 'กรุณาใส่รหัสผ่าน'
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $roleMessage = $user->role === 'admin' ? 'ผู้ดูแลระบบ' : $user->role;
        return redirect()->intended('/')->with('success', "เข้าสู่ระบบสำเร็จ: $roleMessage");
    }

    // กรณีล็อกอินไม่สำเร็จ
    return back()->withErrors([
        'member_id' => 'รหัสนักศึกษาไม่ถูกต้อง หรือรหัสผ่านผิดพลาด',
    ])->withInput();
}

    
    

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // การตรวจสอบข้อมูล
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|unique:members',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password', // ตรวจสอบรหัสผ่านยืนยัน
            'first_name' => ['required', 'regex:/^[ก-๙a-zA-Z]+$/u'],
            'last_name' => ['required', 'regex:/^[ก-๙a-zA-Z]+$/u'],
            'role' => 'required',
            'phone' => 'required',
        ], [
            'member_id.required' => 'กรุณาใส่รหัสนักศึกษาให้ถูกต้อง',
            'member_id.unique' => 'รหัสนักศึกษานี้ถูกใช้ไปแล้ว',
            'password.required' => 'กรุณาใส่รหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องมีอย่างน้อย 8 ตัว',
            'password_confirmation.required' => 'กรุณายืนยันรหัสผ่าน',
            'password_confirmation.same' => 'รหัสผ่านไม่ตรงกัน',
            'first_name.required' => 'กรุณาใส่ชื่อ',
            'first_name.regex' => 'ชื่อไม่สามารถมีตัวเลข',
            'last_name.required' => 'กรุณาใส่นามสกุล',
            'last_name.regex' => 'นามสกุลไม่สามารถมีตัวเลข',
            'role.required' => 'กรุณาเลือกสถานะ',
            'phone.required' => 'กรุณาใส่เบอร์โทรให้ถูกต้อง',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        // เข้ารหัสรหัสผ่าน
        $data = $validator->validated();
        $data['password'] = bcrypt($data['password']);
    
        // บันทึกข้อมูลสมาชิกลงฐานข้อมูล
        Member::create($data);
    
        // เปลี่ยนเส้นทางไปที่หน้าล็อกอิน
        return redirect()->route('login')->with('success', 'สมัครสมาชิกสำเร็จ');
    }
    





    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
