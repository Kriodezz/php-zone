<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\View\View;
use MyProject\Models\Users\User;
use MyProject\Exceptions\NotFoundException;

class ArticlesController
{
    protected View $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

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
        $author = User::getById(1);

        $article = new Article();
        $article->setName('Имя6 созданной статьи');
        $article->setText('Текст6 созданной статьи');
        $article->setAuthor($author);
        //$article->setCreatedAt(date('Y-m-d H:i:s'));
        $article->save();
        var_dump($article);
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
