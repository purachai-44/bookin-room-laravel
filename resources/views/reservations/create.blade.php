@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">จองห้องเรียน</div>
            <div class="card-body">
                <form id="reservation-form" method="POST" action="{{ route('reservations.store') }}" id="reservationForm">
                    @csrf
                    <div class="mb-3">
                        <label for="purpose" class="form-label">วัตถุประสงค์</label>
                        <input type="text" class="form-control" id="purpose" name="purpose" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_time" class="form-label">เวลา</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" required>    
                    </div>
                    <div class="mb-3">
                        <label for="end_time" class="form-label">ถึง</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">วันที่</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">ถึง</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="room_id" class="form-label">ห้อง</label>
                        <select class="form-control" id="room_id" name="room_id" required>
                            @foreach($rooms as $room)
                            <option value="{{ $room->room_id }}">{{ $room->room_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="confirmReservation()">ยืนยันการจอง</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmReservation() {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณต้องการยืนยันการจองห้องเรียนนี้หรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, จองเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) { 
                document.getElementById('reservation-form').submit();
            } 
        });
    }
</script>
@endsection
