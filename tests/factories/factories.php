<?php
/**
 * Created by PhpStorm.
 * User: stefanriedel
 * Date: 24.03.15
 * Time: 15:30
 */

$factory('Laravel5Elasticsearch\Article', [
    'title' => $faker->name,
    'short_desc' => $faker->sentence(),
    'long_desc' => $faker->sentence(),
    'price' => $faker->randomFloat(),
    'vat' => 19
]);