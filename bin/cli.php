<?php

require_once __DIR__ . '/../autoloadMain.php';
require_once __DIR__ . '/../vendor/autoload.php';

try {

    unset($argv[0]);

    // Регистрируем функцию автозагрузки
    spl_autoload_register(function (string $className) {
        require_once __DIR__ . '/../src/' . $className . '.php';
    });

    // Составляем полное имя класса, добавив нэймспейс
    $className = '\\MyProject\\Cli\\' . array_shift($argv);

    if (!class_exists($className)) {
        throw new \MyProject\Exceptions\CliException(
            'Class "' . $className . '" not found'
        );
    }

    if (!in_array('MyProject\Cli\AbstractCommand', class_parents($className))) {
        throw new \MyProject\Exceptions\CliException(
            'Class "' . $className . '" not allowed'
        );
    }

    // Подготавливаем список аргументов
    $params = [];
    foreach ($argv as $argument) {
        preg_match('/^-(.+)=(.+)$/', $argument, $matches);
        if (!empty($matches)) {
            $paramName = $matches[1];
            $paramValue = $matches[2];

            $params[$paramName] = $paramValue;
        }
    }

    // Создаём экземпляр класса, передав параметры и вызываем метод execute()
    $class = new $className($params);
    $class->execute();
} catch (\MyProject\Exceptions\CliException $e) {
    echo 'Error: ' . $e->getMessage();
}
