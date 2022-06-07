<?php

namespace MyProject\Controllers;


use MyProject\Exceptions\{
    ForbiddenException,
    InvalidArgumentException,
    NotFoundException
};
use MyProject\Models\Articles\{
    Article,
    Comment
};
use MyProject\Models\Users\Admin;

class AdminsController extends AbstractController
{
    private function isNoAdmin()
    {
        if ( ($this->user === null) || ($this->user->getRole() !== 'admin') ) {
            header('Location: /');
            exit();
        }
    }

    public function enter()
    {
        $this->isNoAdmin();

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

            } catch (ForbiddenException $e) {

                setcookie('token', '', time() - 3600, '/', '', false, true);
                header('Location: /');
                exit();
            }
        }

        $this->view->renderHtml('admin/enter.php', ['title' => 'Администрация']);
    }

    public function index()
    {
        $this->isNoAdmin();

        $this->view->renderHtml('admin/index.php', ['title' => 'Администрация']);
    }

    public function articles() {

        $this->isNoAdmin();

        $articles = Article::findAll();

        $this->view->renderHtml(
            'admin/articles.php',
            ['title' => 'Статьи', 'articles' => $articles]
        );
    }

    public function editArticle($articleId)
    {
        $this->isNoAdmin();

        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        if (!empty($_POST)) {
            try {

                $article->updateArticle($_POST);

            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml(
                    'admin/editArticle.php',
                    [
                        'title' => 'Редактирование',
                        'article' => $article,
                        'error' => $e->getMessage()
                    ]
                );

                return;
            }

            header('Location: /admin/articles');
            exit();
        }

        $this->view->renderHtml('admin/editArticle.php',
            ['title' => 'Редактирование', 'article' => $article]
        );
    }

    public function deleteArticle($articleId)
    {
        $this->isNoAdmin();

        $article = Article::getById($articleId);

        $article->delete();

        header('Location: /admin/articles');
        exit();
    }

    public function comments()
    {
        $this->isNoAdmin();

        $comments = Comment::findAll();

        $this->view->renderHtml('admin/comments.php',
            ['title' => 'Комментарии', 'comments' => $comments]);
    }

    public function editComments($commentId)
    {
        $this->isNoAdmin();

        $comment = Comment::getById($commentId);

        if (!empty($_POST)) {

            $comment->editComment($_POST);

            header('Location: /admin/comments');
            exit();
        }

        $this->view->renderHtml('admin/editComment.php',
            ['title' => 'Редактирование', 'comment' => $comment]);
    }

    public function deleteComments($commentId)
    {
        $this->isNoAdmin();

        $comment = Comment::getById($commentId);

        $comment->delete();

        header('Location: /admin/comments');
        exit();
    }
}
