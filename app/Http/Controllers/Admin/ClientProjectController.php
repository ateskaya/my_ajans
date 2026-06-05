<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientProject;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class ClientProjectController extends Controller
{
    private const STATUSES = ['planlama', 'gelistirme', 'test', 'canli'];

    private const UPDATE_TYPES = ['genel', 'kilometre_tasi', 'acil'];

    /**
     * Display a listing of client projects.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/ClientProjects/Index', [
            'projects' => ClientProject::query()
                ->with('user')
                ->latest()
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new client project.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/ClientProjects/Create', [
            'clients' => User::query()
                ->where('role', 'client')
                ->orderBy('name')
                ->get(['id', 'name', 'email']),
        ]);
    }

    /**
     * Store a newly created client project in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'staging_url' => $request->input('staging_url') ?: null,
            'live_url' => $request->input('live_url') ?: null,
            'target_date' => $request->input('target_date') ?: null,
        ]);

        $validated = $request->validate($this->projectRules());

        ClientProject::create($validated);

        return redirect()
            ->route('admin.client-projects.index')
            ->with('success', 'Müşteri projesi başarıyla oluşturuldu.');
    }

    /**
     * Display the specified client project.
     */
    public function show(ClientProject $clientProject): Response
    {
        $clientProject->load([
            'user',
            'projectUpdates' => fn ($query) => $query->latest(),
        ]);

        return Inertia::render('Admin/ClientProjects/Show', [
            'project' => $clientProject,
            'statusOptions' => self::STATUSES,
            'updateTypeOptions' => self::UPDATE_TYPES,
        ]);
    }

    /**
     * Show the form for editing the specified client project.
     */
    public function edit(ClientProject $clientProject): Response
    {
        return Inertia::render('Admin/ClientProjects/Edit', [
            'project' => $clientProject->load('user'),
            'clients' => User::query()
                ->where('role', 'client')
                ->orderBy('name')
                ->get(['id', 'name', 'email']),
            'statusOptions' => self::STATUSES,
        ]);
    }

    /**
     * Update the specified client project in storage.
     */
    public function update(Request $request, ClientProject $clientProject): RedirectResponse
    {
        $request->merge([
            'staging_url' => $request->input('staging_url') ?: null,
            'live_url' => $request->input('live_url') ?: null,
            'target_date' => $request->input('target_date') ?: null,
        ]);

        $validated = $request->validate($this->projectRules());

        $clientProject->update($validated);

        return redirect()
            ->route('admin.client-projects.show', $clientProject)
            ->with('success', 'Proje başarıyla güncellendi.');
    }

    /**
     * Remove the specified client project from storage.
     */
    public function destroy(ClientProject $clientProject): RedirectResponse
    {
        $clientProject->delete();

        return redirect()
            ->route('admin.client-projects.index')
            ->with('success', 'Proje başarıyla silindi.');
    }

    /**
     * Store a new project update for the given client project.
     */
    public function storeUpdate(Request $request, ClientProject $clientProject): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'type' => ['required', 'string', Rule::in(self::UPDATE_TYPES)],
        ]);

        $clientProject->projectUpdates()->create([
            ...$validated,
            'is_visible_to_client' => true,
        ]);

        return redirect()
            ->route('admin.client-projects.show', $clientProject)
            ->with('success', 'Proje güncellemesi eklendi.');
    }

    /**
     * @return array<string, mixed>
     */
    private function projectRules(): array
    {
        return [
            'user_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where('role', 'client'),
            ],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required', 'string', Rule::in(self::STATUSES)],
            'progress_percentage' => ['required', 'integer', 'min:0', 'max:100'],
            'staging_url' => ['nullable', 'string', 'max:255'],
            'live_url' => ['nullable', 'string', 'max:255'],
            'target_date' => ['nullable', 'date'],
        ];
    }
}
