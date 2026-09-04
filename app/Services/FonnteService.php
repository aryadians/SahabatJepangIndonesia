<?php

namespace App\Services;

use App\Models\SiteSetting;
use App\Models\WhatsAppLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    /**
     * Cek apakah Fonnte Gateway diaktifkan dan memiliki token di Pengaturan Admin
     */
    public static function isConfigured(): bool
    {
        $enabled = SiteSetting::get('fonnte_enabled', '0');
        $token = self::getToken();
        return ($enabled === '1' || $enabled === true || $enabled === 'true') && !empty($token);
    }

    /**
     * Ambil token Fonnte dari database pengaturan (fallback ke env jika ada)
     */
    public static function getToken(): string
    {
        $dbToken = SiteSetting::get('fonnte_api_token', '');
        if (!empty($dbToken)) {
            return trim($dbToken);
        }
        return (string) env('FONNTE_TOKEN', '');
    }

    /**
     * Kirim pesan WhatsApp via Fonnte Gateway API
     *
     * @param string $target Nomor tujuan (contoh: 08123456789 atau 628123456789)
     * @param string $message Isi teks pesan
     * @param array $options Opsional: countryCode, url, filename, recipient_name, template_key
     * @return array ['success' => bool, 'message' => string, 'response' => array|null]
     */
    public static function send(string $target, string $message, array $options = []): array
    {
        $token = self::getToken();
        $countryCode = $options['countryCode'] ?? SiteSetting::get('fonnte_country_code', '62');

        // Format nomor telepon menjadi format angka bersih internasional
        $cleanPhone = preg_replace('/[^0-9]/', '', $target);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        if (empty($token)) {
            return [
                'success' => false,
                'message' => 'Token API Fonnte belum diatur pada Pengaturan Admin.',
                'response' => null,
            ];
        }

        try {
            $payload = [
                'target' => $cleanPhone,
                'message' => $message,
                'countryCode' => $countryCode,
            ];

            if (!empty($options['url'])) {
                $payload['url'] = $options['url'];
            }
            if (!empty($options['filename'])) {
                $payload['filename'] = $options['filename'];
            }

            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->timeout(10)->post('https://api.fonnte.com/send', $payload);

            $resJson = $response->json();
            $isSuccess = $response->successful() && (($resJson['status'] ?? false) === true);

            // Simpan audit trail ke WhatsAppLog
            WhatsAppLog::create([
                'recipient_phone' => $cleanPhone,
                'recipient_name' => $options['recipient_name'] ?? null,
                'template_key' => $options['template_key'] ?? 'fonnte_gateway',
                'message_body' => $message,
                'status' => $isSuccess ? 'sent' : 'failed',
            ]);

            return [
                'success' => $isSuccess,
                'message' => $resJson['detail'] ?? ($isSuccess ? 'Pesan berhasil terkirim melalui Fonnte Gateway.' : 'Fonnte merespons dengan status gagal.'),
                'response' => $resJson,
            ];
        } catch (\Throwable $e) {
            Log::error('Fonnte Gateway Dispatch Error: ' . $e->getMessage());

            WhatsAppLog::create([
                'recipient_phone' => $cleanPhone,
                'recipient_name' => $options['recipient_name'] ?? null,
                'template_key' => $options['template_key'] ?? 'fonnte_gateway',
                'message_body' => $message,
                'status' => 'failed',
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menghubungi server Fonnte: ' . $e->getMessage(),
                'response' => null,
            ];
        }
    }

    /**
     * Cek status koneksi device Fonnte & sisa kuota pengiriman
     */
    public static function checkDevice(): array
    {
        $token = self::getToken();
        if (empty($token)) {
            return [
                'success' => false,
                'message' => 'Token API Fonnte belum diisi di Pengaturan.',
                'device' => null,
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->timeout(8)->post('https://api.fonnte.com/device');

            $resJson = $response->json();
            $isSuccess = $response->successful() && (($resJson['status'] ?? false) === true);

            return [
                'success' => $isSuccess,
                'message' => $resJson['detail'] ?? ($isSuccess ? 'Device Fonnte Terhubung Aktif' : 'Status Fonnte: ' . json_encode($resJson)),
                'device' => $resJson,
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Koneksi ke server Fonnte gagal: ' . $e->getMessage(),
                'device' => null,
            ];
        }
    }
}
