<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSession extends Model
{
    //

    use SoftDeletes;

    protected $fillable = [
        'class_id',
        'session_date',
        'start_time',
        'end_time',
        'cancellation_reason',
        'status',
    ];

    protected $casts = [
        'session_date' => 'date',
    ];



    public function classroom()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'class_session_id');
    }
}
