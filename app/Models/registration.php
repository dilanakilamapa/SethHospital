<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'PhoneNumber',
        'first_name',
        'last_name',
        'address',
        'age',
        'gender',
        'OTP',
        'OTP_verify',
        'otp_expiry',
    ];
}