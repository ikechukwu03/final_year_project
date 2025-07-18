<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finalist extends Model
{
    protected $fillable = [
        'name',
        'matric_number',
        'email',
        'graduation_year',
    ];
}

