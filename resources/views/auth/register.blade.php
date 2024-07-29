@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">สมัครสมาชิก</div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="member_id" class="form-label">รหัสนักศึกษา</label>
                        <input type="text" class="form-control" id="member_id" name="member_id" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">รหัสผ่าน</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">ชือ</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">นามสกุล</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">สถานะ</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="">-</option>
                            <option value="student">นักศึกษา</option>
                            <option value="teacher">อาจารย์</option>
                            <option value="other">อื่นๆ</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">เบอร์โทร</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <button type="submit" class="btn btn-primary">สมัครสมาชิก</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

