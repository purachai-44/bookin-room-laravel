@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">แก้ไขห้อง</div>
            <div class="card-body">
                <form method="POST" action="{{ route('rooms.update', $room->room_id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="room_name" class="form-label">ชื่อห้อง</label>
                        <input type="text" class="form-control" id="room_name" name="room_name" value="{{ $room->room_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="capacity" class="form-label">ความจุ</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" value="{{ $room->capacity }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="equipment" class="form-label">อุปกรณ์ถายในห้อง</label>
                        <textarea class="form-control" id="equipment" name="equipment">{{ $room->equipment }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">อัพเดท</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
