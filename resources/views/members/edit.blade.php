@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">แก้ไขโปรไฟล์</div>
            <div class="card-body">
                <form method="POST" action="{{ route('members.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="first_name" class="form-label">ชื่อ</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $member->first_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">นามสกุล</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $member->last_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">เบอร์โทร</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $member->phone }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">รหัสผ่าน (ไม่ต้องใส่หากไม่ต้องการเปลียน)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">อัพเดท</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
