<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutVerifyFingerprint extends Model
{
    use HasFactory;

    protected $table = 'out_verify_fingerprint';

    protected $fillable = [
        'fingerprint_code',
        'verified_at',
    ];
}

