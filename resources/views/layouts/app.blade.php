<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom Booking System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <style>
        body {
            margin: 0;
            font-family: 'Kanit', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
        }

        .navbar {
            z-index: 1000;
        }
        
        /* เพิ่มสีตัวอักษรใน navbar */
        .nav-link {
            color: white !important;
        }
        
        .nav-link:hover {
            color: #FFD700 !important; /* เปลี่ยนสีเมื่อ hover */
        }
        #calendar {
        max-width: 100%; /* ปรับให้กว้างสุดไม่เกิน 100% ของคอนเทนเนอร์ */
        margin: 0 auto; /* จัดให้อยู่ตรงกลาง */
    }   
    </style>
</head>

<body>

    <div class="container px-3">
        <header class="blog-header py-3">
            <nav class="navbar navbar-expand-lg navbar-light fixed-top"
                style="background: linear-gradient(0deg, rgba(255,145,0,1) 100%, rgba(245,243,241,1) 100%);">
                <div class="container-xl">

                    <a class="navbar-brand" href="/">
                        <img src="{{ asset('img/logo.png') }}" alt="ระบบการจองห้องเรียน" class="img-fluid"
                            style="max-height: 50px;">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-start" id="navbarNav">
                        <ul class="navbar-nav"> <!-- เอา ml-auto ออกเพื่อให้ชิดซ้าย -->
                            @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">เข้าสู่ระบบ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">สมัครสมาชิก</a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('calendar') }}">ปฏิทิน</a>
                            </li>
                            @if(auth()->user()->role == 'admin')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button"
                                    data-toggle="dropdown" aria-expanded="false">
                                    การจัดการระบบ
                                </a>
                                <div class="dropdown-menu" aria-labelledby="adminDropdown">
                                    <a class="dropdown-item" href="{{ route('rooms.index') }}">การจัดการห้อง</a>
                                    <a class="dropdown-item" href="{{ route('approvals.index') }}">อนุมัติการจอง</a>
                                    <a class="dropdown-item" href="{{ route('members.upadmin') }}">จัดการสมาชิก</a>
                                </div>
                            </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('rooms/show') }}">สถานะห้อง</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reservations.index') }}">รายการจอง</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reservations.create') }}">จองห้องเรียน</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('members.edit') }}">แก้ไขโปรไฟล์</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('fingerprints.index') }}">สแกนลายนิ้วมือ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    ออกจากระบบ
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                            @endguest
                        </ul>

                    </div>
                </div>
            </nav>
        </header>

    </div>
    
    <div class="container mt-5 pt-4 content">
        @yield('content')
    </div>

    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top ">
        <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                <svg class="bi" width="30" height="24">
                    <use xlink:href="#bootstrap"></use>
                </svg>
            </a>
            <span class="mb-3 mb-md-0 text-muted">INFORMMATION TECNOLOGY <br> Rajamangala University of Technology Lanna
                Tak.</span>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</body>

</html>