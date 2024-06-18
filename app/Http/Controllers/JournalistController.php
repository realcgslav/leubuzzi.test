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
        $journalists = Journalist::with('media')->get();
        $kzPeople = KzPerson::all();
        return view('journalists.index', compact('journalists', 'kzPeople'));
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
            'media' => 'nullable|array'
        ]);

        $journalist = Journalist::create($data);
        $journalist->media()->sync($request->media);

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

    public function addPerson(Request $request)
    {
        $data = $request->validate([
            'person' => 'required|string|max:255',
        ]);

        KzPerson::create($data);

        return redirect()->route('journalists.index')->with('success', 'Person added successfully.');
    }

    public function editPerson(Request $request, KzPerson $kzPerson)
    {
        $data = $request->validate([
            'person' => 'required|string|max:255',
        ]);

        $kzPerson->update($data);

        return redirect()->route('journalists.index')->with('success', 'Person updated successfully.');
    }

    public function deletePerson(KzPerson $kzPerson)
    {
        $kzPerson->delete();
        return redirect()->route('journalists.index')->with('success', 'Person deleted successfully.');
    }
}
