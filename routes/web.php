<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Employer\CompanyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CompanyController as Admincompany;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Seeker\JobSeekerController;
use App\Http\Controllers\Seeker\JobApplicationController;
use App\Http\Controllers\Seeker\JobController as SeekerJobController;
use App\Http\Controllers\Seeker\DashboardController as JobSeeker;
use App\Http\Controllers\Employer\BookmarkController;
use App\Http\Controllers\PublicResumeController;
use App\Http\Controllers\Seeker\SavedJobController;
use App\Http\Controllers\Seeker\JobAlertController;
use App\Http\Controllers\Seeker\CoverLetterTemplateController;
use App\Http\Controllers\Seeker\DashboardController as JobSeekerDashboard;
// 🌐 Public Routes
Route::get('/', fn() => view('welcome'));

// 📄 Public Profile & Resume
Route::get('/seeker/{user}/profile', [JobSeekerController::class, 'publicProfile'])->name('seeker.public.profile');
Route::get('/seeker/{user:username}/resume', [PublicResumeController::class, 'show'])->name('seeker.resume.public');
Route::get('/seeker/jobs/{job}/preview', [JobSeekerDashboard::class, 'preview'])->middleware('auth')->name('jobs.preview');
// 🔐 Admin Routes
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // 📊 Admin Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // 👤 Manage Users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');

        // 🏢 Manage Companies
        Route::get('/companies', [Admincompany::class, 'index'])->name('companies.index');

        // 💼 Manage Jobs
        Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');

        // 📂 Manage Categories
        Route::resource('/categories', CategoryController::class)->except('show');
    });

// 🔐 Employer Routes
Route::middleware(['auth', 'role:employer'])
    ->prefix('employer')
    ->name('employer.')
    ->group(function () {
        // 📊 Employer Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Employer\DashboardController::class, 'index'])->name('dashboard');

        // 🏢 Company Profile
        Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
        Route::get('/company/create', [CompanyController::class, 'create'])->name('company.create');
        Route::post('/company', [CompanyController::class, 'store'])->name('company.store');
        Route::get('/company/edit', [CompanyController::class, 'edit'])->name('company.edit');
        Route::put('/company', [CompanyController::class, 'update'])->name('company.update');

        // 💼 Job Postings
        Route::resource('jobs', \App\Http\Controllers\Employer\JobController::class);
        Route::post('/jobs/{job}/duplicate', [\App\Http\Controllers\Employer\JobController::class, 'duplicate'])->name('jobs.duplicate');

        // 📄 Applications
        Route::get('/applications', [\App\Http\Controllers\Employer\ApplicationController::class, 'index'])->name('applications.index');
        Route::patch('/applications/{application}/status', [\App\Http\Controllers\Employer\ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
        Route::post('/applications/{application}/message', [\App\Http\Controllers\Employer\ApplicationController::class, 'sendMessage'])->name('applications.message');

        // 💬 Messaging
        Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
        Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');

        // 📥 Bookmarks
        Route::post('/bookmarks/{user}', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
        Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');

        // 📄 Seeker PDF Profile (download)
        Route::get('/seeker/{user}/profile/pdf', [JobSeekerController::class, 'downloadPDF'])->name('seeker.profile.download.pdf');
    });

// 🔐 Seeker Routes
Route::middleware(['auth', 'role:seeker'])
    ->prefix('seeker')
    ->name('seeker.')
    ->group(function () {
        // 📊 Seeker Dashboard
        Route::get('/dashboard', [JobSeekerDashboard::class, 'index'])->name('dashboard');


    Route::get('/dashboard/load-more', [JobSeekerDashboard::class, 'loadMore'])->name('dashboard.loadMore');
    Route::get('/jobs/{id}/preview', [JobSeekerDashboard::class, 'preview'])->name('job.preview');
    Route::post('/jobs/{job}/toggle-save', [JobSeekerDashboard::class, 'toggleSave'])->name('jobs.toggleSave');
        // 👤 Profile Management
        Route::get('/profile', [JobSeekerController::class, 'editProfile'])->name('profile.edit');
        Route::post('/profile', [JobSeekerController::class, 'updateProfile'])->name('profile.update');

        // 📄 Resume
        Route::get('/resume', [JobSeekerController::class, 'editResume'])->name('resume.edit');
        Route::post('/resume', [JobSeekerController::class, 'updateResume'])->name('resume.update');
        Route::get('/resume/download', [JobSeekerController::class, 'downloadResume'])->name('resume.download');
        Route::get('/profile/pdf/download', [JobSeekerController::class, 'downloadPDF'])->name('profile.download.pdf');

        // 🎓 Certificates
        Route::post('/certificates', [JobSeekerController::class, 'storeCertificate'])->name('certificates.store');
        Route::delete('/certificates/{certificate}', [JobSeekerController::class, 'destroy'])->name('certificates.destroy');

        // 💼 Job Listings
        Route::get('/jobs', [SeekerJobController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/{job}', [SeekerJobController::class, 'show'])->name('jobs.show');

        // 📩 Applications
        Route::get('/applications', [JobApplicationController::class, 'index'])->name('applications.index');
        Route::get('/jobs/{job}/apply', [JobApplicationController::class, 'create'])->name('applications.create');
        Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('applications.store');

        // 💬 Messaging
        Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
        Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');

        // ⭐ Saved Jobs
        Route::get('/saved-jobs', [SavedJobController::class, 'index'])->name('saved-jobs.index');
        Route::post('/saved-jobs/toggle/{job}', [SavedJobController::class, 'toggle'])->name('saved-jobs.toggle');

        // 🔔 Job Alerts
        Route::get('/alerts', [JobAlertController::class, 'index'])->name('alerts.index');
        Route::post('/alerts', [JobAlertController::class, 'store'])->name('alerts.store');
        Route::delete('/alerts/{id}', [JobAlertController::class, 'destroy'])->name('alerts.destroy');
        Route::post('/alerts/{alert}/toggle', [JobAlertController::class, 'toggle'])->name('alerts.toggle');

        Route::get('/cover-letters', [CoverLetterTemplateController::class, 'index'])->name('cover-letters.index');
    Route::post('/cover-letters', [CoverLetterTemplateController::class, 'store'])->name('cover-letters.store');
    Route::delete('/cover-letters/{template}', [CoverLetterTemplateController::class, 'destroy'])->name('cover-letters.destroy');
    Route::get('/cover-letters/{template}', [CoverLetterTemplateController::class, 'show'])->name('cover-letters.show');
    });

// 🔐 Shared Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // 📊 Fallback Dashboard
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // 👤 Laravel Default Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 💬 Global Messaging (fallback)
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');
});

// 🔐 Auth Routes (Laravel Breeze)
require __DIR__.'/auth.php';
