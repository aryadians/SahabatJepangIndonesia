<?php

require 'c:/Tugas Kuliah/Belajar/Project/SahabatJepangIndonesia/vendor/autoload.php';
$app = require_once 'c:/Tugas Kuliah/Belajar/Project/SahabatJepangIndonesia/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email', 'admin@sahabatjepangindonesia.com')->first();

$routes = [
    // Public routes
    '/' => 'PUBLIC: Homepage',
    '/artikel' => 'PUBLIC: Artikel Index',
    '/simulasi-ujian' => 'PUBLIC: CBT Simulator',
    '/sebaran-alumni' => 'PUBLIC: Peta Alumni',
    '/mitra-sekolah' => 'PUBLIC: Kemitraan SMK',
    '/admin/login' => 'PUBLIC: Admin Login',
    '/admin/forgot-password' => 'PUBLIC: Forgot Password',
    
    // Admin routes
    '/admin/dashboard' => 'ADMIN: Dashboard',
    '/admin/leads' => 'ADMIN: Leads CRM',
    '/admin/settings' => 'ADMIN: Settings & Hero',
    '/admin/programs' => 'ADMIN: Programs',
    '/admin/facilities' => 'ADMIN: Facilities',
    '/admin/testimonials' => 'ADMIN: Testimonials',
    '/admin/faqs' => 'ADMIN: FAQs',
    '/admin/partners' => 'ADMIN: Partners',
    '/admin/articles' => 'ADMIN: Articles',
    '/admin/schedules' => 'ADMIN: Schedules',
    '/admin/students' => 'ADMIN: Students',
    '/admin/teachers' => 'ADMIN: Teachers',
    '/admin/whatsapp' => 'ADMIN: WhatsApp Gateway',
    '/admin/finance' => 'ADMIN: Financial Forecasting',
    '/admin/affiliates' => 'ADMIN: Affiliate Network',
    '/admin/users' => 'ADMIN: User RBAC',
    '/admin/profile' => 'ADMIN: Profile Settings',
];

$firstArticle = App\Models\Article::where('is_published', true)->first();
if ($firstArticle) {
    $routes['/artikel/' . $firstArticle->slug] = 'PUBLIC: Single Article';
}

$firstLead = App\Models\Consultation::first();
if ($firstLead) {
    $routes['/admin/leads/' . $firstLead->id . '/print'] = 'ADMIN: Print Lead Dossier';
}

$firstStudent = App\Models\Student::first();
if ($firstStudent) {
    $routes['/admin/students/' . $firstStudent->id . '/print'] = 'ADMIN: Print Student Dossier';
}

$successCount = 0;
$failCount = 0;

echo "======================================================\n";
echo "   LPK SAHABAT JEPANG INDONESIA - FULL SUITE AUDIT\n";
echo "======================================================\n\n";

foreach ($routes as $url => $label) {
    $request = Illuminate\Http\Request::create($url, 'GET');
    $app->instance('request', $request);

    if (str_starts_with($url, '/admin') && !in_array($url, ['/admin/login', '/admin/forgot-password'])) {
        auth()->setUser($user);
    }

    $response = $kernel->handle($request);
    $status = $response->getStatusCode();
    
    if ($status === 200) {
        $successCount++;
        echo " [200 OK]  {$label} ({$url})\n";
    } else {
        $failCount++;
        echo " [{$status} FAIL] {$label} ({$url})\n";
        if (isset($response->exception)) {
            echo "   Error: " . $response->exception->getMessage() . "\n";
            echo "   At: " . $response->exception->getFile() . ":" . $response->exception->getLine() . "\n";
        }
    }
}

echo "\n======================================================\n";
echo " AUDIT SUMMARY: {$successCount} Passed, {$failCount} Failed\n";
echo "======================================================\n";
