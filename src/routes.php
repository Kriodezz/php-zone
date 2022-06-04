<?php

use MyProject\Controllers\AdminsController;
use MyProject\Controllers\ArticlesController;
use MyProject\Controllers\MainController;
use MyProject\Controllers\UsersController;
use MyProject\Controllers\CommentsController;

return [
    '~^$~' => [MainController::class, 'main'],
    '~^articles/(\d+)$~' => [ArticlesController::class, 'view'],
    '~^articles/create$~' => [ArticlesController::class, 'create'],
    '~^articles/(\d+)/edit$~' => [ArticlesController::class, 'edit'],
    '~^articles/(\d+)/delete$~' => [ArticlesController::class, 'delete'],
    '~^users/register$~' => [UsersController::class, 'signUp'],
    '~^users/(\d+)/activate/(.+)$~' => [UsersController::class, 'activate'],
    '~^users/login$~' => [UsersController::class, 'login'],
    '~^users/logout$~' => [UsersController::class, 'logout'],
    '~^users/(\d+)/load-avatar$~' => [UsersController::class, 'loadAvatar'],
    '~^articles/(\d+)/comments~' => [CommentsController::class, 'addComment'],
    '~^comments/(\d+)/edit~' => [CommentsController::class, 'editComment'],
    '~^comments/(\d+)/delete~' => [CommentsController::class, 'deleteComment'],
    '~^admin/482$~' => [AdminsController::class, 'enter'],
    '~^admin/index$~' => [AdminsController::class, 'index'],
    '~^admin/articles$~' => [AdminsController::class, 'articles'],
    '~^admin/articles/(\d+)/edit$~' => [AdminsController::class, 'editArticle'],
    '~^admin/articles/(\d+)/delete$~' => [AdminsController::class, 'deleteArticle'],
    '~^admin/comments$~' => [AdminsController::class, 'comments'],
    '~^admin/comments/(\d+)/edit$~' => [AdminsController::class, 'editComments'],
    '~^admin/comments/(\d+)/delete$~' => [AdminsController::class, 'deleteComments']
];
