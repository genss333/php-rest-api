<?php
class ImageUploader
{
    private $targetDir = '../uploadFile/';

    public function __construct()
    {
        if (!file_exists($this->targetDir)) {
            mkdir($this->targetDir, 0777, true);
        }
    }

    public function uploadImage($file)
    {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $imageName = uniqid() . '_' . basename($file['name']);
            $targetFilePath = $this->targetDir . $imageName;

            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                return $targetFilePath;
            } else {
                throw new Exception('Failed to upload image');
            }
        } else {
            throw new Exception('Image file is required');
        }
    }
}
?>
