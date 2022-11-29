<?php

namespace App\Models;

use Carbon\Carbon;

class Article
{
    private string $title;
    private string $url;
    private string $description;
    private ?string $picture;
    private string $publishedAt;

    public function __construct(string $title, string $url, string $description, ?string $picture, string $publishedAt)
    {
        $this->title = $title;
        $this->url = $url;
        $this->description = $description;
        $this->picture = $picture;
        $this->publishedAt = $publishedAt;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function getPublishedAt(): string
    {
        return Carbon::createFromDate($this->publishedAt)->format('d/m/y h:i');
    }
}
