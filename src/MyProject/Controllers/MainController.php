<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;

class MainController extends AbstractController
{
    public function main()
    {
        $this->page(1);
//        $articles = Article::findAll();
//
//        $this->view->renderHtml(
//            'main/main.php',
//            [
//                'title' => 'My Blog',
//                'articles' => $articles,
//                'pagesCount' => Article::getPagesCount(5),
//            ]
//
//        );
//
//        $this->view->renderHtml(
//            'main/main.php',
//            ['title' => 'My Blog', 'articles' => $articles]
//        );
    }

    public function page(int $pageNum)
    {
        $this->view->renderHtml('main/main.php',
            [
                'title' => 'My Blog',
                'articles' => Article::getPage($pageNum, 5),
                'pagesCount' => Article::getPagesCount(5),
                'currentPageNum' => $pageNum
            ]
        );
    }
}
