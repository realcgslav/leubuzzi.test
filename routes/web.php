<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JournalistController;
use App\Http\Controllers\MediaController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('journalists', JournalistController::class);
Route::resource('media', MediaController::class);

// Add these routes for managing media types
Route::post('media/add-type', [MediaController::class, 'addType'])->name('media.addType');
Route::post('media/edit-type/{mediaType}', [MediaController::class, 'editType'])->name('media.editType');
Route::delete('media/delete-type/{mediaType}', [MediaController::class, 'deleteType'])->name('media.deleteType');

// Add these routes for managing KZ persons
Route::post('journalists/add-person', [JournalistController::class, 'addPerson'])->name('journalists.addPerson');
Route::post('journalists/edit-person/{kzPerson}', [JournalistController::class, 'editPerson'])->name('journalists.editPerson');
Route::delete('journalists/delete-person/{kzPerson}', [JournalistController::class, 'deletePerson'])->name('journalists.deletePerson');