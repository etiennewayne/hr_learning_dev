<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendedTeacher extends Model
{
    use HasFactory;

    protected $table = 'recommended_teachers';
    protected $primaryKey = 'recommended_teacher_id';


    protected $fillable = ['list_info', 'teacher_id',
        'lname', 'fname', 'mname', 'sex',
        'specialization', 'no_seminars'
    ];


}
