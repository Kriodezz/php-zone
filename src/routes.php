<?php

use MyProject\Controllers\ArticlesController;
use MyProject\Controllers\MainController;
use MyProject\Controllers\UsersController;
use MyProject\Controllers\CommentsController;

return [
    '~^$~' => [MainController::class, 'main'],
    '~^articles/(\d+)$~' => [ArticlesController::class, 'view'],
    '~^articles/create$~' => [ArticlesController::class, 'create'],
    '~^articles/(\d+)/edit$~' => [ArticlesController::class, 'edit'],
    '~^articles/(\d+)/remove$~' => [ArticlesController::class, 'remove'],
    '~^users/register$~' => [UsersController::class, 'signUp'],
    '~^users/(\d+)/activate/(.+)$~' => [UsersController::class, 'activate'],
    '~^users/login$~' => [UsersController::class, 'login'],
    '~^users/logout$~' => [UsersController::class, 'logout'],
    '~^articles/(\d+)/comments~' => [CommentsController::class, 'addComment']
];
