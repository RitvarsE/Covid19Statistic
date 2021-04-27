<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_id',
        'region_name',
        'ATVK',
        'confirmed_infection',
        'active_infection',
        '14_day_cumulative',
        'registration_date',
    ];

    public $dates = [
        'registration_date'
    ];
}
