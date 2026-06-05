<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class CaseStudyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/CaseStudies/Index', [
            'caseStudies' => CaseStudy::query()->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/CaseStudies/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge(['is_featured' => $request->boolean('is_featured')]);

        $validated = $request->validate($this->rules());
        $validated['impact_metrics'] = $this->parseImpactMetrics($request);

        CaseStudy::create($validated);

        return redirect()
            ->route('admin.case-studies.index')
            ->with('success', 'Başarı hikayesi başarıyla oluşturuldu.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CaseStudy $caseStudy): Response
    {
        return Inertia::render('Admin/CaseStudies/Edit', [
            'caseStudy' => $caseStudy,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CaseStudy $caseStudy): RedirectResponse
    {
        $request->merge(['is_featured' => $request->boolean('is_featured')]);

        $validated = $request->validate($this->rules($caseStudy));
        $validated['impact_metrics'] = $this->parseImpactMetrics($request);

        $caseStudy->update($validated);

        return redirect()
            ->route('admin.case-studies.index')
            ->with('success', 'Başarı hikayesi başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CaseStudy $caseStudy): RedirectResponse
    {
        $caseStudy->delete();

        return redirect()
            ->route('admin.case-studies.index')
            ->with('success', 'Başarı hikayesi başarıyla silindi.');
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(?CaseStudy $caseStudy = null): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('case_studies', 'slug')->ignore($caseStudy?->id),
            ],
            'client_name' => ['required', 'string', 'max:255'],
            'problem' => ['required', 'string'],
            'solution' => ['required', 'string'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['required', 'boolean'],
            'impact_metrics_json' => [
                'nullable',
                'string',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if ($value === null || trim($value) === '') {
                        return;
                    }

                    json_decode($value);

                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $fail('Etki metrikleri geçerli bir JSON formatında olmalıdır.');
                    }
                },
            ],
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function parseImpactMetrics(Request $request): ?array
    {
        $json = $request->input('impact_metrics_json');

        if ($json === null || trim($json) === '') {
            return null;
        }

        $decoded = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE || ! is_array($decoded)) {
            throw ValidationException::withMessages([
                'impact_metrics_json' => 'Etki metrikleri geçerli bir JSON formatında olmalıdır.',
            ]);
        }

        return $decoded;
    }
}
