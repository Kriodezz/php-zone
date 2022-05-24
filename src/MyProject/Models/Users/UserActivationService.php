<?php

namespace MyProject\Models\Users;

use MyProject\Services\Db;

class UserActivationService
{
    private const TABLE_NAME = 'users_activation_codes';

    public static function createActivationCode(User $user): string
    {
        // Генерируем случайную последовательность символов
        $code = bin2hex(random_bytes(16));

        $db = Db::getInstance();
        $db->execute(
            'INSERT INTO ' . self::TABLE_NAME . ' (user_id, code) VALUES (:user_id, :code)',
            [
                'user_id' => $user->getId(),
                'code' => $code
            ]
        );

        return $code;
    }

    public static function delete($activationCode)
    {
        $db = Db::getInstance();
        $db->execute(
            'DELETE FROM ' . self::TABLE_NAME . ' WHERE code = :code',
            [':code' => $activationCode]
        );

    }

    public static function checkActivationCode(User $user, string $code): bool
    {
        $db = Db::getInstance();
        $result = $db->query(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE user_id = :user_id AND code = :code',
            [
                'user_id' => $user->getId(),
                'code' => $code
            ]
        );

        return !empty($result);
    }
}
