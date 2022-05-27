<?php

try {

    require_once __DIR__ . '/autoloadMain.php';
    require_once __DIR__ . '/vendor/autoload.php';

    $route = $_GET['route'] ?? '';
    $routes = require __DIR__ . '/src/routes.php';

    $isRouteFound = false;

    foreach ($routes as $pattern => $controllerAndAction) {
        preg_match($pattern, $route, $matches);
        if (!empty($matches)) {
            $isRouteFound = true;
            break;
        }
    }

    if (!$isRouteFound) {
        throw new \MyProject\Exceptions\NotFoundException();
    }

    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

    unset($matches[0]);

    $controller = new $controllerName();
    $controller->$actionName(...$matches);

} catch (\MyProject\Exceptions\DbException $e) {
    $view = new \MyProject\View\View(__DIR__ . '/templates/errors');
    $view->renderHtml('500.php',
        ['title' => 'Ошибка', 'error' => $e->getMessage()], 500
    );

} catch (\MyProject\Exceptions\NotFoundException $e) {
    $view = new \MyProject\View\View(__DIR__ . '/templates/errors');
    $view->renderHtml('404.php',
        ['title' => 'Ошибка доступа', 'error' => $e->getMessage()], 404
    );

} catch (\MyProject\Exceptions\UnauthorizedException $e) {
    $view = new \MyProject\View\View(__DIR__ . '/templates/errors');
    $view->renderHtml('400+.php',
        ['title' => 'Ошибка доступа', 'error' => $e->getMessage()], 401);
}
