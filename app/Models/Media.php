<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type'
    ];

    protected $casts = [
        'type' => 'array',
    ];

    public function journalists()
    {
        return $this->belongsToMany(Journalist::class, 'journalist_media');
    }
}