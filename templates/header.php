<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/styles.css">
    <title><?php echo $title; ?></title>
</head>

<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">
            Мой блог
        </td>
    </tr>

    <tr>
        <td colspan="2" style="text-align: right">
            <?php if (!empty($user)) {
                echo 'Привет, ' . $user->getNickname(); ?> | <a href="/users/logout">Выйти</a>
            <?php } else { ?>
                <a href="/users/login">Войти</a> | <a href="/users/register">Зарегистрироваться</a>
            <?php } ?>
        </td>
    </tr>

    <tr>
        <td>
