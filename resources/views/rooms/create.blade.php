@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">เพิ่มห้อง</div>
            <div class="card-body">
                <form method="POST" action="{{ route('rooms.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="room_name" class="form-label">ชื่อห้อง</label>
                        <input type="text" class="form-control" id="room_name" name="room_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="capacity" class="form-label">ความจุ</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" required>
                    </div>
                    <div class="mb-3">
                        <label for="equipment" class="form-label">อุปการณ์ถายในห้อง</label>
                        <textarea class="form-control" id="equipment" name="equipment"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">เพิ่ม</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
