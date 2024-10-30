@extends('layouts.app')

@section('content')
<div class="p-4 p-md-5 mb-4 text-white rounded bg-dark shadow" style="background: rgb(2,0,36); background: linear-gradient(145deg, rgba(2,0,36,1) 0%, rgba(255,255,255,1) 0%, rgba(255,145,0,1) 56%);">
    <div class="row">

        <div class="col-md-4 d-flex align-items-center">
            <img src="{{ asset('img/IT.png') }}" class="img-fluid" style="max-width: 70%; height: auto;">
        </div>


        <div class="col-md-8 px-0">
            <h1 class="display-4 fst-italic">ยินดีต้อนรับ</h1>
            <h2 class="">ระบบการจองห้องเรียน และการลงชื่อเข้าใช้งานห้องวิทยานิพนธ์ด้วยการสแกนลายนิ้วมือ</h2>
            <p class="lead my-3">ระบบนี้ ผู้ใช้สามารถจองห้องเรียนเพื่อใช้ในการทำกิจกรรมหรือตรวจสอบวันและเวลาที่ห้องภายในสาขา เทคโนโลยีสารสนเทศ ถูกใช้ได้</p>
            <p class="lead mb-0"><a href="{{ route('reservations.create') }}" class="btn btn-primary ">จองเลย</a></p>
        </div>
        
    </div>
</div>
<div class="d-flex gap-lg mb-4">

    <div class="col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body d-flex flex-column shadow">
          <h3 class="card-title">ปฏิทินงานใช้งานห้อง</h3>
          <p class="card-text mb-3">ผู้ใช้สามารถดูได้ว่าวันไหนเวลาไหนมีการใช้ห้องเพื่อเรียนวิชาอะไร หรือทำกิจกรรมอะไร</p>
          <div class="mt-auto">
            <a href="{{ url('calendar') }}" class="btn btn-primary">ปฏิทินงานใช้งาน</a>
          </div>
        </div>
      </div>
    </div>
  
    <div class="col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body d-flex flex-column shadow">
          <h3 class="card-title">สถานะของห้อง ณ ปัจจุบัน</h3>
          <p class="card-text mb-3">ผู้ใช้สามารถดูได้ว่าเวลาปัจจุบันนี้มีการใช้งานห้องอยู่หรือไม่ผ่านหน้านี้ของระบบ</p>
          <div class="mt-auto">
            <a href="{{ url('rooms/show') }}" class="btn btn-primary">สถานะการใช้งาน</a>
          </div>
        </div>
      </div>
    </div>
  
  </div>
  





<div class="row g-5">
    <div class="col-md-8">
      <h3 class="pb-4 mb-4 fst-italic border-bottom">
        วิธีการใช้
      </h3>
  
      <article class="blog-post">
        <h2 class="blog-post-title">ขั้นตอนในการจอง</h2>
        <hr>
        <h3>ขั้นตอนที่ 1</h3>
        <p>เมือเข้าสู่ระบบแล้วให้ไปที่เมนู จองห้องเรียน จะมีฟอมร์นี้ให้หรองข้อมูล</p>
        <img src="{{ asset('img/Screenshot 2024-09-24 130736.png') }}" alt="" class="img-fluid">
        <br>
        <hr>
        <h3>ขั้นตอนที่ 2</h3>
        <p>กรองข้อมูลให้ครบถ้วน เมื่อใส่ข้อมูลสำเร็จให้กำยืนยันการจอง</p>
        <img src="{{ asset('img/Screenshot 2024-09-24 132011.png') }}" alt="" class="img-fluid">
        <br>
        <hr>
        <h3>ขั้นตอนที่ 3</h3>
        <p>เมื่อยืนยันการจองแล้วข้อมูลจะถูกเอามาเก็บไว้ที่ รายงานการจอง และสถานะจะเป็น รอการอนุมัต จดการจะมีการอนุมัติจากผู้ดูแลระบบ</p>
        <img src="{{ asset('img/Screenshot 2024-09-24 130833.png')}}" alt="" class="img-fluid">
        <br>
        <hr>
        <h3>หมายเหตุ</h3>
        <ul>
          <li>การจองจะมีทั้งมหด 3 สถานะ คือ รออนุมัติ อนุมัติ และยกเลิก </li>
          <li>การจองที่อนุมัติไปแล้วไม่สามารถยกเลิกได้</li>
          <li>ผู้ดูแลไม่สามารถอนุมัติการจองที่มีเวลาทับซ้อนกันได้</li>
        </ul>
      </article>
    </div>
  
    <div class="col-md-4">
      <div class="position-sticky" style="top: 2rem;">
        <div class="p-4 mb-3 bg-light rounded">
          <h4 class="fst-italic">เกียวกับ</h4>
          <p class="mb-0">ระบบนี้เป็นผลงานของนักศึกษา <br>สาขาเทคโนดลยีสารสนเทศ <br>มหาวิทยาลัยราชมงคลล้านนา ตาก <br>ปีการศึกษา 2567 </p>
        </div>
  
        <div class="p-4">
          <h4 class="fst-italic">ติดต่อ</h4>
          <ol class="list-unstyled">
            <li><a href="https://github.com/purachai-44">GitHub</a></li>
            <li><a href="https://x.com/SaoBitKanBup">Twitter</a></li>
            <li><a href="https://www.instagram.com/m4ew_purachai/">instagram</a></li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  


@endsection
