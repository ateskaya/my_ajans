<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Inertia\Inertia;
use Inertia\Response;

class LeadController extends Controller
{
    /**
     * Display a listing of leads.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Leads/Index', [
            'leads' => Lead::query()->latest()->get(),
        ]);
    }
}
