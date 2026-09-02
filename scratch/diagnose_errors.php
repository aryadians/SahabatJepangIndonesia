<?php

require 'c:/Tugas Kuliah/Belajar/Project/SahabatJepangIndonesia/vendor/autoload.php';
$app = require_once 'c:/Tugas Kuliah/Belajar/Project/SahabatJepangIndonesia/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$failing = ['/', '/sebaran-alumni', '/admin/whatsapp'];

$user = App\Models\User::where('email', 'admin@sahabatjepangindonesia.com')->first();

foreach ($failing as $url) {
    echo "--- Testing {$url} ---\n";
    $request = Illuminate\Http\Request::create($url, 'GET');
    $app->instance('request', $request);
    
    if (str_starts_with($url, '/admin')) {
        auth()->setUser($user);
    }

    $response = $kernel->handle($request);
    echo "Status: " . $response->getStatusCode() . "\n";
    if ($response->getStatusCode() !== 200) {
        if (isset($response->exception)) {
            echo "Exception: " . $response->exception->getMessage() . "\n";
            echo "File: " . $response->exception->getFile() . ":" . $response->exception->getLine() . "\n";
        }
    }
}
