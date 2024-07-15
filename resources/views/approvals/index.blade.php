@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">อนุมัติการจอง</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ผู้จอง</th>
                            <th>จำนวนคน</th>
                            <th>ห้อง</th>
                            <th>สถานะ</th>
                            <th>ผลการจอง</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>
                                @if ($reservation->member)
                                    {{ $reservation->member->first_name }} {{ $reservation->member->last_name }}
                                @else
                                    ไม่ทราบชื่อ
                                @endif
                            </td>
                            <td>{{ $reservation->purpose }}</td>
                            <td>{{ $reservation->room->room_name }}</td>
                            <td>{{ $reservation->status }}</td>
                            <td>
                                <form action="{{ route('approvals.approve', $reservation->reservation_id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="approval_status" value="approved">
                                    <button type="submit" class="btn btn-success btn-sm">อนุมัติ</button>
                                </form>
                                
                                <form action="{{ route('approvals.reject', $reservation->reservation_id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <input type="hidden" name="approval_status" value="rejected">
                                    <button type="submit" class="btn btn-danger btn-sm">ยกเลิก</button>
                                </form>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>         
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
