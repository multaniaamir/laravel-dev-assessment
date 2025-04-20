<?php

namespace App\Livewire\Pages\Jobs;

use Livewire\Component;
use App\Models\JobVacancy;
use App\Models\Skill;
use Livewire\WithFileUploads;

class Create extends Component
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
    public $jobId = null;
    public $existingLogo = null;

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

    public function mount($id = null)
    {
        if ($id) {
            $job = JobVacancy::with('skills')->findOrFail($id);
            $this->jobId = $job->id;
            $this->title = $job->title;
            $this->company = $job->company;
            $this->existingLogo = $job->company_logo;
            $this->description = $job->description;
            $this->experience = $job->experience;
            $this->salary = $job->salary;
            $this->location = $job->location;
            $this->job_type = $job->job_type;
            $this->skill_ids = $job->skills->pluck('id')->toArray();
        }
    }

    public function save()
    {
        $this->validate();

        $logoPath = $this->existingLogo;
        if ($this->company_logo) {
            // Delete old logo if it exists
            if ($this->existingLogo && file_exists(public_path('storage/' . $this->existingLogo))) {
                unlink(public_path('storage/' . $this->existingLogo));
            }
            $logoPath = $this->company_logo->store('logos', 'public');
        }

        $job = JobVacancy::updateOrCreate(
            ['id' => $this->jobId],
            [
                'title' => $this->title,
                'company' => $this->company,
                'company_logo' => $logoPath,
                'description' => $this->description,
                'experience' => $this->experience,
                'salary' => $this->salary,
                'location' => $this->location,
                'job_type' => $this->job_type,
            ]
        );

        $job->skills()->sync($this->skill_ids);

        session()->flash('message', $this->jobId ? 'Job vacancy updated successfully.' : 'Job vacancy created successfully.');
        return redirect()->route('admin.jobs.index');
    }

    public function render()
    {
        $skills = Skill::all();
        return view('livewire.pages.jobs.create', compact('skills'));
    }
}