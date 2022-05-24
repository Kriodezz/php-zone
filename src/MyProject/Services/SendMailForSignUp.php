<?php

namespace MyProject\Services;

use MyProject\Models\Users\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendMailForSignUp extends \PHPMailer\PHPMailer\PHPMailer
{
    public static function sendMail(User $user, array $templateVars = []): void
    {
        extract($templateVars);

        ob_start();
        require __DIR__ . '/../../../templates/mail/userActivation.php';
        $body = ob_get_contents();
        ob_end_clean();

        $mail = new PHPMailer(TRUE);
        //$mail->SMTPDebug = 4;

        $mail->setFrom('kriodezztarakanov@yandex.ru');  //почта адресанта
        $mail->addAddress($user->getEmail());  //почта адресата
        $mail -> isHTML ( true );
        $mail->Subject = 'Активация аккаунта'; //тема
        $mail->Body = 'http://php-zone/users/' . $user->getId() . '/activate/' . $code;
//        $mail->Body = $body;
//        $mail->AltBody = 'Добро пожаловать на наш портал! Для активации вашего аккаунта
//    перейдите по ссылке http://php-zone/users/' . $user->getId() . '/activate/' . $code;
        $mail->isSMTP();
        $mail->CharSet = "utf-8";
        $mail->Host = 'smtp.yandex.ru';
        $mail->SMTPAuth = TRUE;
        $mail->SMTPSecure = 'ssl';
        $mail->Username = '***';
        $mail->Password = '***';
        $mail->Port = 465;
        $mail->send();
    }
}
