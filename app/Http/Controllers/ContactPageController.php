<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class ContactPageController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Contact/Index');
    }
}
