<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MediaType;

class MediaTypeComponent extends Component
{
    public $mediaTypes, $type;
    public $isOpen = 0;

    public function render()
    {
        $this->mediaTypes = MediaType::all();
        return view('livewire.mediatype-component');
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
        $this->type = '';
    }

    public function store()
    {
        $this->validate([
            'type' => 'required',
        ]);

        MediaType::updateOrCreate(['id' => $this->media_type_id], [
            'type' => $this->type,
        ]);

        session()->flash('message', $this->media_type_id ? 'Media Type Updated Successfully.' : 'Media Type Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $mediaType = MediaType::findOrFail($id);
        $this->media_type_id = $id;
        $this->type = $mediaType->type;

        $this->openModal();
    }

    public function delete($id)
    {
        MediaType::find($id)->delete();
        session()->flash('message', 'Media Type Deleted Successfully.');
    }
}
