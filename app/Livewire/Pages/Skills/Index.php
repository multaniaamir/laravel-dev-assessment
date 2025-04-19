<?php

namespace App\Livewire\Pages\Skills;

use Livewire\Component;
use App\Models\Skill;

class Index extends Component
{
    public $name, $editId = null;
    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        Skill::updateOrCreate(['id' => $this->editId], ['name' => $this->name]);
        $this->reset(['name', 'editId']);
    }

    public function edit($id)
    {
        $skill = Skill::findOrFail($id);
        $this->name = $skill->name;
        $this->editId = $skill->id;
    }

    public function delete($id)
    {
        Skill::find($id)->delete();
        session()->flash('message', 'Skill deleted successfully.');
    }

    public function render()
    {
        return view('livewire.pages.skills.index',['skills' => Skill::all()]);
    }
}
