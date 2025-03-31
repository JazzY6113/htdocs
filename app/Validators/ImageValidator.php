<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class ImageValidator extends AbstractValidator
{
    protected string $message = 'Недопустимое изображение';
    private int $maxSize = 2048; // 2MB в KB

    public function rule(): bool
    {
        if (empty($this->value) || $this->value['error'] !== UPLOAD_ERR_OK) {
            $this->message = 'Ошибка загрузки файла';
            return false;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileInfo = getimagesize($this->value['tmp_name']);

        if (!$fileInfo || !in_array($fileInfo['mime'], $allowedTypes)) {
            $this->message = 'Допустимы только JPG, PNG или GIF';
            return false;
        }

        if ($this->value['size'] > $this->maxSize * 1024) {
            $this->message = 'Максимальный размер файла - 2MB';
            return false;
        }

        return true;
    }
}