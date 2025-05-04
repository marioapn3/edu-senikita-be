<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    public function upload(UploadedFile $file, $folder = 'default'): string
    {
        // Gunakan hash nama file untuk menghindari duplikat nama
        $filename = $this->generateUniqueFilename($file);

        $path = $file->storeAs($folder, $filename, 'public');

        return $path;
    }

    protected function generateUniqueFilename(UploadedFile $file): string
    {
        // Gunakan hash dari konten file + ekstensi
        $hash = md5_file($file->getRealPath()); // hash dari isi file
        $ext = $file->getClientOriginalExtension();

        return $hash . '.' . $ext;
    }
}
