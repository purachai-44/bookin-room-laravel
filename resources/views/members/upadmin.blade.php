@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">รายชื่อสมาชิกทั้งหมด</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-nowrap">ชื่อ</th>
                            <th class="text-nowrap">นามสกุล</th>
                            <th class="text-nowrap">โทรศัพท์</th>
                            <th class="text-nowrap">สถานะ</th>
                            <th class="text-nowrap">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                            <tr>
                                <td class="text-nowrap">{{ $member->first_name }}</td>
                                <td class="text-nowrap">{{ $member->last_name }}</td>
                                <td class="text-nowrap">{{ $member->phone }}</td>
                                <td class="text-nowrap">{{ $member->role == 'admin' ? 'ผู้ดูแล' : 'สมาชิก' }}</td>
                                <td>
                                    <a href="{{ route('members.adminedit', $member->member_id) }}" class="btn btn-primary btn-sm">แก้ไข</a>

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
