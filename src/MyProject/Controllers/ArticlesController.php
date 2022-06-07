<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\{
    ForbiddenException,
    InvalidArgumentException,
    NotFoundException,
    UnauthorizedException
};
use MyProject\Models\Articles\{
    Article,
    Comment
};

class ArticlesController extends AbstractController
{
    public function view(int $articleId, array $vars = [])
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $comments = Comment::findAllCommentForArticle(
            'article_id',
            $article->getId()
        );

        if ($comments !== null) {
//            $commentsForView = [];
//            foreach ($comments as $comment) {
//                $commentsForView[$comment->getId()] = $comment->getComment();
//            }
            $this->view->setVars('comments', $comments);
        }

//        $reflector = new \ReflectionObject($article);
//        $properties = $reflector->getProperties();
//        $propertiesNames = [];
//        foreach ($properties as $property) {
//            $propertiesNames[] = $property->name;
//        }
//        var_dump($propertiesNames);
//        return;

        $this->view->renderHtml(
            'articles/view.php',
            array_merge(['title' => 'Article ' . $articleId, 'article' => $article], $vars)
        );
    }

    public function create()
    {

        if ($this->user === null) {
            throw new UnauthorizedException(
                'Вы не авторизованы. Для доступа к этой странице нужно 
                <a href="/users/login">войти на сайт</a>'
            );
        }

        if ($this->user->getRole() !== 'admin') {
            throw new ForbiddenException('У вас нет прав на добавление новых статей');
        }

        if (!empty($_POST)) {
            try {

                $article = Article::createArticle($_POST, $this->user);

            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/create.php',
                    ['title' => 'Новая статья', 'error' => $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $article->getId());
            exit();
        }

        $this->view->renderHtml('articles/create.php', ['title' => 'Новая статья']);
    }

    public function edit(int $articleId)
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

        if ($this->user->getRole() !== 'admin') {
            throw new ForbiddenException('У вас нет прав на редактирование статей');
        }

        if (!empty($_POST)) {
            try {

                $article->updateArticle($_POST);

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

        $this->view->renderHtml('articles/editArticle.php',
            ['title' => 'Редактирование', 'article' => $article]
        );
    }

    public function delete(int $articleId)
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

        if ($this->user->getRole() !== 'admin') {
            throw new ForbiddenException('У вас нет прав на удаление статей');
        }

        $article->delete();

        header('Location: /');
        exit();
    }
}
