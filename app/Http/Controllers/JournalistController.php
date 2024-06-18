<?php

namespace App\Http\Controllers;

use App\Models\Journalist;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JournalistController extends Controller
{
    public function index()
    {
        $journalists = Journalist::with('media')->get();
        return view('journalists.index', compact('journalists'));
    }

    public function create()
    {
        $media = Media::all();
        return view('journalists.create', compact('media'));
    }

    public function store(Request $request)
{
    Log::info('Store method called');
    Log::info('Request Data: ', $request->all());

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:255',
        'private_email' => 'nullable|email|max:255',
        'work_email' => 'nullable|email|max:255',
        'kz_person' => 'nullable|array',
        'additional_info' => 'nullable|string',
        'media' => 'nullable|array'
    ]);

    Log::info('Validated Data: ', $data);

    $journalist = Journalist::create($data);
    $journalist->media()->sync($request->media);

    Log::info('Journalist Created: ', $journalist->toArray());

    return redirect()->route('journalists.index')->with('success', 'Journalist created successfully.');
}


    public function show(Journalist $journalist)
    {
        return view('journalists.show', compact('journalist'));
    }

    public function edit(Journalist $journalist)
    {
        $media = Media::all();
        return view('journalists.edit', compact('journalist', 'media'));
    }

    public function update(Request $request, Journalist $journalist)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'private_email' => 'nullable|email|max:255',
            'work_email' => 'nullable|email|max:255',
            'kz_person' => 'nullable|array',
            'additional_info' => 'nullable|string',
            'media' => 'nullable|array'
        ]);

        $journalist->update($data);
        $journalist->media()->sync($request->media);

        return redirect()->route('journalists.index')->with('success', 'Journalist updated successfully.');
    }

    public function destroy(Journalist $journalist)
    {
        $journalist->delete();
        return redirect()->route('journalists.index')->with('success', 'Journalist deleted successfully.');
    }
}
