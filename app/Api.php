<?php
namespace App;

use jcobhams\NewsApi\NewsApi;

class Api
{
    private NewsApi $newsApi;

    public function __construct()
    {
        $this->newsApi = new NewsApi($_ENV["API_KEY"]);
    }

    public function newsApi(): NewsApi
    {
        return $this->newsApi;
    }
}