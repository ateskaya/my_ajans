<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class ClientController extends Controller
{
    /**
     * Display a listing of client users.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Clients/Index', [
            'clients' => User::query()
                ->where('role', 'client')
                ->withCount('clientProjects')
                ->latest()
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new client.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Clients/Create');
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'client',
            'email_verified_at' => now(),
        ]);

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Müşteri hesabı başarıyla oluşturuldu.');
    }
}
