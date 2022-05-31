<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Users\Admin;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UsersAuthService;

class AdminsController extends AbstractController
{

    public function enter()
    {
        if ($this->user->getRole() !== 'admin') {
            header('Location: /');
            exit();
        }

        if (!empty($_POST)) {
            try {

                Admin::checkEnterAdmin($_POST);

                $this->view->renderHtml('admin/index.php', ['title' => 'Администрация']);
                return;

            } catch (InvalidArgumentException $e) {

                $this->view->renderHtml(
                    'admin/enter.php',
                    ['title' => 'Администрация', 'error' => $e->getMessage()]);
                return;
            }

        }

        $this->view->renderHtml('admin/enter.php', ['title' => 'Администрация']);
    }

    public function articles() {
        $this->view->renderHtml('admin/articles.php', ['title' => 'Статьи']);
    }

    public function comments() {
        $this->view->renderHtml('admin/comments.php', ['title' => 'Комментарии']);
    }

}
