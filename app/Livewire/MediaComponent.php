<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Media;
use App\Models\MediaType;

class MediaComponent extends Component
{
    public $mediaItems, $mediaTypes, $name, $media_type_id;
    public $isOpen = 0;

    public function render()
    {
        $this->mediaItems = Media::all();
        $this->mediaTypes = MediaType::all();
        return view('livewire.media-component');
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
        $this->media_type_id = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'media_type_id' => 'required',
        ]);

        Media::updateOrCreate(['id' => $this->media_id], [
            'name' => $this->name,
            'media_type_id' => $this->media_type_id,
        ]);

        session()->flash('message', $this->media_id ? 'Media Updated Successfully.' : 'Media Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $media = Media::findOrFail($id);
        $this->media_id = $id;
        $this->name = $media->name;
        $this->media_type_id = $media->media_type_id;

        $this->openModal();
    }

    public function delete($id)
    {
        Media::find($id)->delete();
        session()->flash('message', 'Media Deleted Successfully.');
    }
}
