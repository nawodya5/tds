<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassDay extends Model
{
    //
    protected $fillable = [
        'class_id',
        'day_of_week',
    ];

    public function classroom()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
