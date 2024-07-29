<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\AuthController;


// หน้าแรก 
Route::view('/', 'welcome');

// การจัดการผู้ใช้
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // การจัดการการจอง
Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
Route::put('reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');    
Route::delete('reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
Route::get('/reservations/getEvents', [ReservationController::class, 'getEvents'])->name('reservations.getEvents');
Route::get('reservations/pdf', [ReservationController::class, 'exportPdf'])->name('reservations.pdf');


// การจัดการสมาชิก
Route::middleware('auth')->group(function () {
    Route::get('members/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::put('members/update', [MemberController::class, 'update'])->name('members.update');
    Route::delete('members/delete', [MemberController::class, 'destroy'])->name('members.destroy');

    // การจัดการห้อง
    Route::resource('rooms', RoomController::class);



    // การอนุมัติการจอง
    Route::get('approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::post('approvals/{reservation}/approve', [ApprovalController::class, 'approve'])->name('approvals.approve');
    Route::post('approvals/{reservation}/reject', [ApprovalController::class, 'reject'])->name('approvals.reject');      
});
