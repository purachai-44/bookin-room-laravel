@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">จองห้องเรียน</div>
            <div class="card-body">
                <!-- Display success or error message -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form id="reservation-form" method="POST" action="{{ route('reservations.store') }}">
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

                        <p class="mt-2 text-black-50">a.m. หลังเที่ยงคืนก่อนเที่ยงวัน (00.01 a.m. – 11.59 a.m.) <br>p.m.หลังเที่ยงวันก่อนเที่ยงคืน (12.00 p.m. – 11.59 p.m.)</p>
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
    // Get the form fields
    const purpose = document.getElementById('purpose').value;
    const startTime = document.getElementById('start_time').value;
    const endTime = document.getElementById('end_time').value;
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const roomId = document.getElementById('room_id').value;

    // Check if any field is empty
    if (!purpose || !startTime || !endTime || !startDate || !endDate || !roomId) {
        Swal.fire({
            icon: 'error',
            title: 'ข้อมูลไม่ครบ',
            text: 'กรุณาใส่ข้อมูลให้ครบทุกช่อง',
            confirmButtonText: 'ตกลง'
        });
        return; // Stop the form submission if validation fails
    }

    // If all fields are filled, show confirmation alert
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: "คุณต้องการยืนยันการจองนี้หรือไม่?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, จองเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('reservation-form').submit(); // Submit the form if confirmed
        }
    });
}
</script>

@endsection

