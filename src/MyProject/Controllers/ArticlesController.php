<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Exceptions\NotFoundException;

class ArticlesController extends AbstractController
{

    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
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
            ['article' => $article, 'title' => 'Article ' . $articleId]);
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

                $article = Article::createFromArray($_POST, $this->user);

            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/add.php', ['error' => $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
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

        $article->setName('Новое название статьи');
        $article->setText('Новый текст статьи');

        $article->save();
    }

    public function remove(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $article->delete();
    }
}
