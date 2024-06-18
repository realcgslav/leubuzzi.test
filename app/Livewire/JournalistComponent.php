<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Journalist;
use App\Models\KzPerson;
use App\Models\Media;

class JournalistComponent extends Component
{
    public $journalists, $kzPersons, $media, $name, $phone, $private_email, $work_email, $additional_info;
    public $selectedKzPersons = [], $selectedMedia = [];
    public $isOpen = 0;

    public function render()
    {
        $this->journalists = Journalist::all();
        $this->kzPersons = KzPerson::all();
        $this->media = Media::all();
        return view('livewire.journalist-component');
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
        $this->phone = '';
        $this->private_email = '';
        $this->work_email = '';
        $this->additional_info = '';
        $this->selectedKzPersons = [];
        $this->selectedMedia = [];
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'phone' => 'required',
            'private_email' => 'required|email',
            'work_email' => 'required|email',
        ]);

        $journalist = Journalist::updateOrCreate(['id' => $this->journalist_id], [
            'name' => $this->name,
            'phone' => $this->phone,
            'private_email' => $this->private_email,
            'work_email' => $this->work_email,
            'additional_info' => $this->additional_info,
        ]);

        $journalist->kzPersons()->sync($this->selectedKzPersons);
        $journalist->media()->sync($this->selectedMedia);

        session()->flash('message', $this->journalist_id ? 'Journalist Updated Successfully.' : 'Journalist Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $journalist = Journalist::findOrFail($id);
        $this->journalist_id = $id;
        $this->name = $journalist->name;
        $this->phone = $journalist->phone;
        $this->private_email = $journalist->private_email;
        $this->work_email = $journalist->work_email;
        $this->additional_info = $journalist->additional_info;
        $this->selectedKzPersons = $journalist->kzPersons->pluck('id')->toArray();
        $this->selectedMedia = $journalist->media->pluck('id')->toArray();

        $this->openModal();
    }

    public function delete($id)
    {
        Journalist::find($id)->delete();
        session()->flash('message', 'Journalist Deleted Successfully.');
    }
}
