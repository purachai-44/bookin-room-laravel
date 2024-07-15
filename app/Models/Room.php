<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{

    protected $fillable = [
        'room_id',
        'room_name',
        'capacity',
        'equipment',
    ];

    // Other model methods...
    protected $primaryKey = 'room_id'; // ระบุ primary key ให้ถูกต้อง

    public $incrementing = false; // ถ้า primary key ไม่ใช่ auto-increment

    protected $keyType = 'string'; // ถ้า primary key ไม่ใช่ integer

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'room_id');
    }

    use HasFactory;
}
