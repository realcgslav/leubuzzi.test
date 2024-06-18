<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\JournalistComponent;
use App\Livewire\KzPersonComponent;
use App\Livewire\MediaComponent;
use App\Livewire\MediaTypeComponent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Registering LiveWire components using the component class names
Route::get('/journalists', JournalistComponent::class)->name('journalists');
Route::get('/kzpersons', KzPersonComponent::class)->name('kzpersons');
Route::get('/media', MediaComponent::class)->name('media');
Route::get('/mediatypes', MediaTypeComponent::class)->name('mediatypes');
