<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Models\LabProject;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;
use Inertia\Response;

class SystemStatusController extends Controller
{
    /**
     * Display the public system status and metrics dashboard.
     */
    public function index(): Response
    {
        $autonomousBots = 3;

        if (Schema::hasTable('lab_projects')) {
            $autonomousBots = LabProject::query()
                ->where('status', 'Canlıda')
                ->count();
        }

        return Inertia::render('Status/Index', [
            'overall_status' => 'Sistemler Operasyonel',
            'uptime_percentage' => '99.98',
            'avg_response_time' => '42ms',
            'active_projects' => CaseStudy::query()->count(),
            'autonomous_bots' => $autonomousBots,
            'uptime_history' => array_fill(0, 30, 'operational'),
        ]);
    }
}
