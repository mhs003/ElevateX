<?php
class Response
{
    public function send(string $content): void
    {
        echo $content;
    }

    public function json(array $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function http_code(int $resCode): void
    {
        http_response_code($resCode);
    }

    public function file(array $file): mixed
    {
        if ($file !== null) {
            $tempFilePath = $file['tmp_name'];
            $originalFileName = $file['name'];

            $destinationDir = 'uploads/';
            $destinationPath = $destinationDir . $originalFileName;

            if (move_uploaded_file($tempFilePath, $destinationPath)) {
                return $destinationPath;
            }
        }

        return false;
    }
}