<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'class_session_id',
        'student_id',
        'marked_by',
        'attendance_status',
        'marked_at',
        'remarks',
    ];


    protected $casts = [
        'class_session_id' => 'integer',
        'student_id' => 'integer',
    ];





    public function session()
    {
        return $this->belongsTo(ClassSession::class, 'class_session_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'marked_by');
    }
}
