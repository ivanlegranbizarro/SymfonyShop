<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadImage
{
    private const UPLOAD_PATH = __DIR__ . '/../../public/uploads/';

    public function uploadImageFile(UploadedFile $uploadedFile): string
    {
        $fileName = \uniqid() . '.' . $uploadedFile->guessExtension();
        if (!\is_dir(self::UPLOAD_PATH)) {
            \mkdir(self::UPLOAD_PATH, 0755, true);
        }
        $uploadedFile->move(self::UPLOAD_PATH, $fileName);
        return $fileName;
    }
    public function deleteImageFile(string $fileName): bool
    {
        $filePath = self::UPLOAD_PATH . $fileName;

        if (\file_exists($filePath) && \is_file($filePath)) {
            return \unlink($filePath);
        }

        return false;
    }
}
