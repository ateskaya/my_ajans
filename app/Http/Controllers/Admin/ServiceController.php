<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Services/Index', [
            'services' => Service::query()->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Services/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);

        $validated = $request->validate($this->rules());

        Service::create($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Hizmet başarıyla oluşturuldu.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service): Response
    {
        return Inertia::render('Admin/Services/Edit', [
            'service' => $service,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service): RedirectResponse
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);

        $validated = $request->validate($this->rules($service));

        $service->update($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Hizmet başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Hizmet başarıyla silindi.');
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(?Service $service = null): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('services', 'slug')->ignore($service?->id),
            ],
            'excerpt' => ['required', 'string'],
            'description' => ['required', 'string'],
            'icon_name' => ['required', 'string', 'max:255'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
