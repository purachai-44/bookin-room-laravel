@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">เพิ่มห้อง</div>
            <div class="card-body">
                <form id="room-form" method="POST" action="{{ route('rooms.store') }}">
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
                        <label for="equipment" class="form-label">อุปกรณ์ภายในห้อง</label>
                        <textarea class="form-control" id="equipment" name="equipment"></textarea>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="roomCreate()">เพิ่ม</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function roomCreate() {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณต้องการยืนยันการเพิ่มห้องเรียนนี้หรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, เพิ่มเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "สำเร็จ!",
                    text: "เพิ่มห้องสำเร็จ",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    document.getElementById('room-form').submit();
                });
            }
        });
    }


</script>
@endsection
