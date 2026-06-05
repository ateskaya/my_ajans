<?php

namespace App\Http\Controllers;

use App\Models\LabProject;
use Inertia\Inertia;
use Inertia\Response;

class LabController extends Controller
{
    /**
     * Display the labs showcase page.
     */
    public function index(): Response
    {
        return Inertia::render('Labs/Index', [
            'projects' => LabProject::query()->latest()->get(),
        ]);
    }
}
