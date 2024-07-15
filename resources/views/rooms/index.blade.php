@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">การจัดการห้อง</div>
            <div class="card-body">
                <a href="{{ route('rooms.create') }}" class="btn btn-primary mb-3">เพิ่มห้อง</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ชื่อห้อง</th>
                            <th>ความจุ</th>
                            <th>อุปกรณ์ถายในห้อง</th>
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rooms as $room)
                        <tr>
                            <td>{{ $room->room_name }}</td>
                            <td>{{ $room->capacity }}</td>
                            <td>{{ $room->equipment }}</td>
                            <td>
                                <a href="{{ route('rooms.edit', $room->room_id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                <form action="{{ route('rooms.destroy', $room->room_id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">ลบ</button>
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
