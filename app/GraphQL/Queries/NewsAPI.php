<?php

namespace App\GraphQL\Queries;

class NewsAPI
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        return app("App\Http\Controllers\API\NewsAPIController")->getNews();
    }
}
