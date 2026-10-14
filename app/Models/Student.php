<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'registration_number',
        'name',
        'date_of_birth',
        'gender',
        'notes',
        'student_contact_number',
        'address',
        'status'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'status' => 'boolean',
    ];







    public function registrations()
    {
        return $this->hasMany(StudentClassRegistration::class);
    }

    public function classes()
    {
        return $this->belongsToMany(
            ClassModel::class,
            'student_class_registrations',
            'student_id',
            'class_id'
        )->withPivot([
            'is_primary_class',
            'registration_date',
            'status'
        ]);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function payments()
    {
        return $this->hasMany(StudentPayment::class);
    }
}
