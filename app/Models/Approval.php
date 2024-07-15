<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $fillable = [
        'approval_id',
        'reservation_id',
        'approval_status',
        // Add other fillable fields here if needed
    ];

    use HasFactory;
}
