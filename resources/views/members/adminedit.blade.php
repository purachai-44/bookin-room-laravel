@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">แก้ไขข้อมูลสมาชิก: {{ $member->first_name }} {{ $member->last_name }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('members.updateAdmin', $member->member_id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="first_name">ชื่อ</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $member->first_name }}" required>
                </div>
                <div class="form-group">
                    <label for="last_name">นามสกุล</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $member->last_name }}" required>
                </div>
                <div class="form-group">
                    <label for="phone">โทรศัพท์</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $member->phone }}" required>
                </div>
                <div class="form-group">
                    <label for="role">สถานะ</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="student" {{ $member->role == 'student' ? 'selected' : '' }}>สมาชิก</option>
                        <option value="admin" {{ $member->role == 'admin' ? 'selected' : '' }}>ผู้ดูแล</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">รหัสผ่านใหม่ (กรณีต้องการเปลี่ยน)</label>
                    <input type="password" name="password" id="password" class="form-control" minlength="8">
                </div>
                <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
            </form>
        </div>
    </div>
</div>
@endsection
