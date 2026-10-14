<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentPayment extends Model
{
    //
    //
    use SoftDeletes;
    protected $fillable = [
        'student_id',
        'class_id',
        'payment_month',
        'payment_year',
        'monthly_fee',
        'paid_amount',
        'payment_date',
        'payment_status',
    ];

    protected $casts = [
        'payment_month' => 'integer',
        'payment_year' => 'integer',
        'monthly_fee' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'payment_date' => 'date',
        'payment_status' => 'string',
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
