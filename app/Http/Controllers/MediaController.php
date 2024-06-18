<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::all();
        return view('media.index', compact('media'));
    }

    public function create()
    {
        return view('media.create');
    }

    public function store(Request $request)
    {
        Log::info('Store method called');
        Log::info('Request Data: ', $request->all());
    
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|array'
        ]);
    
        Log::info('Validated Data: ', $data);
    
        $media = Media::create($data);
        Log::info('Media Created: ', $media->toArray());
    
        return redirect()->route('media.index')->with('success', 'Media created successfully.');
    }
    

    public function show(Media $media)
    {
        return view('media.show', compact('media'));
    }

    public function edit(Media $media)
    {
        return view('media.edit', compact('media'));
    }

    public function update(Request $request, Media $media)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|array'
        ]);

        $media->update($data);

        return redirect()->route('media.index')->with('success', 'Media updated successfully.');
    }

    public function destroy(Media $media)
    {
        $media->delete();
        return redirect()->route('media.index')->with('success', 'Media deleted successfully.');
    }
}
