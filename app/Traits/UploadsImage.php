<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait UploadsImage
{
    /**
     * Konversi upload gambar / file menjadi Base64 Data URI string untuk disimpan ke database (LONGTEXT)
     * Dilengkapi kompresi cerdas GD agar ukuran payload ringan (< 400KB) dan tidak menyebabkan MySQL gone away.
     *
     * @param Request $request
     * @param string $fileField Nama input file (e.g. 'image_file', 'logo_file')
     * @param string $urlField Nama input teks URL / base64 string manual
     * @param string|null $oldValue Nilai lama jika tidak ada upload baru
     * @return string|null
     */
    public function handleImageUpload(Request $request, string $fileField = 'image_file', string $urlField = 'image', ?string $oldValue = null): ?string
    {
        // 1. Jika ada file yang diunggah
        if ($request->hasFile($fileField)) {
            $file = $request->file($fileField);
            $mimeType = $file->getMimeType() ?: 'application/octet-stream';

            // Kompresi otomatis jika file berupa gambar
            if (extension_loaded('gd') && str_starts_with($mimeType, 'image/')) {
                $compressed = $this->compressImageForBase64($file->getRealPath(), $mimeType);
                if ($compressed !== null) {
                    return "data:{$compressed['mime']};base64," . base64_encode($compressed['data']);
                }
            }

            // Fallback: baca langsung
            $fileData = file_get_contents($file->getRealPath());
            $base64 = base64_encode($fileData);
            return "data:{$mimeType};base64,{$base64}";
        }

        // 2. Jika admin memasukkan URL atau base64 string manual
        if ($request->filled($urlField)) {
            return $request->input($urlField);
        }

        // 3. Kembalikan nilai gambar lama jika tidak diubah
        return $oldValue;
    }

    /**
     * Alias untuk upload dokumen umum (PDF / Gambar)
     */
    public function handleFileUpload(Request $request, string $fileField, string $urlField, ?string $oldValue = null): ?string
    {
        return $this->handleImageUpload($request, $fileField, $urlField, $oldValue);
    }

    /**
     * Kompresi dan resizing proporsional gambar menggunakan PHP GD
     * Menghasilkan ukuran optimal (150KB - 350KB) dengan kualitas visual tetap jernih.
     */
    public function compressImageForBase64(string $filePath, string $mime, int $maxDimension = 1600, int $quality = 82): ?array
    {
        try {
            $img = null;
            if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
                $img = @imagecreatefromjpeg($filePath);
            } elseif ($mime === 'image/png') {
                $img = @imagecreatefrompng($filePath);
            } elseif ($mime === 'image/webp') {
                $img = @imagecreatefromwebp($filePath);
            }

            if (!$img) {
                return null;
            }

            $width = imagesx($img);
            $height = imagesy($img);

            // Perbaiki rotasi EXIF dari kamera smartphone
            if (function_exists('exif_read_data') && ($mime === 'image/jpeg' || $mime === 'image/jpg')) {
                $exif = @exif_read_data($filePath);
                if (!empty($exif['Orientation'])) {
                    switch ($exif['Orientation']) {
                        case 3:
                            $img = imagerotate($img, 180, 0);
                            break;
                        case 6:
                            $img = imagerotate($img, -90, 0);
                            $width = imagesx($img);
                            $height = imagesy($img);
                            break;
                        case 8:
                            $img = imagerotate($img, 90, 0);
                            $width = imagesx($img);
                            $height = imagesy($img);
                            break;
                    }
                }
            }

            // Hitung dimensi target maksimal 1600px
            $targetWidth = $width;
            $targetHeight = $height;

            if ($width > $maxDimension || $height > $maxDimension) {
                if ($width >= $height) {
                    $targetWidth = $maxDimension;
                    $targetHeight = (int) max(1, round(($height / $width) * $maxDimension));
                } else {
                    $targetHeight = $maxDimension;
                    $targetWidth = (int) max(1, round(($width / $height) * $maxDimension));
                }
            }

            $targetImg = imagecreatetruecolor($targetWidth, $targetHeight);

            if ($mime === 'image/png') {
                imagealphablending($targetImg, false);
                imagesavealpha($targetImg, true);
                $transparent = imagecolorallocatealpha($targetImg, 255, 255, 255, 127);
                imagefilledrectangle($targetImg, 0, 0, $targetWidth, $targetHeight, $transparent);
            }

            imagecopyresampled($targetImg, $img, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

            ob_start();
            $outMime = 'image/jpeg';
            if ($mime === 'image/png') {
                // Periksa apakah ada transparansi sesungguhnya
                $hasTransparency = false;
                for ($x = 0; $x < $targetWidth; $x += max(1, (int)($targetWidth / 20))) {
                    for ($y = 0; $y < $targetHeight; $y += max(1, (int)($targetHeight / 20))) {
                        $rgba = imagecolorat($targetImg, $x, $y);
                        if ((($rgba >> 24) & 0x7F) > 0) {
                            $hasTransparency = true;
                            break 2;
                        }
                    }
                }

                if ($hasTransparency) {
                    imagepng($targetImg, null, 7);
                    $outMime = 'image/png';
                } else {
                    imagejpeg($targetImg, null, $quality);
                    $outMime = 'image/jpeg';
                }
            } elseif ($mime === 'image/webp') {
                imagewebp($targetImg, null, $quality);
                $outMime = 'image/webp';
            } else {
                imagejpeg($targetImg, null, $quality);
                $outMime = 'image/jpeg';
            }

            $data = ob_get_clean();
            imagedestroy($img);
            imagedestroy($targetImg);

            return [
                'data' => $data,
                'mime' => $outMime,
            ];
        } catch (\Throwable $e) {
            Log::warning('Image compression error in trait: ' . $e->getMessage());
            return null;
        }
    }
}
