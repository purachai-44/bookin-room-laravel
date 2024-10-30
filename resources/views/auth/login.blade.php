{{-- @extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">

            <div class="card-header">เข้าสู่ระบบ</div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
@csrf
<div class="mb-3">
    <label for="member_id" class="form-label">รหัสนักศึกษา</label>
    <input type="text" class="form-control" id="member_id" name="member_id" required autofocus>

</div>
<div class="mb-3">
    <label for="password" class="form-label">รหัสผ่าน</label>
    <input type="password" class="form-control" id="password" name="password" required>
</div>
@error('member_id')
<div class="text-danger">{{ $message }}</div>
@enderror
<button type="submit" class="btn btn-primary mt-3">เข้าสู่ระบบ</button>
</form>
</div>
</div>
</div>
</div>
@endsection --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-3/assets/css/login-3.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-3/assets/css/login-3.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>

<body>
    <!-- Login 3 - Bootstrap Brain Component -->
    <section class="p-3 p-md-4 p-xl-5 ">
        <div class="container ">
            <div class="row">
                <div class="col-12 col-md-6 bsb-tpl-bg-platinum shadow">
                    <div class="d-flex flex-column justify-content-between h-100 p-3 p-md-4 p-xl-5">
                        <h3 class="m-0">ยินดีต้อนรับ</h3>
                        <img class="img-fluid rounded mx-auto my-4" loading="lazy" src="{{ asset('img/logo.png') }}"
                            width="245" height="80" alt="BootstrapBrain Logo">
                        <p class="mb-0">ยังไม่ได้สมัคร <a href="{{ route('register') }}"
                                class="link-secondary text-decoration-none">สมัครเลย</a></p>
                    </div>
                </div>
                <div class="col-12 col-md-6 bsb-tpl-bg-lotion shadow" >
                    <div class="p-3 p-md-4 p-xl-5" style="background-color: background: rgb(255,145,0);background: linear-gradient(60deg, rgba(255,145,0,1) 49%, rgba(245,243,241,1) 100%);">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-5 text-white">
                                    <h3>เข้าสู่ระบบ</h3>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row gy-3 gy-md-4 overflow-hidden"> 
                                <div class="col-12">
                                    <label for="member_id" class="form-label text-white">รหัสนักศึกษา</label>
                                    <input type="text" class="form-control shadow" id="member_id" name="member_id" required
                                        autofocus>
                                </div>
                                <div class="col-12">
                                    <label for="password" class="form-label text-white">รหัสผ่าน</label>
                                    <input type="password" class="form-control shadow" id="password" name="password" required>
                                </div>
                                @error('member_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" name="remember_me"
                                            id="remember_me">
                                        <label class="form-check-label text-secondary text-white" for="remember_me">
                                            จดจำ
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mt-3 shadow">เข้าสู่ระบบ</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-12">
                                <hr class="mt-5 mb-4 border-secondary-subtle">
                                <div class="text-end">
                                    {{-- <a href="#!" class="link-secondary text-decoration-none">ลืมรหัสผ่าน</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</body>

</html>


</html>
