<?php

namespace MyProject\Controllers;

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

            Comment::addComment($_POST, $this->user, $article);
            header('Location: /articles/' . $articleId);

        } catch (InvalidArgumentException $e) {
            $article = new ArticlesController();
            $article->view($articleId, ['error' => $e->getMessage()]);
        }
    }
}
