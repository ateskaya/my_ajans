<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabProject extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'tech_stack',
        'status',
        'project_url',
        'image_url',
    ];

    protected $casts = [
        'tech_stack' => 'array',
    ];
}
