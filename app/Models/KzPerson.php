<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KzPerson extends Model
{
    use HasFactory;

    protected $fillable = ['person'];

    protected $table = 'kz_people'; // Ensure the correct table name is used
}
