<?php
namespace App\Controllers;

use App\Template;
use App\Services\ArticlesService;

class ArticlesController
{
    public function view(): Template
    {
        $query = $_GET["search"] ?? "Apple";

        $articles = (new ArticlesService())->execute($query);

        return new Template('view.html.twig', ['articles' => $articles->get()]);
    }
}

