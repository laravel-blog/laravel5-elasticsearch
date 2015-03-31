<?php
use Laravel5Elasticsearch\Article;

/**
 * Created by PhpStorm.
 * User: stefanriedel
 * Date: 24.03.15
 * Time: 10:42
 */
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class ArticlesTableSeeder extends Seeder {

    public function run() {
        Laracasts\TestDummy\Factory::times(50)->create('Laravel5Elasticsearch\Article');
    }

}