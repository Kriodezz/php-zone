<?php

namespace MyProject\Models\Users;

use MyProject\Exceptions\{
    ForbiddenException,
    InvalidArgumentException
};

class Admin
{
    public static function checkEnterAdmin($adminData)
    {
        if (empty($adminData['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }

        if (empty($adminData['password'])) {
            throw new InvalidArgumentException('Не передан password');
        }

        $admin = User::findOneByColumn('email', $adminData['email']);
        if ($admin === null) {
            throw new InvalidArgumentException('Нет пользователя с таким email');
        }

        if (!password_verify($adminData['password'], $admin->getPasswordHash())) {
            throw new InvalidArgumentException('Неправильный пароль');
        }

        if ($admin->getRole() !== 'admin') {
            throw new ForbiddenException('Вы не являетесь администратором');
        }
    }
}
