<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Store a new lead from the contact form.
     */
    public function store(Request $request): RedirectResponse
    {
        $isWizard = $request->input('source') === 'wizard';

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'project_type' => ['nullable', 'string', 'max:255'],
            'budget_range' => ['nullable', 'string', 'max:255'],
            'timeline' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'utm_source' => ['nullable', 'string', 'max:255'],
            'utm_medium' => ['nullable', 'string', 'max:255'],
            'utm_campaign' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:50'],
        ]);

        unset($validated['source']);

        Lead::create($validated);

        $successMessage = 'Talebiniz başarıyla alındı. En kısa sürede sizinle iletişime geçeceğiz.';

        if ($isWizard) {
            return redirect()
                ->route('home')
                ->with('success', $successMessage);
        }

        return redirect()
            ->back()
            ->with('success', $successMessage);
    }
}
