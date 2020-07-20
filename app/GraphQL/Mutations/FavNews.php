<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class FavNews
{
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {    }

    public function getFav($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return app("App\Http\Controllers\API\NewsController")->index($context->request());
    }

    public function save($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return app("App\Http\Controllers\API\NewsController")->store($context->request(), 
            [
                "source" => $args["input"]["source"],
                "author" => $args["input"]["author"],
                "title"  => $args["input"]["title"],
                "url"    => $args["input"]["url"],
                "type"   => $args["input"]["type"],
                "description" => $args["input"]["description"],
                "urlToImage"  => $args["input"]["urlToImage"],
                "publishedAt" => $args["input"]["publishedAt"],
            ]
    );  
     
    }
}
