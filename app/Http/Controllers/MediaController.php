<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\MediaType;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::all();
        $mediaTypes = MediaType::all();
        return view('media.index', compact('media', 'mediaTypes'));
    }

    public function create()
    {
        $mediaTypes = MediaType::all();
        return view('media.create', compact('mediaTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|array'
        ]);

        Media::create($data);

        return redirect()->route('media.index')->with('success', 'Media created successfully.');
    }

    public function edit(Media $medium)
    {
        $mediaTypes = MediaType::all();
        return view('media.edit', ['media' => $medium, 'mediaTypes' => $mediaTypes]);
    }

    public function update(Request $request, Media $medium)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|array'
        ]);

        $medium->update($data);

        return redirect()->route('media.index')->with('success', 'Media updated successfully.');
    }

    public function destroy(Media $medium)
    {
        $medium->delete();
        return redirect()->route('media.index')->with('success', 'Media deleted successfully.');
    }

    public function addType(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string|max:255',
        ]);

        MediaType::create($data);

        return redirect()->route('media.index')->with('success', 'Media type added successfully.');
    }

    public function editType(Request $request, MediaType $mediaType)
    {
        $data = $request->validate([
            'type' => 'required|string|max:255',
        ]);

        $mediaType->update($data);

        return redirect()->route('media.index')->with('success', 'Media type updated successfully.');
    }

    public function deleteType(MediaType $mediaType)
    {
        $mediaType->delete();
        return redirect()->route('media.index')->with('success', 'Media type deleted successfully.');
    }
}
