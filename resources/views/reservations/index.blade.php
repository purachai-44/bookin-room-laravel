@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">รายการจอง</div>
            <div class="card-body">
                <a href="{{ route('reservations.create') }}" class="btn btn-primary mb-3">จองห้อง</a>
                <form method="GET" action="{{ route('reservations.index') }}" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="ค้นหาตามชื่อ" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-secondary">ค้นหา</button>
                    </div>
                </form>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>วัตถุประสงค์</th>
                            <th>เวลา</th>
                            <th>ถึง</th>
                            <th>วันที่</th>
                            <th>ถึง</th>
                            <th>ห้อง</th>
                            <th>สถานะ</th>
                            <th colspan="3">แก้ไข</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->purpose }}</td>
                            <td>{{ $reservation->start_time }}</td>
                            <td>{{ $reservation->end_time }}</td>
                            <td>{{ $reservation->start_date }}</td>
                            <td>{{ $reservation->end_date }}</td>
                            <td>{{ $reservation->room->room_name }}</td>
                            <td>{{ $reservation->status }}</td>
                            <td>
                                <a href="{{ route('reservations.edit', $reservation->reservation_id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                            </td>
                            <td>
                                <form action="{{ route('reservations.destroy', $reservation->reservation_id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">ยกเลิก</button>
                                </form>                                                               
                            </td>
                            <td>
                                <a href="{{ route('reservations.pdf') }}" class="btn btn-primary">PDF</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $reservations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
