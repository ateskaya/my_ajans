<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the client project dashboard.
     */
    public function index(Request $request): Response
    {
        $projects = $request->user()
            ->clientProjects()
            ->with([
                'updates' => function ($query) {
                    $query->where('is_visible_to_client', true)->latest();
                },
            ])
            ->latest()
            ->get();

        return Inertia::render('Client/Dashboard', [
            'projects' => $projects,
        ]);
    }
}
