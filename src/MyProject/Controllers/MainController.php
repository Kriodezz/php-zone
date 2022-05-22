<?php

namespace MyProject\Controllers;

use MyProject\View\View;
use MyProject\Models\Articles\Article;

class MainController
{

    /** @var View */
    protected View $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', ['articles' => $articles, 'title' => 'My Blog']);
    }

    public function sayHello(string $name)
    {
        $this->view->renderHtml('main/hello.php', ['name' => $name, 'title' => 'Hello, ' . $name]);
    }

    public function sayBye(string $name)
    {
        echo 'Пока, ' . $name;
    }
}
