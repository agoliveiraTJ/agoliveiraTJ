<?php

class UploadHelper
{
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];
    private const MAX_SIZE = 2097152;

    public static function uploadImage(array $file, string $folder = 'uploads'): ?string
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Erro ao enviar a imagem.');
        }

        if (($file['size'] ?? 0) > self::MAX_SIZE) {
            throw new RuntimeException('A imagem deve ter no maximo 2MB.');
        }

        $extension = strtolower(pathinfo($file['name'] ?? '', PATHINFO_EXTENSION));

        if (!in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            throw new RuntimeException('Formato invalido. Use JPG, PNG ou WEBP.');
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            throw new RuntimeException('Upload invalido.');
        }

        $imageInfo = getimagesize($file['tmp_name']);
        if ($imageInfo === false) {
            throw new RuntimeException('O arquivo enviado nao e uma imagem valida.');
        }

        $uploadDir = BASE_PATH . '/public/' . trim($folder, '/');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        $filename = uniqid('img_', true) . '.' . $extension;
        $destination = $uploadDir . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new RuntimeException('Nao foi possivel salvar a imagem.');
        }

        return trim($folder, '/') . '/' . $filename;
    }
}
