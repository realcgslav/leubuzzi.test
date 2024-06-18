<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\KzPerson;

class KzPersonComponent extends Component
{
    public $kzPersons, $name;
    public $isOpen = 0;

    public function render()
    {
        $this->kzPersons = KzPerson::all();
        return view('livewire.kzperson-component');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
        ]);

        KzPerson::updateOrCreate(['id' => $this->kz_person_id], [
            'name' => $this->name,
        ]);

        session()->flash('message', $this->kz_person_id ? 'KZ Person Updated Successfully.' : 'KZ Person Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $kzPerson = KzPerson::findOrFail($id);
        $this->kz_person_id = $id;
        $this->name = $kzPerson->name;

        $this->openModal();
    }

    public function delete($id)
    {
        KzPerson::find($id)->delete();
        session()->flash('message', 'KZ Person Deleted Successfully.');
    }
}
