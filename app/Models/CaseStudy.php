<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    /** @use HasFactory<\Database\Factories\CaseStudyFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'client_name',
        'problem',
        'solution',
        'impact_metrics',
        'cover_image',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'impact_metrics' => 'array',
            'is_featured' => 'boolean',
        ];
    }
}
