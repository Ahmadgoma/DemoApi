<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' =>$faker->name,
        'body' =>$faker->paragraph(200),
        'category_id' =>$faker->randomElement([1,2,3,4,5]),
    ];
});
