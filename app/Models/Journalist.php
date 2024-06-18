<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journalist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'private_email', 'work_email', 'additional_info'
    ];

    public function kzPersons()
    {
        return $this->belongsToMany(KzPerson::class);
    }

    public function media()
    {
        return $this->belongsToMany(Media::class);
    }
}
