<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalendarEvent extends Model
{
    use SoftDeletes;
    //
    protected $casts = [
        'event_date' => 'date',
        'status' => 'boolean',
    ];

    protected $fillable = [
        'title',
        'event_type',
        'event_date',
        'start_time',
        'end_time',
        'description',
        'status',
    ];
}
