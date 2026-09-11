<?php

// Pastikan environment APP_STORAGE terdefinisi untuk Vercel
$storagePath = '/tmp/storage';

if ((isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') || isset($_SERVER['VERCEL']) || isset($_ENV['VERCEL'])) {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}

$_ENV['APP_STORAGE'] = $storagePath;
$_SERVER['APP_STORAGE'] = $storagePath;
putenv("APP_STORAGE={$storagePath}");

// Alihkan cache bootstrap ke /tmp/storage/bootstrap karena folder bootstrap/cache bawaan read-only di Vercel
$cacheEnv = [
    'APP_SERVICES_CACHE' => "{$storagePath}/bootstrap/services.php",
    'APP_PACKAGES_CACHE' => "{$storagePath}/bootstrap/packages.php",
    'APP_CONFIG_CACHE'   => "{$storagePath}/bootstrap/config.php",
    'APP_ROUTES_CACHE'   => "{$storagePath}/bootstrap/routes.php",
    'APP_EVENTS_CACHE'   => "{$storagePath}/bootstrap/events.php",
];

foreach ($cacheEnv as $key => $val) {
    $_ENV[$key] = $val;
    $_SERVER[$key] = $val;
    putenv("{$key}={$val}");
}

// Buat folder storage sementara di /tmp (karena Vercel filesystem bersifat read-only kecuali /tmp)
$storageDirs = [
    $storagePath,
    $storagePath . '/app',
    $storagePath . '/app/public',
    $storagePath . '/bootstrap',
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

try {
    // Teruskan request ke file index utama Laravel
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    error_log((string) $e);
    http_response_code(500);

    if (getenv('APP_DEBUG') === 'true' || (isset($_ENV['APP_DEBUG']) && $_ENV['APP_DEBUG'] === 'true')) {
        echo "<div style='font-family:sans-serif; padding:30px; background:#fff1f2; border:1px solid #f43f5e; margin:20px; border-radius:8px;'>";
        echo "<h2 style='color:#be123c; margin-top:0;'>Laravel Server Error</h2>";
        echo "<p><strong>Pesan:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (Baris " . $e->getLine() . ")</p>";
        echo "<h3 style='color:#881337; margin-top:20px;'>Stack Trace:</h3>";
        echo "<pre style='background:#f8fafc; padding:15px; border-radius:6px; overflow:auto; font-size:13px; border:1px solid #e2e8f0;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        echo "</div>";
    } else {
        echo "<!DOCTYPE html><html><head><title>500 - Server Error</title><meta name='viewport' content='width=device-width, initial-scale=1.0'></head><body style='font-family:sans-serif; text-align:center; padding:50px; background:#f8fafc; color:#334155;'><h1 style='font-size:32px; color:#e11d48; margin-bottom:10px;'>500 | Server Error</h1><p style='font-size:16px;'>Terjadi kendala pada server. Silakan refresh halaman atau coba beberapa saat lagi.</p></body></html>";
    }
}
