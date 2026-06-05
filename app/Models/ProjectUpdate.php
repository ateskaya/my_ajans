<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectUpdate extends Model
{
    protected $fillable = [
        'client_project_id',
        'title',
        'content',
        'type',
        'is_visible_to_client',
    ];

    protected function casts(): array
    {
        return [
            'is_visible_to_client' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<ClientProject, $this>
     */
    public function clientProject(): BelongsTo
    {
        return $this->belongsTo(ClientProject::class);
    }
}
