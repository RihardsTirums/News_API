<?php
namespace App\Controllers;

use App\Api;
use App\Models\Article;
use App\Template;

class ArticlesController
{
    public function index(): Template
    {
        $query = $_GET["search"] ?? "Apple";
        $pageSize = 20;
        $allArticles = (new Api())->newsApi()->getEverything($query,null,null,null,null,null,null,null,$pageSize);
        $articles = [];
        foreach ($allArticles->articles as $article) {
            $articles[] = new Article(
                $article->title,
                $article->url,
                $article->urlToImage,
                strip_tags($article->description)
            );
        }
        return new Template('view.html.twig', ['articles' => $articles]);
    }
}

