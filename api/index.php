<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Pastikan environment APP_STORAGE terdefinisi untuk Vercel
$storagePath = '/tmp/storage';

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

// Tangani fatal error jika terjadi sebelum output dikirim
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        http_response_code(500);
        echo "<div style='font-family:sans-serif; padding:30px; background:#fff1f2; border:1px solid #f43f5e; margin:20px; border-radius:8px;'>";
        echo "<h2 style='color:#be123c; margin-top:0;'>PHP Fatal Error</h2>";
        echo "<p><strong>Pesan:</strong> " . htmlspecialchars($error['message']) . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($error['file']) . " (Baris " . $error['line'] . ")</p>";
        echo "</div>";
    }
});

try {
    // Teruskan request ke file index utama Laravel
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<div style='font-family:sans-serif; padding:30px; background:#fff1f2; border:1px solid #f43f5e; margin:20px; border-radius:8px;'>";
    echo "<h2 style='color:#be123c; margin-top:0;'>Laravel Server Error</h2>";
    echo "<p><strong>Pesan:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (Baris " . $e->getLine() . ")</p>";
    echo "<h3 style='color:#881337; margin-top:20px;'>Stack Trace:</h3>";
    echo "<pre style='background:#f8fafc; padding:15px; border-radius:6px; overflow:auto; font-size:13px; border:1px solid #e2e8f0;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div>";
}
