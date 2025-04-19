<?php

namespace App\Livewire\Pages\Jobs;

use App\Models\JobVacancy;
use Livewire\Component;

class Index extends Component
{
    public array $jobs = [];

    public function mount()
    {
        
    }

    public function delete($id)
    {
        JobVacancy::find($id)->delete();
        session()->flash('message', 'Job deleted successfully.');
    }

    public function render()
    {
        $jobVacancies = JobVacancy::with('skills')->latest()->get();
        return view('livewire.pages.jobs.index', compact('jobVacancies'));
    }
}
