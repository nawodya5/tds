<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'teacher_name',
        'institute_name',
        'logo',
        'contact_number',
        'email',
        'address',
        'default_subject',
    ];
}
