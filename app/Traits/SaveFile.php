<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

trait SaveFile
{
    /**
     * Saves an uploaded file to the specified public directory.
     *
     * @param UploadedFile $file The uploaded file instance.
     * @param string $directory The directory within 'public/' to save the file.
     * @param string|null $oldFileName The name of the old file to delete (optional).
     * @param string|null $requestId The unique request ID for logging (optional).
     * @return string The name of the saved file.
     */
    protected function saveImage(UploadedFile $file, string $directory, ?string $oldFileName = null, ?string $requestId = null): string
    {
        $publicPath = public_path($directory);

        // Delete old file if provided
        if ($oldFileName) {
            $oldFilePath = $publicPath . '/' . $oldFileName;
            if (File::exists($oldFilePath)) {
                File::delete($oldFilePath);
                Log::info("[{$requestId}] Old image '{$oldFileName}' deleted from '{$directory}'.");
            } else {
                Log::info("[{$requestId}] Old image '{$oldFileName}' not found at path '{$oldFilePath}' for deletion.");
            }
        }

        // Generate a unique file name
        $fileName = time() . '_' . uniqid() . '.' . $file->extension();

        // Move the new file
        $file->move($publicPath, $fileName);
        Log::info("[{$requestId}] New image uploaded: '{$fileName}' to '{$directory}'.");

        return $fileName;
    }

    /**
     * Deletes a file from the specified public directory.
     *
     * @param string $fileName The name of the file to delete.
     * @param string $directory The directory within 'public/' where the file is located.
     * @param string|null $requestId The unique request ID for logging (optional).
     * @return bool True if the file was deleted, false otherwise.
     */
    // protected function deleteFile(string $fileName, string $directory, ?string $requestId = null): bool
    // {
    //     $filePath = public_path($directory . '/' . $fileName);
    //     if (File::exists($filePath)) {
    //         File::delete($filePath);
    //         Log::info("[{$requestId}] File '{$fileName}' deleted from '{$directory}'.");
    //         return true;
    //     } else {
    //         Log::info("[{$requestId}] File '{$fileName}' not found at path '{$filePath}' for deletion.");
    //         return false;
    //     }
    // }
}