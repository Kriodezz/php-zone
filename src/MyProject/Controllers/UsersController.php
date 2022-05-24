<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidActivationException;
use MyProject\Models\Users\User;
use MyProject\Services\SendMailForSignUp;
use MyProject\View\View;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Users\UserActivationService;
use PHPMailer\PHPMailer\Exception;

class UsersController
{

    protected $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function signUp()
    {
        if (!empty($_POST)) {
            try {

                $user = User::signUp($_POST);

            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/signUp.php', [
                    'error' => $e->getMessage(),
                    'title' => 'Регистрация'
                ]);
                return;
            }

            try {

                $code = UserActivationService::createActivationCode($user);
                SendMailForSignUp::sendMail($user, ['userId' => $user->getId(), 'code' => $code]);

            } catch (Exception $e) {
                $log = fopen(__DIR__ . '/../Logs/ErrorLogSendMail.txt', 'a');
                fwrite($log, date('Y-m-d h:m:i') . ' ' . $e->getMessage() . "\n");
                fclose($log);

                $this->view->renderHtml('users/signUp.php', [
                    'error' => 'Что-то пошло не так:( Повторите попытку позже',
                    'title' => 'Регистрация'
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
                ['title' => 'Ошибка', 'error' => 'Не найден пользователь']);
            return;
        }

        $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
        if ($isCodeValid) {
            $user->activate();
            UserActivationService::delete($activationCode);

            $this->view->renderHtml(
                'users/activationSuccessful.php',
                ['title' => 'Ура!!!']);
        } else {
            $this->view->renderHtml(
                'errors/500.php',
                ['title' => 'Ошибка', 'error' => 'Не верный код активации']);
        }
    }
}
