<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Skill;

class JobVacancy extends Model
{
     protected $fillable = [
        'title', 'company', 'company_logo', 'description', 'experience', 'salary', 'location', 'job_type'
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_vacancy_skill');
    }
}
