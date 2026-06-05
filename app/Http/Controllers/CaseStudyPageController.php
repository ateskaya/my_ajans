<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use Inertia\Inertia;
use Inertia\Response;

class CaseStudyPageController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('CaseStudies/Index', [
            'caseStudies' => CaseStudy::query()->latest()->get(),
        ]);
    }
}
