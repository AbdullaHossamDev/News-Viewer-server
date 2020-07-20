<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class User_authenticate
{
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {    }

    public function register($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return app("App\Http\Controllers\API\AuthController")->register(
            [
                "name" => $args['name'],
                "email" => $args['email'],
                "birthDate" => $args['birthDate'],
            ]
        );
    }

    public function login($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return app("App\Http\Controllers\API\AuthController")->login(
            [
                "email" => $args['email'],
                "password" => $args['password'],
            ]
        );
    }

    public function logout($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return app("App\Http\Controllers\API\AuthController")->logout($context->request());
    }
}
