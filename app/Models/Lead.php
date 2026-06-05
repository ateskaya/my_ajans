<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'project_type',
        'budget_range',
        'timeline',
        'message',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'status',
    ];
}
