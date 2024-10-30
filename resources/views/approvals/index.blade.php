@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">อนุมัติการจอง</div>
            <div class="card-body">
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-nowrap">ผู้จอง</th>
                                <th class="text-noerap">การใช้</th>
                                <th class="text-nowrap">ห้อง</th>
                                <th class="text-center">สถานะ</th>
                                <th colspan="3" class="text-center">ผลการจอง</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                            <tr>
                                <td class="text-nowrap">
                                    @if ($reservation->member)
                                    {{ $reservation->member->first_name }} {{ $reservation->member->last_name }}
                                    @else
                                    ไม่ทราบชื่อ
                                    @endif
                                </td>
                                <td class="text-nowrap">{{ $reservation->purpose }}</td>
                                <td class="text-nowrap">{{ $reservation->room->room_name }}</td>
                                <td>
                                    @if($reservation->status == 'pending')
                                        <span class="badge rounded-pill bg-warning text-white">รออนุมัติ</span>
                                    @elseif($reservation->status == 'approved')
                                        <span class="badge rounded-pill bg-success text-white">อนุมัติ</span>
                                    @elseif($reservation->status == 'rejected')
                                        <span class="badge rounded-pill bg-danger text-white">ไม่อนุมัติ</span>
                                    @endif
                                </td>
                                <td>
                                    <form id="approval-form-{{ $reservation->reservation_id }}" action="{{ route('approvals.approve', $reservation->reservation_id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="approval_status" value="approved">
                                        <button type="button" class="btn btn-success btn-sm" onclick="approveReservation({{ $reservation->reservation_id }})">อนุมัติ</button>
                                    </form>
                                </td>
                                <td>
                                    <form id="rejected-form-{{ $reservation->reservation_id }}" action="{{ route('approvals.reject', $reservation->reservation_id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <input type="hidden" name="approval_status" value="rejected">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="rejectReservation({{ $reservation->reservation_id }})">ยกเลิก</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('reservations.edit', $reservation->reservation_id) }}" class="btn btn-primary btn-sm">แก้ไข</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
function approveReservation(reservationId) {
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: "คุณต้องการอนุมัติการจองนี้หรือไม่?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, อนุมัติเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            // Call a function to save to the database
            document.getElementById(`approval-form-${reservationId}`).submit();  // Submit form to save data
        }
    });
}


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
</script>
@endsection

