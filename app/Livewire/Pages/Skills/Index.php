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

        // Check if a skill with the same name exists (case-insensitive)
        $existingSkill = Skill::whereRaw('LOWER(name) = ?', [strtolower($this->name)])
            ->when($this->editId, function ($query) {
                $query->where('id', '!=', $this->editId);
            })
            ->first();

        if ($existingSkill) {
            session()->flash('error', 'A skill with the name "' . $this->name . '" already exists.');
            return;
        }

        Skill::updateOrCreate(
            ['id' => $this->editId],
            ['name' => $this->name]
        );

        session()->flash('message', $this->editId ? 'Skill updated successfully.' : 'Skill created successfully.');
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
        return view('livewire.pages.skills.index', ['skills' => Skill::all()]);
    }
}