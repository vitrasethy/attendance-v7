<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Present extends Model
{
    protected $fillable = [
        'student_id',
        'record_id',
    ];
}
