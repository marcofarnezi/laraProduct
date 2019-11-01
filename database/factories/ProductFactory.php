<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Http\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'price' => $faker->randomFloat(2, 10, 100000),
        'avg_rating' => $faker->randomFloat(1, 100),
        'num_reviews' => $faker->randomDigitNotNull(),
        'amazon_date' => $faker->dateTimeThisMonth()
    ];
});
