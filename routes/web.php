<?php

use App\Http\Controllers\Admin\AffiliateController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BatchScheduleController;
use App\Http\Controllers\Admin\CashBookController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DigitalArchiveController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FinancialAnalyticsController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\ReimbursementController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WhatsAppController;
use App\Http\Controllers\AdminConsultationController;
use App\Http\Controllers\AlumniMapController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ExamSimulatorController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\RealTimeSyncController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Public Routes (With Rate Limiting Protection)
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::post('/konsultasi', [LandingPageController::class, 'storeConsultation'])->name('consultation.store')->middleware('throttle:10,1');
Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// 1. Simulasi Ujian JLPT & JFT-Basic CBT Online (Tanpa Login)
Route::get('/simulasi-ujian', [ExamSimulatorController::class, 'index'])->name('exam.simulator');
Route::post('/simulasi-ujian/evaluate', [ExamSimulatorController::class, 'evaluate'])->name('exam.simulator.evaluate')->middleware('throttle:30,1');
Route::get('/tryout', fn() => redirect()->route('exam.simulator'));

// 2. Peta Interaktif Sebaran Alumni di Seluruh Jepang
Route::get('/sebaran-alumni', [AlumniMapController::class, 'index'])->name('alumni.map');
Route::get('/peta-alumni', fn() => redirect()->route('alumni.map'));

// 3. Program Kemitraan Sekolah & Referral Afiliasi (Publik)
Route::get('/mitra-sekolah', [AffiliateController::class, 'publicRegister'])->name('affiliates.public.register');
Route::post('/mitra-sekolah', [AffiliateController::class, 'storePublic'])->name('affiliates.public.store')->middleware('throttle:5,1');
Route::get('/referral', fn() => redirect()->route('affiliates.public.register'));

use App\Http\Controllers\BrochureController;
use App\Http\Controllers\Admin\JobInterviewController;

// 4. Real-Time Sync API untuk Guest & Halaman Publik
Route::get('/api/realtime-sync/guest', [RealTimeSyncController::class, 'guestSync'])->name('realtime.guest');

// 5. Unduh Brosur Resmi Kurikulum & Panduan Biaya Transparan (Publik)
Route::get('/brosur', [BrochureController::class, 'index'])->name('brochure.index');
Route::post('/brosur/download', [BrochureController::class, 'download'])->name('brochure.download')->middleware('throttle:10,1');
Route::get('/brosur/file/{id}', [BrochureController::class, 'downloadFile'])->name('brochure.download.file');
Route::get('/biaya', fn() => redirect()->route('brochure.index'));
Route::get('/faq', [LandingPageController::class, 'faq'])->name('faq.index');
Route::get('/tanya-jawab', fn() => redirect()->route('faq.index'));
Route::get('/simulasi-gaji', fn() => redirect('/#kalkulator'));
Route::get('/remitansi', fn() => redirect('/#kalkulator'));
Route::get('/nenkin', fn() => redirect('/#kalkulator'));

use App\Http\Controllers\StudentPortalController;
use App\Http\Controllers\DocumentVerificationController;

// 5.5. Portal Cek Status Mandiri Siswa & Bukti Pembayaran Resmi
Route::get('/cek-status', [StudentPortalController::class, 'index'])->name('student.portal');
Route::get('/portal-siswa', fn() => redirect()->route('student.portal'));
Route::get('/kwitansi/{nis}', [StudentPortalController::class, 'publicReceipt'])->name('student.public.receipt');
Route::get('/invoice/{nis}', [StudentPortalController::class, 'publicInvoice'])->name('student.public.invoice');

// 5.6. Sistem Verifikasi Publik QR Code Keaslian Dokumen Resmi
Route::get('/verifikasi/{code?}', [DocumentVerificationController::class, 'verify'])->name('document.verify');
Route::get('/verify/{code?}', fn($code = null) => redirect()->route('document.verify', ['code' => $code]));

