<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

if (!function_exists('uploadImage')) {
    /**
     * @param UploadedFile $image
     * @param int|null $resize_width
     * @param int|null $resize_height
     * @param string|null $model
     * @return bool|string
     */
    function uploadImage(UploadedFile $image, string $model = null, int $resize_width = null, int $resize_height = null): bool|string
    {
        $filename = rand(00000, 99999) . now()->timestamp . $image->getClientOriginalName();
        $path = 'files/' . $model;
        $image->storePubliclyAs('public/' . $path, $filename);
        return $path . '/' . $filename;
    }
}

if (!function_exists('deleteFile')) {
    /**
     * @param string|null $path
     * @return bool|string
     */
    function deleteFile(?string $path): bool|string
    {
        if (File::exists(storage_path($path))) {
            unlink($path);
        }
        return true;
    }
}
