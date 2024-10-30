@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">การจัดการห้อง</div>
            <div class="card-body">
                <a href="{{ route('rooms.create') }}" class="btn btn-primary mb-3">เพิ่มห้อง</a>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-nowrap">ชื่อห้อง</th>
                                <th class="text-nowrap">ความจุ</th>
                                <th class="text-center text-nowrap">อุปกรณ์ถายในห้อง</th>
                                <th colspan="2" class="text-center text-nowrap">การจัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                            <tr>
                                <td class="text-nowrap">{{ $room->room_name }}</td>
                                <td class="text-nowrap">{{ $room->capacity }}</td>
                                <td >{{ $room->equipment }}</td>
                                <td>
                                    <a href="{{ route('rooms.edit', $room->room_id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                </td>
                                <td>
                                    <form id="delete-form-{{ $room->room_id }}" action="{{ route('rooms.destroy', $room->room_id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $room->room_id }})">ลบ</button>
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
</div>

<script>
    function confirmDelete(roomId) {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณจะไม่สามารถกู้คืนข้อมูลนี้ได้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if confirmed
                document.getElementById(`delete-form-${roomId}`).submit();
            }
        });
    }
</script>
@endsection
