<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journalist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'private_email', 'work_email', 'kz_person', 'additional_info'
    ];

    protected $casts = [
        'kz_person' => 'array',
    ];

    public function media()
    {
        return $this->belongsToMany(Media::class, 'journalist_media');
    }

    public function kzPeople()  // Make sure this method name matches what you are calling in the controller
    {
        return $this->belongsToMany(KzPerson::class, 'journalist_kz_people');
    }
}
