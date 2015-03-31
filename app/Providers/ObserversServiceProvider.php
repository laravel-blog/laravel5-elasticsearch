<?php
/**
 * Created by PhpStorm.
 * User: stefanriedel
 * Date: 24.03.15
 * Time: 14:34
 */

namespace Laravel5Elasticsearch\Providers;

use Laravel5Elasticsearch\Article;
use Illuminate\Support\ServiceProvider;
use Elasticsearch\Client;
use Laravel5Elasticsearch\Observers\EsArticleObserver;

class ObserversServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Article::observe($this->app->make(EsArticleObserver::class));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared(EsArticleObserver::class, function () {
            return new EsArticleObserver(new Client());
        });
    }

}