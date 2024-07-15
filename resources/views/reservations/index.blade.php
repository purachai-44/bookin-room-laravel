@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">รายการจอง</div>
            <div class="card-body">
                <a href="{{ route('reservations.create') }}" class="btn btn-primary mb-3">จองห้อง</a>
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
                            <th>ผลการจอง</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->reservation_id }}</td>
                            <td>{{ $reservation->purpose }}</td>
                            <td>{{ $reservation->start_time }}</td>
                            <td>{{ $reservation->end_time }}</td>
                            <td>{{ $reservation->start_date }}</td>
                            <td>{{ $reservation->end_date }}</td>
                            <td>{{ $reservation->room->room_name }}</td>
                            <td>{{ $reservation->status }}</td>
                            <td>
                                <a href="{{ route('reservations.edit', $reservation->reservation_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('reservations.destroy', $reservation->reservation_id) }}" method="POST" style="display:inline-block;">
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
        </div>
    </div>
</div>
@endsection
