<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'reservation_id',
        'purpose',
        'start_time',
        'end_time',
        'start_date',
        'end_date',
        'member_id',
        'room_id',
        'status',
    ];

    protected $primaryKey = 'reservation_id'; // ระบุ primary key

    public $incrementing = false; // ถ้า primary key ไม่ใช่ auto-increment

    protected $keyType = 'string'; // ถ้า primary key ไม่ใช่ integer

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    // Your other model code...
}
