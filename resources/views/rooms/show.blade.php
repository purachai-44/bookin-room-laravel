@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">สถานะห้อง</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-nowrap">ชื่อห้อง</th>
                                <th class="text-nowrap">ความจุ</th>
                                <th>อุปกรณ์</th>
                                <th class="text-nowrap">สถานะเวลาปัจจุบัน</th>
         
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                            <tr>
                                <td class="text-nowrap">{{ $room->room_name }}</td>
                                <td class="text-nowrap">{{ $room->capacity }}</td>
                                <td>{{ is_array($room->equipment) ? implode(', ', $room->equipment) : ($room->equipment ?? 'ไม่มี') }}</td>
                                <td class="text-nowrap">
                                    @if($room->is_occupied)
                                        <span class="badge rounded-pill bg-danger p-2 text-white">ไม่ว่าง</span>
                                    @else
                                        <span class="badge rounded-pill bg-success p-2 text-white">ว่าง</span>
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