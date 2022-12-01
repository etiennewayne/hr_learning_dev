<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'username', 'lname', 'fname', 'mname', 'suffix', 'date_birth', 'sex', 'civil_status',
        'civil_status_others', 'height', 'weight', 'blood_type', 'gsis',
        'pagibig', 'philhealth', 'sss', 'tin', 'agency_idno', 'citizenship',
        'res_province', 'res_city', 'res_barangay', 'res_street', 'res_houseno_blockno', 'res_zipcode',
        'per_province', 'per_city', 'per_barangay', 'per_street', 'per_houseno_blockno', 'per_zipcode',
        'tel_no', 'contact_no', 'email',
        'spouse_surname', 'spouse_fname', 'spouse_mname', 'spouse_suffix', 'spouse_occupation',
        'business_name', 'business_address', 'business_contact_no',
        'father_surname', 'father_fname', 'father_mname', 'father_suffix',
        'mother_surname', 'mother_fname', 'mother_mname', 'mother_suffix',
        'role', 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function children(){
        return $this->HasMany(Children::class, 'user_id', 'user_id');
    }

    public function eligibilities(){
        return $this->HasMany(CivilServiceEligibility::class, 'user_id', 'user_id');
    }

    public function work_experiences(){
        return $this->HasMany(WorkExperience::class, 'user_id', 'user_id');
    }

    public function educational_backgrounds(){
        return $this->HasMany(EducationalBackground::class, 'user_id', 'user_id');
    }

    public function voluntary_works(){
        return $this->HasMany(VoluntaryWork::class, 'user_id', 'user_id');
    }

    public function learning_developments(){
        return $this->HasMany(LearningDevelopment::class, 'user_id', 'user_id');
    }

    public function other_informations(){
        return $this->HasMany(OtherInformation::class, 'user_id', 'user_id');
    }

}
