<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JobVacancy;

class Skill extends Model
{
    protected $fillable = ['name'];

    public function jobVacancies()
    {
        return $this->belongsToMany(JobVacancy::class, 'job_vacancy_skill');
    }
}
