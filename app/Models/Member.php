<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    protected $fillable = [
        'member_id',
        'password',
        'first_name',
        'last_name',
        'role',
        'phone',
    ];
    protected $primaryKey = 'member_id';

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'member_id');
    }

    use HasFactory;
}


