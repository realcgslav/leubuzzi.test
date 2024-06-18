<?php

namespace App\Http\Controllers;

use App\Models\Journalist;
use App\Models\KzPerson;
use App\Models\Media;
use Illuminate\Http\Request;

class JournalistController extends Controller
{
    public function index()
    {
        $journalists = Journalist::with(['media', 'kzPeople'])->get();
        return view('journalists.index', compact('journalists'));
    }

    public function create()
    {
        $kzPeople = KzPerson::all();
        $media = Media::all();
        return view('journalists.create', compact('kzPeople', 'media'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'private_email' => 'nullable|email|max:255',
            'work_email' => 'nullable|email|max:255',
            'kz_person' => 'nullable|array',
            'additional_info' => 'nullable|string',
            'media' => 'nullable|array',
            'new_kz_persons' => 'nullable|array'
        ]);

        $journalist = Journalist::create($data);
        $journalist->media()->sync($request->media);

        if ($request->has('new_kz_persons')) {
            foreach ($request->new_kz_persons as $person) {
                if (!empty($person)) {
                    $kzPerson = KzPerson::create(['person' => $person]);
                    $journalist->kzPeople()->attach($kzPerson);
                }
            }
        }

        return redirect()->route('journalists.index')->with('success', 'Journalist created successfully.');
    }

    public function edit(Journalist $journalist)
    {
        $kzPeople = KzPerson::all();
        $media = Media::all();
        return view('journalists.edit', compact('journalist', 'kzPeople', 'media'));
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
            'media' => 'nullable|array',
            'new_kz_persons' => 'nullable|array'
        ]);

        $journalist->update($data);
        $journalist->media()->sync($request->media);

        if ($request->has('new_kz_persons')) {
            foreach ($request->new_kz_persons as $person) {
                if (!empty($person)) {
                    $kzPerson = KzPerson::create(['person' => $person]);
                    $journalist->kzPeople()->attach($kzPerson);
                }
            }
        }

        return redirect()->route('journalists.index')->with('success', 'Journalist updated successfully.');
    }

    public function destroy(Journalist $journalist)
    {
        $journalist->delete();
        return redirect()->route('journalists.index')->with('success', 'Journalist deleted successfully.');
    }
}
