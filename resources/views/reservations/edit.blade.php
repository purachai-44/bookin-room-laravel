@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">แก่ไขการจอง</div>
            <div class="card-body">
                <form method="POST" action="{{ route('reservations.update', $reservation->reservation_id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="purpose" class="form-label">วัตถุประสงค์</label>
                        <input type="text" class="form-control" id="purpose" name="purpose" value="{{ $reservation->purpose }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_time" class="form-label">เวลา</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" value="{{ $reservation->start_time }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_time" class="form-label">ถึง</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" value="{{ $reservation->end_time }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">วันที่</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $reservation->start_date }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">ถึง</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $reservation->end_date }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="room_id" class="form-label">ห้อง</label>
                        <select class="form-control" id="room_id" name="room_id" required>
                            @foreach($rooms as $room)
                            <option value="{{ $room->room_id }}" {{ $room->room_id == $reservation->room_id ? 'selected' : '' }}>{{ $room->room_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">อัพเดท</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
