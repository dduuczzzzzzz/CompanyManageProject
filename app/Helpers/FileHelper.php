<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public static function deleteFileFromStorage($path): bool
    {
        return Storage::disk('public')->delete($path);
    }

    public static function saveFileToStorage($folder, $file, $path): bool
    {
        return Storage::putFileAs($folder, $file, $path);
    }

    public static function clearDir($folder): bool
    {
        $files =   Storage::allFiles($folder);
        if($files) return Storage::disk('public')->delete($files);
        return false;
    }


}
