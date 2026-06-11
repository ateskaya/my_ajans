<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function coverImage(): Attribute
    {
        return Attribute::get(function (?string $value): ?string {
            if ($value !== null && str_contains($value, 'unsplash.com')) {
                return null;
            }

            return $value;
        });
    }
}
