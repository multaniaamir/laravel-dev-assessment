<?php

namespace App\Livewire\Pages\Jobs;

use App\Models\JobVacancy;
use Livewire\Component;

class Index extends Component
{
    public array $jobs = [];


    public function delete($id)
    {
        $job = JobVacancy::findOrFail($id);
        if ($job->company_logo && file_exists(public_path('storage/' . $job->company_logo))) {
            unlink(public_path('storage/' . $job->company_logo));
        }
        $job->delete();
        session()->flash('message', 'Job vacancy deleted successfully.');
    }

    public function render()
    {
        $jobVacancies = JobVacancy::with('skills')->latest()->get();
        return view('livewire.pages.jobs.index', compact('jobVacancies'));
    }
}
