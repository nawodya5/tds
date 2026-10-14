<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassModel extends Model
{
    //
    use SoftDeletes;


    protected $table = 'classes';
    //

    protected $fillable = [
        'location_id',
        'name',
        'monthly_fee',
        'start_time',
        'end_time',
        'status',
    ];


    protected $casts = [
        'location_id' => 'integer',
        'status' => 'boolean',
    ];






    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function days()
    {
        return $this->hasMany(ClassDay::class, 'class_id');
    }

    public function sessions()
    {
        return $this->hasMany(ClassSession::class);
    }

    public function registrations()
    {
        return $this->hasMany(
            StudentClassRegistration::class,
            'class_id'
        );
    }

    public function students()
    {
        return $this->belongsToMany(
            Student::class,
            'student_class_registrations',
            'class_id',
            'student_id'
        )->withPivot([
            'is_primary_class',
            'registration_date',
            'status'
        ]);
    }

    public function payments()
    {
        return $this->hasMany(StudentPayment::class);
    }
}
