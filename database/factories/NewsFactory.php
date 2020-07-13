<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\News;
use App\User;
use Faker\Generator as Faker;
// egyBusiness, egySports, uaeBusiness, uaeSports
$factory->define(News::class, function (Faker $faker) {
    return [
        'userId' => 'factory:App\User',
        'source' => $faker->name,
        'author' => $faker->name,
        'type' => 'egySports',
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'url' => $faker->url,
        'urlToImage' => $faker->imageUrl,
        'publishedAt' => now()
    ];
});