// 6. Dynamic XML Sitemap for SEO & Search Engine Crawlers
Route::get('/sitemap.xml', function () {
    $articles = \App\Models\Article::where('is_published', true)->latest()->get();
    
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    
    $staticRoutes = [
        ['url' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily'],
        ['url' => route('brochure.index'), 'priority' => '0.9', 'changefreq' => 'daily'],
        ['url' => route('faq.index'), 'priority' => '0.9', 'changefreq' => 'daily'],
        ['url' => route('exam.simulator'), 'priority' => '0.9', 'changefreq' => 'weekly'],
        ['url' => route('student.portal'), 'priority' => '0.8', 'changefreq' => 'weekly'],
        ['url' => route('alumni.map'), 'priority' => '0.8', 'changefreq' => 'weekly'],
        ['url' => route('articles.index'), 'priority' => '0.8', 'changefreq' => 'daily'],
        ['url' => route('affiliates.public.register'), 'priority' => '0.6', 'changefreq' => 'monthly'],
    ];

    foreach ($staticRoutes as $r) {
        $xml .= '<url>';
        $xml .= '<loc>' . htmlspecialchars($r['url']) . '</loc>';
        $xml .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
        $xml .= '<changefreq>' . $r['changefreq'] . '</changefreq>';
        $xml .= '<priority>' . $r['priority'] . '</priority>';
        $xml .= '</url>';
    }

    foreach ($articles as $a) {
        $xml .= '<url>';
        $xml .= '<loc>' . htmlspecialchars(route('articles.show', $a->slug)) . '</loc>';
        $xml .= '<lastmod>' . ($a->updated_at ? $a->updated_at->toAtomString() : now()->toAtomString()) . '</lastmod>';
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>0.7</priority>';
        $xml .= '</url>';
    }

    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('seo.sitemap');

/*
|--------------------------------------------------------------------------
| Admin & Sensei Authentication Routes (With Anti-Brute Force Throttle)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit')->middleware('throttle:5,1');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Forgot & Reset Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email')->middleware('throttle:3,1');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update')->middleware('throttle:5,1');
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
    Route::get('/api/realtime-sync', [RealTimeSyncController::class, 'adminSync'])->name('realtime.admin');

    // 2. Leads & Consultations Management
    Route::get('/leads', [AdminConsultationController::class, 'index'])->name('consultations.index');
    Route::post('/leads/{id}/status', [AdminConsultationController::class, 'updateStatus'])->name('consultations.status');
    Route::delete('/leads/{id}', [AdminConsultationController::class, 'destroy'])->name('consultations.destroy');
    Route::get('/leads/export', [AdminConsultationController::class, 'exportCsv'])->name('consultations.export');
    Route::get('/leads/export-pdf', [AdminConsultationController::class, 'exportPdf'])->name('consultations.export.pdf');
    Route::get('/leads/{id}/print', [AdminConsultationController::class, 'printForm'])->name('consultations.print');

    // 3. Site Settings & Hero CMS
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/test-fonnte', [SettingController::class, 'testFonnte'])->name('settings.test.fonnte');
    Route::get('/settings/device-fonnte', [SettingController::class, 'checkFonnteDevice'])->name('settings.device.fonnte');

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

    // 9b. Brochures & Downloadable Curriculum CMS
    Route::resource('brochures', \App\Http\Controllers\Admin\BrochureAdminController::class)->except(['create', 'show', 'edit']);

    // 9c. Campus & Government Program Galleries CMS
    Route::post('campus-galleries/{id}/toggle-active', [\App\Http\Controllers\Admin\CampusGalleryController::class, 'toggleActive'])->name('campus-galleries.toggle');
    Route::resource('campus-galleries', \App\Http\Controllers\Admin\CampusGalleryController::class)->except(['create', 'show', 'edit']);

    // 10. Batch Schedules CMS
    Route::resource('schedules', BatchScheduleController::class)->except(['create', 'show', 'edit']);

    // 11. Data Diri Siswa & Keuangan LPK
    Route::get('/students/export', [StudentController::class, 'exportCsv'])->name('students.export');
    Route::get('/students/export-pdf', [StudentController::class, 'exportPdf'])->name('students.export.pdf');
    Route::get('/students/template', [StudentController::class, 'exportTemplate'])->name('students.template');
    Route::post('/students/import', [StudentController::class, 'importCsv'])->name('students.import');
    Route::get('/students/{id}/print', [StudentController::class, 'printDossier'])->name('students.print');
    Route::get('/students/{id}/receipt', [StudentController::class, 'receipt'])->name('students.receipt');
    Route::get('/students/{id}/invoice', [StudentController::class, 'invoice'])->name('students.invoice');
    Route::post('/students/{id}/payment', [StudentController::class, 'updatePayment'])->name('students.payment');
    Route::resource('students', StudentController::class);

    // 12. Data Pengajar / Sensei
    Route::get('/teachers/export-pdf', [TeacherController::class, 'exportPdf'])->name('teachers.export.pdf');
    Route::post('/teachers/{id}/pay-salary', [TeacherController::class, 'paySalary'])->name('teachers.pay-salary');
    Route::resource('teachers', TeacherController::class)->except(['show']);

    // 13. WhatsApp Gateway & CRM Automation
    Route::get('/whatsapp', [WhatsAppController::class, 'index'])->name('whatsapp.index');
    Route::put('/whatsapp/templates/{id}', [WhatsAppController::class, 'updateTemplate'])->name('whatsapp.template.update');
    Route::post('/whatsapp/send', [WhatsAppController::class, 'sendDirect'])->name('whatsapp.send');

    // 14. Executive Financial Analytics & Cashflow Forecasting
    Route::get('/finance', [FinancialAnalyticsController::class, 'index'])->name('finance.index');
    Route::get('/finance/export-pdf', [FinancialAnalyticsController::class, 'exportPdf'])->name('finance.export.pdf');

    // 14-GL. Buku Kas Umum & Jurnal Akuntansi Keuangan LPK
    Route::get('/cash-book/export-csv', [CashBookController::class, 'exportCsv'])->name('cash-book.export.csv');
    Route::get('/cash-book/export-pdf', [CashBookController::class, 'exportPdf'])->name('cash-book.export.pdf');
    Route::post('/cash-book/period-lock', [CashBookController::class, 'togglePeriodLock'])->name('cash-book.period-lock');
    Route::resource('cash-book', CashBookController::class)->except(['create', 'show', 'edit']);

    // 14b. Klaim Reimbursement & Uang Muka Perjalanan Dinas (Cash Advance)
    Route::get('/reimbursements/stats', [ReimbursementController::class, 'stats'])->name('reimbursements.stats');
    Route::get('/reimbursements/export', [ReimbursementController::class, 'exportCsv'])->name('reimbursements.export');
    Route::get('/reimbursements/export-pdf', [ReimbursementController::class, 'exportPdf'])->name('reimbursements.export.pdf');
    Route::get('/reimbursements/template', [ReimbursementController::class, 'exportTemplate'])->name('reimbursements.template');
    Route::post('/reimbursements/import', [ReimbursementController::class, 'importCsv'])->name('reimbursements.import');
    Route::get('/reimbursements/{id}/print', [ReimbursementController::class, 'print'])->name('reimbursements.print');
    Route::post('/reimbursements/{id}/status', [ReimbursementController::class, 'updateStatus'])->name('reimbursements.status');
    Route::post('/reimbursements/{id}/send-wa', [ReimbursementController::class, 'sendWaNotification'])->name('reimbursements.send.wa');
    Route::resource('reimbursements', ReimbursementController::class)->except(['create', 'show', 'edit']);

    // 14c. Panel Arsip Digital Dokumen & Nota (Windows File Explorer SPA)
    Route::get('/digital-archives/explorer-data', [DigitalArchiveController::class, 'explorerData'])->name('digital-archives.explorer.data');
    Route::get('/digital-archives/stats', [DigitalArchiveController::class, 'stats'])->name('digital-archives.stats');
    Route::post('/digital-archives/folders', [DigitalArchiveController::class, 'createFolder'])->name('digital-archives.folder.create');
    Route::put('/digital-archives/folders/{id}/rename', [DigitalArchiveController::class, 'renameFolder'])->name('digital-archives.folder.rename.alias');
    Route::put('/digital-archives/folders/{id}', [DigitalArchiveController::class, 'renameFolder'])->name('digital-archives.folder.rename');
    Route::delete('/digital-archives/folders/{id}', [DigitalArchiveController::class, 'deleteFolder'])->name('digital-archives.folder.delete');
    Route::post('/digital-archives/upload-ajax', [DigitalArchiveController::class, 'uploadAjax'])->name('digital-archives.upload.ajax');
    Route::put('/digital-archives/{id}/rename', [DigitalArchiveController::class, 'renameFile'])->name('digital-archives.file.rename');
    Route::put('/digital-archives/{id}/move', [DigitalArchiveController::class, 'moveFile'])->name('digital-archives.file.move');
    Route::delete('/digital-archives/{id}/ajax', [DigitalArchiveController::class, 'deleteFileAjax'])->name('digital-archives.file.delete');
    Route::post('/digital-archives/storage-config', [DigitalArchiveController::class, 'updateStorageConfig'])->name('digital-archives.storage.config');
    Route::post('/digital-archives/bulk-action', [DigitalArchiveController::class, 'bulkAction'])->name('digital-archives.bulk.action');
    Route::resource('digital-archives', DigitalArchiveController::class)->except(['create', 'show', 'edit', 'update']);

    // 15. Program Kemitraan & Referral Afiliasi
    Route::get('/affiliates/export-pdf', [AffiliateController::class, 'exportPdf'])->name('affiliates.export.pdf');
    Route::get('/affiliates/export-csv', [AffiliateController::class, 'exportCsv'])->name('affiliates.export.csv');
    Route::get('/affiliates/{id}/students', [AffiliateController::class, 'referredStudents'])->name('affiliates.students');
    Route::post('/affiliates/{id}/send-wa', [AffiliateController::class, 'sendWaGreeting'])->name('affiliates.send.wa');
    Route::post('/affiliates/{id}/payout', [AffiliateController::class, 'payoutCommission'])->name('affiliates.payout');
    Route::resource('affiliates', AffiliateController::class)->except(['create', 'show', 'edit']);

    // 16. User Management & RBAC Roles
    Route::resource('users', UserController::class)->except(['create', 'show', 'edit']);

    // 17. Kalender Wawancara Kerja & Matching Kaisha
    Route::get('/interviews/export-pdf', [JobInterviewController::class, 'exportPdf'])->name('interviews.export.pdf');
    Route::post('/interviews/{id}/candidates', [JobInterviewController::class, 'assignCandidates'])->name('interviews.candidates.assign');
    Route::post('/interviews/{interviewId}/candidates/{studentId}', [JobInterviewController::class, 'updateCandidateResult'])->name('interviews.candidates.result');
    Route::resource('interviews', JobInterviewController::class)->except(['create', 'show', 'edit']);

    // 18. Admin Profile & Password
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Friendly Aliases (Singular / Variations)
    Route::get('/user', fn() => redirect()->route('admin.users.index'));
    Route::get('/student', fn() => redirect()->route('admin.students.index'));
    Route::get('/teacher', fn() => redirect()->route('admin.teachers.index'));
    Route::get('/employee', fn() => redirect()->route('admin.teachers.index'));
    Route::get('/karyawan', fn() => redirect()->route('admin.teachers.index'));
    Route::get('/reimbursement', fn() => redirect()->route('admin.reimbursements.index'));
    Route::get('/reimburse', fn() => redirect()->route('admin.reimbursements.index'));
    Route::get('/kasbon', fn() => redirect()->route('admin.reimbursements.index', ['type' => 'cash_advance']));
    Route::get('/arsip', fn() => redirect()->route('admin.digital-archives.index'));
    Route::get('/setting', fn() => redirect()->route('admin.settings.index'));
    Route::get('/lead', fn() => redirect()->route('admin.consultations.index'));
    Route::get('/program', fn() => redirect()->route('admin.programs.index'));
    Route::get('/facility', fn() => redirect()->route('admin.facilities.index'));
    Route::get('/testimonial', fn() => redirect()->route('admin.testimonials.index'));
    Route::get('/faq', fn() => redirect()->route('admin.faqs.index'));
    Route::get('/partner', fn() => redirect()->route('admin.partners.index'));
    Route::get('/article', fn() => redirect()->route('admin.articles.index'));
    Route::get('/schedule', fn() => redirect()->route('admin.schedules.index'));
    Route::get('/keuangan', fn() => redirect()->route('admin.finance.index'));
    Route::get('/affiliate', fn() => redirect()->route('admin.affiliates.index'));
    Route::get('/interview', fn() => redirect()->route('admin.interviews.index'));
    Route::get('/wawancara', fn() => redirect()->route('admin.interviews.index'));
});
