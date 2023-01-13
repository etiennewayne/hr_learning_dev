<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendedInfo extends Model
{
    use HasFactory;

    protected $table = 'recommended_info';
    protected $primaryKey = 'recommended_info_id';

    protected $fillable = ['list_info', 'seminar_post_id', 'seminar_title'];

}
