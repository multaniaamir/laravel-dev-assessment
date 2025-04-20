<?php

namespace App\Livewire\Pages\Jobs;

use Livewire\Component;
use App\Models\JobVacancy;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

Class Create extends Component
{
    use WithFileUploads;

    public $title;
    public $company;
    public $company_logo;
    public $description;
    public $experience;
    public $salary;
    public $location;
    public $job_type;
    public $skill_ids = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'company' => 'required|string|max:255',
        'company_logo' => 'nullable|image|max:2048',
        'description' => 'nullable|string',
        'experience' => 'nullable|integer|min:0',
        'salary' => 'nullable|numeric|min:0',
        'location' => 'required|string|max:255',
        'job_type' => 'required|string|in:Full-time,Part-time,Contract,Freelance',
        'skill_ids' => 'required|array|min:1',
    ];

    public function save()
    {
        $this->validate();

        $logoPath = null;
        if ($this->company_logo) {
            $logoPath = $this->company_logo->store('logos', 'public');
        }

        $job = JobVacancy::create([
            'title' => $this->title,
            'company' => $this->company,
            'company_logo' => $logoPath,
            'description' => $this->description,
            'experience' => $this->experience,
            'salary' => $this->salary,
            'location' => $this->location,
            'job_type' => $this->job_type,
        ]);

        $job->skills()->sync($this->skill_ids);

        session()->flash('message', 'Job vacancy created successfully.');
        return redirect()->route('admin.jobs.index');
    }

    public function render()
    {
         $skills = Skill::all();
        return view('livewire.pages.jobs.create', compact('skills'));
    }
}
