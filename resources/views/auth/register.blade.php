@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">สมัครสมาชิก</div>
            <div class="card-body">
                <form id="register-form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="member_id" class="form-label">รหัสนักศึกษา</label>
                        <input type="text" class="form-control" id="member_id" name="member_id"  placeholder="รหัสนักศึกษา" required autofocus>
                        @error('member_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3"> 
                        <label for="password" class="form-label">รหัสผ่าน</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="ไม่น้อยกว่า 8 ตัว" required>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">ยืนยันรหัสผ่าน</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="first_name" class="form-label">ชื่อ</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"  required>
                        @error('first_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="last_name" class="form-label">นามสกุล</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                        @error('last_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="role" class="form-label">สถานะ</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="">-</option>
                            <option value="student">นักศึกษา</option>
                            <option value="admin">อาจารย์</option>
                            <option value="other">อื่นๆ</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">เบอร์โทร</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder=" "  required>
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="button" class="btn btn-primary" onclick="confirmRegister()">สมัครสมาชิก</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmRegister() {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณต้องการสมัครสมาชิกหรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, สมัครสมาชิกเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('register-form').submit();
            }
        });
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'สมัครสมาชิกสำเร็จ!',
            showConfirmButton: false,
            timer: 1500
        });
    @endif
</script>


@endsection
