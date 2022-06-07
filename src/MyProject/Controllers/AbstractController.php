<?php

namespace MyProject\Controllers;

use MyProject\Models\Users\{
    User,
    UsersAuthService
};
use MyProject\View\View;

abstract class AbstractController
{
    protected View $view;

    protected ?User $user;

    public function __construct()
    {
        $this->user = UsersAuthService::getUserByToken();
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->view->setVars('user', $this->user);
    }
}
