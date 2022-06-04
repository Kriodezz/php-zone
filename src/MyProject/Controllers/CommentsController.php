<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Articles\Comment;

class CommentsController extends AbstractController
{
    public function addComment($articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        if ($this->user === null) {
            throw new UnauthorizedException(
                'Вы не авторизованы. Для доступа к этой странице нужно 
                <a href="/users/login">войти на сайт</a>'
            );
        }

        try {

            $comment = Comment::addComment($_POST, $this->user, $article);
            header('Location: /articles/' . $articleId . '#comment' . $comment->getId());
            exit();

        } catch (InvalidArgumentException $e) {
            $article = new ArticlesController();
            $article->view($articleId, ['error' => $e->getMessage()]);
        }
    }

    public function editComment($commentId)
    {
        $comment = Comment::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException();
        }

        if ($this->user === null) {
            throw new UnauthorizedException(
                'Вы не авторизованы. Для доступа к этой странице нужно 
                <a href="/users/login">войти на сайт</a>'
            );
        }

        if ( ($this->user->getRole() !== 'admin') && $this->user->getId() !== $comment->getUserId()) {
            throw new ForbiddenException('У вас нет прав на изминение этого комментария');
        }

        $article = Article::getById($comment->getArticleId());

        if (!empty($_POST)) {
            try {

                $comment->editComment($_POST);

            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml(
                    'articles/editArticle.php',
                    [
                        'title' => 'Редактирование',
                        'article' => $article,
                        'error' => $e->getMessage()
                    ]
                );

                return;

            }
            header('Location: /articles/' . $article->getId());
            exit();
        }

        $controller = new ArticlesController();
        $controller->view($article->getId(), ['commentEdit' => (int) $commentId]);
    }


    public function deleteComment($commentId)
    {
        $comment = Comment::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException();
        }

        if ($this->user === null) {
            throw new UnauthorizedException(
                'Вы не авторизованы. Для доступа к этой странице нужно 
                <a href="/users/login">войти на сайт</a>'
            );
        }

        if ( ($this->user->getRole() !== 'admin') && $this->user->getId() !== $comment->getUserId()) {
            throw new ForbiddenException('У вас нет прав на удаление этого комментария');
        }

        $comment->delete();

        header('Location: /articles/' . $comment->getArticleId());
        exit();
    }


}
