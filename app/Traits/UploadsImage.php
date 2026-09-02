<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait UploadsImage
{
    /**
     * Handle Image upload or fallback to URL string
     *
     * @param Request $request
     * @param string $fileField
     * @param string $urlField
     * @param string $folder
     * @param string|null $oldImage
     * @return string|null
     */
    public function handleImageUpload(Request $request, string $fileField = 'image_file', string $urlField = 'image', string $folder = 'uploads', ?string $oldImage = null): ?string
    {
        if ($request->hasFile($fileField)) {
            $file = $request->file($fileField);
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/' . $folder, $filename);
            return '/storage/' . $folder . '/' . $filename;
        }

        if ($request->filled($urlField)) {
            return $request->input($urlField);
        }

        return $oldImage;
    }
}
