<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait UploadsImage
{
    /**
     * Konversi upload gambar / file menjadi Base64 Data URI string untuk disimpan ke database (LONGTEXT)
     *
     * @param Request $request
     * @param string $fileField Nama input file (e.g. 'image_file', 'logo_file')
     * @param string $urlField Nama input teks URL / base64 string manual
     * @param string|null $oldValue Nilai lama jika tidak ada upload baru
     * @return string|null
     */
    public function handleImageUpload(Request $request, string $fileField = 'image_file', string $urlField = 'image', ?string $oldValue = null): ?string
    {
        // 1. Jika ada file yang diunggah (gambar atau video), konversi ke Base64 Data URI
        if ($request->hasFile($fileField)) {
            $file = $request->file($fileField);
            $mimeType = $file->getMimeType();
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
}
