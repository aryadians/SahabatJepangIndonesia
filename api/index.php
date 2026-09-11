<?php

// Pastikan environment APP_STORAGE terdefinisi untuk Vercel
$storagePath = '/tmp/storage';

$_ENV['APP_STORAGE'] = $storagePath;
$_SERVER['APP_STORAGE'] = $storagePath;
putenv("APP_STORAGE={$storagePath}");

// Buat folder storage sementara di /tmp (karena Vercel filesystem bersifat read-only kecuali /tmp)
$storageDirs = [
    $storagePath,
    $storagePath . '/app',
    $storagePath . '/app/public',
    $storagePath . '/framework',
    $storagePath . '/framework/cache',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/testing',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Teruskan request ke file index utama Laravel
require __DIR__ . '/../public/index.php';

