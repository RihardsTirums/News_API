<?php
namespace App\Services;

use App\Api;
use App\Models\Article;
use App\Models\Collections\ArticlesCollection;

class ArticlesService
{
    public function execute(string $query): ArticlesCollection
    {
        $pageSize = 10;
        $allArticles = (new Api())->newsApi()->getEverything($query,null,null,null,null,null,null,null,$pageSize);
        $articles = new ArticlesCollection();
        foreach ($allArticles->articles as $article) {
            $articles->add( new Article(
                $article->title,
                $article->url,
                $article->urlToImage,
                $article->publishedAt,
                strip_tags($article->description)
            ));
        }
        return $articles;
    }
}