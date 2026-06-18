<?php

use App\Http\Controllers\Admin\CaseStudyController as AdminCaseStudyController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\ClientProjectController as AdminClientProjectController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\AiChatController;
use App\Http\Controllers\AnalyzerController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CaseStudyPageController;
use App\Http\Controllers\ContactPageController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ServicePageController;
use App\Http\Controllers\SystemStatusController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\ProfileController;
use App\Models\CaseStudy;
use App\Models\Service;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'services' => Service::query()
            ->where('is_active', true)
            ->take(3)
            ->get(),
        'caseStudies' => CaseStudy::query()
            ->take(2)
            ->get(),
    ]);
})->name('home');

Route::get('/hizmetler', [ServicePageController::class, 'index'])->name('services.index');
Route::get('/vaka-calismalari', [CaseStudyPageController::class, 'index'])->name('case-studies.index');
Route::get('/iletisim', [ContactPageController::class, 'index'])->name('contact.index');

Route::get('/proje-baslat', function () {
    return Inertia::render('Wizard/Index');
})->name('wizard.index');

Route::get('/blog', [ArticleController::class, 'index'])->name('blog.index');
Route::get('/blog/{article:slug}', [ArticleController::class, 'show'])->name('blog.show');

Route::get('/labs', [LabController::class, 'index'])->name('labs.index');

Route::get('/status', [SystemStatusController::class, 'index'])->name('status.index');

Route::get('/sitemap.xml', \App\Http\Controllers\SitemapController::class)->name('sitemap');

Route::post('/chat', [AiChatController::class, 'sendMessage'])->name('chat.send');

Route::post('/analyze-site', [AnalyzerController::class, 'analyze'])->name('analyze.site');

Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user === null) {
        return redirect()->route('login');
    }

    return redirect()->route($user->homeDashboardRoute());
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'client'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {
        Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    });

Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.alt');
        Route::get('/leads', [AdminLeadController::class, 'index'])->name('leads.index');
        Route::resource('services', AdminServiceController::class)->except(['show']);
        Route::resource('case-studies', AdminCaseStudyController::class)->except(['show']);
        Route::resource('clients', AdminClientController::class)->only(['index', 'create', 'store']);
        Route::resource('client-projects', AdminClientProjectController::class);
        Route::post('client-projects/{client_project}/updates', [AdminClientProjectController::class, 'storeUpdate'])
            ->name('client-projects.updates.store');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
