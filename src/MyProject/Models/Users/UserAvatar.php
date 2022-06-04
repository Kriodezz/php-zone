<?php

namespace MyProject\Models\Users;

use MyProject\Exceptions\UserAvatarException;
use MyProject\Services\Uploader;

class UserAvatar
{
    protected string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public static function upload($files, $userId)
    {
        $formName = 'user-avatar';

        if (!is_uploaded_file($files[$formName]['tmp_name'])) {
            throw new UserAvatarException('Вы загружаете файл не так, как нужно');
        }

        $extension = pathinfo(($files[$formName]['name']))['extension'];
        if (($extension !== 'jpg') && ($extension !== 'bmp') && ($extension !== 'jpeg')) {
            throw new UserAvatarException('Неверный формат файла');
        }

        $upload = new Uploader($formName);
        $upload->upload(
            __DIR__ . '/../../../../files/userAvatar/' .
            $userId . '.' . $extension
        );
    }
}