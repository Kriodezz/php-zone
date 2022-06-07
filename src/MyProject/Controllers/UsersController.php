<?php

namespace MyProject\Controllers;

use MyProject\Models\Users\{
    User,
    UserAvatar,
    UsersAuthService,
    UserActivationService
};
use MyProject\Exceptions\{
    InvalidArgumentException,
    UserAvatarException
};
use MyProject\Services\SendMailForSignUp;
use PHPMailer\PHPMailer\Exception;

class UsersController extends AbstractController
{
    public function signUp()
    {
        if (!empty($_POST)) {
            try {

                $user = User::signUp($_POST);
                $code = UserActivationService::createActivationCode($user);
                SendMailForSignUp::sendMail($user, ['userId' => $user->getId(), 'code' => $code]);

            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/signUp.php',
                    ['title' => 'Регистрация', 'error' => $e->getMessage()]
                );
                return;

            } catch (Exception $e) {
                $log = fopen(__DIR__ . '/../Logs/ErrorLogSendMail.txt', 'a');
                fwrite($log, date('Y-m-d h:i:s') . ' | ' . $e->getMessage() . "\n");
                fclose($log);

                $this->view->renderHtml('users/signUp.php', [
                    'title' => 'Регистрация',
                    'error' => 'Что-то пошло не так:( Повторите попытку позже'
                ]);
                return;
            }

            $this->view->renderHtml(
                'users/signUpSuccessful.php',
                ['title' => 'Ура!!!']);
            return;
        }

        $this->view->renderHtml('users/signUp.php', ['title' => 'Регистрация']);
    }

    public function activate(int $userId, string $activationCode)
    {

        $user = User::getById($userId);

        if (null === $user) {
            $this->view->renderHtml(
                'errors/500.php',
                ['title' => 'Ошибка', 'error' => 'Не найден пользователь']
            );
            return;
        }

        $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
        if ($isCodeValid) {
            $user->activate();
            UserActivationService::delete($activationCode);

            $this->view->renderHtml(
                'users/activationSuccessful.php',
                ['title' => 'Ура!!!']
            );
        } else {
            $this->view->renderHtml(
                'errors/500.php',
                ['title' => 'Ошибка', 'error' => 'Не верный код активации']
            );
        }
    }

    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml(
                    'users/login.php',
                    ['title' => 'Авторизация', 'error' => $e->getMessage()]
                );
                return;
            }
        }
        $this->view->renderHtml('users/login.php', ['title' => 'Авторизация']);
    }

    public function logout(): void
    {
        if ($this->user !== null) {
            UsersAuthService::logout();
        } else {
            $this->view->renderHtml(
                'users/login.php',
                ['title' => 'Авторизация', 'error' => 'Сначала необходимо авторизоваться']
            );
        }
    }

    public function loadAvatar($userId)
    {
        try {
            if (!empty($_FILES)) {
                UserAvatar::upload($_FILES, $userId);

                header('Location: /');
                exit();
            }

        } catch (UserAvatarException $e) {
            $this->view->renderHtml(
                'users/loadAvatar.php',
                ['title' => 'Загрузка авы', 'error' => $e->getMessage()]
            );
            return;
        }

        $this->view->renderHtml(
            'users/loadAvatar.php', ['title' => 'Загрузка авы']
        );
    }
}
