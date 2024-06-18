<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'media_type_id'];

    public function journalists()
    {
        return $this->belongsToMany(Journalist::class);
    }

    public function mediaType()
    {
        return $this->belongsTo(MediaType::class);
    }
}
