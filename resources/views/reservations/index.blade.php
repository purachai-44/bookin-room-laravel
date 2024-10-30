@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card mb-3">
            <div class="card-header">รายการจอง</div>
            <div class="card-body">
                <a href="{{ route('reservations.create') }}" class="btn btn-primary mb-3">จองห้อง</a>

                <form action="{{ route('reservations.index') }}" method="GET" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="start_date" class="form-label mt-2">เลือกวันที่เริ่มต้น</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label mt-2">เลือกวันที่สิ้นสุด</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end mt-2">

                            <button type="submit" class="btn btn-primary ">กรอง</button>

                        </div>
                    </div>

                </form>

                <form method="GET" action="{{ route('reservations.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control mt-2"
                                placeholder="ค้นหาตามวัตถุประสงค์" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control mt-2">
                                <option value="">-- สถานะการจอง --</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>รออนุมัติ
                                </option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>อนุมัติ
                                </option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                    ไม่อนุมัติ</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="room" class="form-control mt-2" placeholder="ค้นหาตามห้อง"
                                value="{{ request('room') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end mt-2">
                            <button type="submit" class="btn btn-primary">ค้นหา</button>
                        </div>
                    </div>
                    <div class="mt-3">

                        <a href="{{ route('reservations.pdf', [
                            'start_date' => request('start_date'), 
                            'end_date' => request('end_date'),
                            'status' => request('status'),
                            'room' => request('room'),
                            'search' => request('search')
                        ]) }}" class="btn btn-primary ">ดาวน์โหลด PDF</a>

                        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">คืนค่า</a>
                    </div>

                </form>
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-nowrap">วัตถุประสงค์</th>
                                <th>เวลา</th>
                                <th>ถึง</th>
                                <th class="text-nowrap">วันที่</th>
                                <th class="text-nowrap">ถึง</th>
                                <th class="text-nowrap">ห้อง</th>
                                <th>สถานะ</th>
                                <th colspan="3" class="text-center">แก้ไข</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                            <tr>
                                <td class="text-nowrap">{{ $reservation->purpose }}</td>
                                <td>{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}</td>
                                <td class="text-nowrap">{{ $reservation->formatted_start_date }}</td>
                                <td class="text-nowrap">{{ $reservation->formatted_end_date }}</td>
                                <td class="text-nowrap">{{ $reservation->room->room_name }}</td>
                                <td>
                                    @if($reservation->status == 'pending')
                                    <span class="badge rounded-pill bg-warning p-2 text-white">รออนุมัติ</span>
                                    @elseif($reservation->status == 'approved')
                                    <span class="badge rounded-pill bg-success p-2 text-white">อนุมัติ</span>
                                    @elseif($reservation->status == 'rejected')
                                    <span class="badge rounded-pill bg-danger p-2 text-white">ไม่อนุมัติ</span>
                                    @endif
                                </td>   
                                <td>
                                    <a href="{{ route('reservations.edit', $reservation->reservation_id) }}"
                                        class="btn btn-warning btn-sm btn-block">แก้ไข</a>
                                </td>
                                <td>
                                    <form action="{{ route('reservations.destroy', $reservation->reservation_id) }}"
                                        method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">ยกเลิก</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $reservations->links('pagination::simple-bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- <script>
    function rejectReservation(reservationId) {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณต้องการยกเลิกการจองนี้หรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ยกเลิกเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show success message before submitting form
                Swal.fire({
                    title: "ลบสำเร็จ",
                    text: "ลบการจองสำเร็จ",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    document.getElementById(`rejected-form-${reservationId}`).submit();
                });
            }
        });
    }
</script> --}}
@endsection