<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhishingVictims extends Model
{
    use HasFactory;

    protected $fillable = [
        'phishing_simulations_id',
        'name',
        'phone_no',
        'email',
        'company',
        'department',
        'response',
        'awareness_status',
        'feedback',
    ];

    public function phishing_simulation()
    {
        return $this->belongsTo(PhishingSimulations::class);
    }
}
