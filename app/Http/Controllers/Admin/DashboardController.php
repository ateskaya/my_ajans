<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use App\Models\Lead;
use App\Models\Service;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'leads' => Lead::query()->count(),
                'services' => Service::query()->where('is_active', true)->count(),
                'caseStudies' => CaseStudy::query()->count(),
            ],
        ]);
    }
}
