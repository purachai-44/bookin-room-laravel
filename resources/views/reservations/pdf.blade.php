<!DOCTYPE html>
<html>
<head>
    <title>รายการการจอง</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>รายการการจอง</h1>
    <table>
        <thead> 
            <tr>
                <th>ผู้จอง</th>
                <th>การใช้</th>
                <th>ห้อง</th>
                <th>สถานะ</th>
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
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
