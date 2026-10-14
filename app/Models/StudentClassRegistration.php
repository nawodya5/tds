<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentClassRegistration extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'class_id',
        'is_primary_class',
        'registration_date',
        'status'
    ];

    protected $casts = [
        'is_primary_class' => 'boolean',
        'status' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function classroom()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
