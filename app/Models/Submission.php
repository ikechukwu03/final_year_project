<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'finalist_id',
        'project_title',
        'project_file',
        'code_file',
        'abstract',
    ];

    public function finalist()
    {
        return $this->belongsTo(Finalist::class);
    }
}
