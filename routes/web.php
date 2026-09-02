<?php

use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BatchScheduleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminConsultationController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::post('/konsultasi', [LandingPageController::class, 'storeConsultation'])->name('consultation.store');
Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');

/*
|--------------------------------------------------------------------------
| Admin & Sensei Authentication Routes (With Forgot & Reset Password)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Forgot & Reset Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Laravel default route named 'login' redirect
Route::get('/login', fn() => redirect()->route('admin.login'))->name('login');
Route::get('/dashboard', fn() => redirect()->route('admin.dashboard'));

/*
|--------------------------------------------------------------------------
| Admin Protected CMS, Academic, Finance & RBAC Management Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    
    // 1. Dashboard Overview
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // 2. Leads & Consultations Management
    Route::get('/leads', [AdminConsultationController::class, 'index'])->name('consultations.index');
    Route::post('/leads/{id}/status', [AdminConsultationController::class, 'updateStatus'])->name('consultations.status');
    Route::delete('/leads/{id}', [AdminConsultationController::class, 'destroy'])->name('consultations.destroy');
    Route::get('/leads/export', [AdminConsultationController::class, 'exportCsv'])->name('consultations.export');
    Route::get('/leads/{id}/print', [AdminConsultationController::class, 'printForm'])->name('consultations.print');

    // 3. Site Settings & Hero CMS
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // 4. Programs CRUD
    Route::resource('programs', ProgramController::class)->except(['show']);

    // 5. Facilities CRUD
    Route::resource('facilities', FacilityController::class)->except(['create', 'show', 'edit']);

    // 6. Testimonials CRUD
    Route::resource('testimonials', TestimonialController::class)->except(['create', 'show', 'edit']);

    // 7. FAQs CRUD
    Route::resource('faqs', FaqController::class)->except(['create', 'show', 'edit']);

    // 8. Partners CRUD
    Route::resource('partners', PartnerController::class)->except(['create', 'show', 'edit']);

    // 9. Articles / Blog CMS
    Route::resource('articles', AdminArticleController::class)->except(['show']);

    // 10. Batch Schedules CMS
    Route::resource('schedules', BatchScheduleController::class)->except(['create', 'show', 'edit']);

    // 11. Data Diri Siswa & Keuangan LPK
    Route::get('/students/export', [StudentController::class, 'exportCsv'])->name('students.export');
    Route::get('/students/{id}/print', [StudentController::class, 'printDossier'])->name('students.print');
    Route::post('/students/{id}/payment', [StudentController::class, 'updatePayment'])->name('students.payment');
    Route::resource('students', StudentController::class)->except(['show']);

    // 12. Data Pengajar / Sensei
    Route::resource('teachers', TeacherController::class)->except(['show']);

    // 13. User Management & RBAC Roles
    Route::resource('users', UserController::class)->except(['create', 'show', 'edit']);

    // 14. Admin Profile & Password
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Friendly Aliases (Singular / Variations)
    Route::get('/user', fn() => redirect()->route('admin.users.index'));
    Route::get('/student', fn() => redirect()->route('admin.students.index'));
    Route::get('/teacher', fn() => redirect()->route('admin.teachers.index'));
    Route::get('/setting', fn() => redirect()->route('admin.settings.index'));
    Route::get('/lead', fn() => redirect()->route('admin.consultations.index'));
    Route::get('/program', fn() => redirect()->route('admin.programs.index'));
    Route::get('/facility', fn() => redirect()->route('admin.facilities.index'));
    Route::get('/testimonial', fn() => redirect()->route('admin.testimonials.index'));
    Route::get('/faq', fn() => redirect()->route('admin.faqs.index'));
    Route::get('/partner', fn() => redirect()->route('admin.partners.index'));
    Route::get('/article', fn() => redirect()->route('admin.articles.index'));
    Route::get('/schedule', fn() => redirect()->route('admin.schedules.index'));
});
