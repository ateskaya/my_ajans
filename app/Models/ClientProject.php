<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientProject extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'progress_percentage',
        'staging_url',
        'live_url',
        'target_date',
    ];

    protected function casts(): array
    {
        return [
            'target_date' => 'date',
            'progress_percentage' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<ProjectUpdate, $this>
     */
    public function projectUpdates(): HasMany
    {
        return $this->hasMany(ProjectUpdate::class);
    }

    /**
     * Client-visible project updates (alias for eager loading).
     *
     * @return HasMany<ProjectUpdate, $this>
     */
    public function updates(): HasMany
    {
        return $this->hasMany(ProjectUpdate::class);
    }
}
