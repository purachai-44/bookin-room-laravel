@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0">กรองข้อมูลการเข้าห้อง</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('fingerprints.index') }}">
                    <div class="form-group">
                        <label for="date">เลือกวันที่:</label>
                        <input type="date" id="date" name="date" class="form-control" value="{{ request('date') }}">
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">กรอง</button>
                    </div>
                </form>            
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">รายการการจองของคุณ</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ชื่อห้อง</th>
                                <th>วันเริ่ม</th>
                                <th>เวลาที่เริ่ม</th>
                                <th>วันสิ้นสุด</th>
                                <th>เวลาที่สิ้นสุด</th>
                                <th>สถานะการยืนยัน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->room->room_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}</td>
                                <td>
                                    @if($reservation->is_verified)
                                        <span class="badge rounded-pill bg-success p-2 text-white">ยืนยันการใช้ห้องแล้ว</span>
                                    @else
                                        <span class="badge rounded-pill bg-danger p-2 text-white">ยังไม่ได้ยืนยัน</span>
                                    @endif
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
@endsection
