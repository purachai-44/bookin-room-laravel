@extends('layouts.app')

@section('content')
<style>
    #calendar {
        max-width: 100%; /* ปรับให้กว้างสุดไม่เกิน 100% ของคอนเทนเนอร์ */
        margin: 0 auto; /* จัดให้อยู่ตรงกลาง */
    }
</style>
<div class="row">
    <div class="col-md-12">

        @if(Auth::check())
            <div class="alert alert-info">
                ยินดีต้อนรับ {{ Auth::user()->first_name }}! คุณเข้าสู่ระบบในฐานะ   
                <strong>{{ Auth::user()->role === 'admin' ? 'ผู้ดูแลระบบ' : 'สมาชิกทั่วไป' }}</strong>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">

<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<link href="https://unpkg.com/tippy.js@6/animations/scale.css" rel="stylesheet"/>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'th', 
        initialView: 'dayGridMonth',
        aspectRatio: 1.35, 
        events: '{{ route('reservations.getEvents') }}',
        eventTimeFormat: { 
            hour: '2-digit',
            minute: '2-digit',
            hour12: false 
        },
        eventMouseEnter: function(info) {
            const startTime = info.event.start ? info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false }) : '';
            const endTime = info.event.end ? info.event.end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false }) : '';
            tippy(info.el, {
                content: " " + info.event.title + "  <br>ห้อง: " + info.event.extendedProps.description + 
                         "<br>เริ่ม: " + startTime + 
                         "<br>สิ้นสุด: " + endTime, 
                placement: 'top',
                animation: 'scale',
                arrow: true,
                allowHTML: true 
            });
        },
        eventMouseLeave: function(info) {
            if (info.el._tippy) {
                info.el._tippy.destroy();
            }
        },
        dayHeaderDidMount: function(info) {
            let date = new Date(info.date);
            let buddhistYear = date.getFullYear() + 543;
            let dayHeader = info.el.querySelector('.fc-col-header-cell-cushion');
            dayHeader.innerHTML = dayHeader.innerHTML.replace(date.getFullYear(), buddhistYear);
        }
    });
    calendar.render();
});

</script>
@endsection
