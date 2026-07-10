<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $plans = \App\Models\SubscriptionPlan::all();
    return view('welcome', compact('plans'));
});

Route::get('/auth/google/redirect', [App\Http\Controllers\Auth\GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'callback'])->name('google.callback');

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('personas', App\Http\Controllers\Admin\PersonaController::class);
    Route::resource('prompts', App\Http\Controllers\Admin\PromptController::class);
    Route::resource('subscription-plans', App\Http\Controllers\Admin\SubscriptionPlanController::class);
    Route::resource('transactions', App\Http\Controllers\Admin\TransactionController::class);
    Route::resource('legal-pages', App\Http\Controllers\Admin\LegalPageController::class);
});

// User (Member) Routes
Route::prefix('user')->middleware(['auth', 'verified', 'role:user'])->name('user.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\UserController::class, 'dashboard'])->name('dashboard');
    Route::resource('projects', App\Http\Controllers\User\ProjectController::class);
    
    // AI Judul
    Route::get('/ai-judul', [App\Http\Controllers\User\AiJudulController::class, 'index'])->name('ai-judul.index');
    Route::post('/ai-judul/generate', [App\Http\Controllers\User\AiJudulController::class, 'generate'])->name('ai-judul.generate');
    Route::get('/ai-judul/history', [App\Http\Controllers\User\AiJudulController::class, 'history'])->name('ai-judul.history');
    Route::get('/ai-judul/{topicIdea}', [App\Http\Controllers\User\AiJudulController::class, 'show'])->name('ai-judul.show');

    // AI BAB Generator
    Route::post('/projects/{project}/chapters/reorder', [App\Http\Controllers\User\ChapterController::class, 'reorder'])->name('chapters.reorder');
    Route::post('/projects/{project}/chapters', [App\Http\Controllers\User\ChapterController::class, 'store'])->name('chapters.store');
    Route::put('/projects/{project}/chapters/{chapter}/rename', [App\Http\Controllers\User\ChapterController::class, 'rename'])->name('chapters.rename');
    Route::get('/projects/{project}/chapters/{chapter}', [App\Http\Controllers\User\ChapterController::class, 'show'])->name('chapters.show');
    
    Route::post('/projects/{project}/chapters/{chapter}/sections/reorder', [App\Http\Controllers\User\ChapterController::class, 'reorderSections'])->name('chapters.sections.reorder');
    Route::post('/projects/{project}/chapters/{chapter}/sections', [App\Http\Controllers\User\ChapterController::class, 'storeSection'])->name('chapters.sections.store');
    Route::put('/projects/{project}/chapters/sections/{section}/rename', [App\Http\Controllers\User\ChapterController::class, 'renameSection'])->name('chapters.sections.rename');
    Route::post('/projects/{project}/chapters/sections/{section}/generate', [App\Http\Controllers\User\ChapterController::class, 'generateAi'])->name('chapters.sections.generate');
    Route::put('/projects/{project}/chapters/sections/{section}', [App\Http\Controllers\User\ChapterController::class, 'update'])->name('chapters.sections.update');

    // AI Proposal Generator
    Route::get('/projects/{project}/proposal', [App\Http\Controllers\User\ProposalController::class, 'index'])->name('proposal.index');
    Route::post('/projects/{project}/proposal/generate-section', [App\Http\Controllers\User\ProposalController::class, 'generateSection'])->name('proposal.generate-section');

    // Literature Review
    Route::get('/projects/{project}/literature', [App\Http\Controllers\User\LiteratureReviewController::class, 'index'])->name('literature.index');
    Route::post('/projects/{project}/literature/upload', [App\Http\Controllers\User\LiteratureReviewController::class, 'uploadPdf'])->name('literature.upload');
    Route::post('/projects/{project}/literature/references', [App\Http\Controllers\User\LiteratureReviewController::class, 'store'])->name('literature.store');
    Route::delete('/projects/{project}/literature/references/{reference}', [App\Http\Controllers\User\LiteratureReviewController::class, 'destroy'])->name('literature.destroy');
    Route::post('/projects/{project}/literature/references/{reference}/citation', [App\Http\Controllers\User\LiteratureReviewController::class, 'generateCitation'])->name('literature.citation');
    
    // Statistics & Methodology Routes
    Route::get('/projects/{project}/statistics', [App\Http\Controllers\User\StatisticsController::class, 'index'])->name('statistics.index');
    Route::post('/projects/{project}/statistics/methodology', [App\Http\Controllers\User\StatisticsController::class, 'generateMethodology'])->name('statistics.methodology');
    Route::post('/projects/{project}/statistics/upload', [App\Http\Controllers\User\StatisticsController::class, 'uploadData'])->name('statistics.upload');

    // Export
    Route::get('/projects/{project}/export/pdf', [App\Http\Controllers\User\ExportController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/projects/{project}/export/docx', [App\Http\Controllers\User\ExportController::class, 'exportDocx'])->name('export.docx');
    
    Route::get('/subscription', [App\Http\Controllers\User\SubscriptionController::class, 'index'])->name('subscription.index');
    Route::post('/subscription/{plan}/checkout', [App\Http\Controllers\User\SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::get('/subscription/success', [App\Http\Controllers\User\SubscriptionController::class, 'success'])->name('subscription.success');
    
    // AI Editor route
    Route::post('/ai-editor/process', [App\Http\Controllers\User\AIEditorController::class, 'process'])->name('ai-editor.process');
});

// Midtrans Webhook Callback (Public, No Auth, No CSRF)
Route::post('/midtrans/callback', [App\Http\Controllers\User\SubscriptionController::class, 'callback'])->name('midtrans.callback');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Public Pages Route
Route::get('/pages/{slug}', [App\Http\Controllers\LegalPageController::class, 'show'])->name('legal.show');
