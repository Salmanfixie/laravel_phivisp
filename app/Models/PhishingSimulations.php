<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhishingSimulations extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $fillable = [
        'name',
        'simulation_type',
        'purpose',
        'target_audience',
        'num_of_victim',
        'phishing_link',
        'feedback',
        'attachment_path',
        'media_url',
        'is_sent',
        'is_completed',
    ];

    public function victims()
    {
        return $this->hasMany(PhishingVictims::class);
    }
}
