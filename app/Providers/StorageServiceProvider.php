<?php

namespace Laravel5Elasticsearch\Providers;
use Illuminate\Support\ServiceProvider;
use Elasticsearch\Client;
use Laravel5Elasticsearch\Storage\Article\ArticleRepository;
use Laravel5Elasticsearch\Storage\Article\EloquentArticleRepository;
use Laravel5Elasticsearch\Storage\Article\EsArticleRepository;

class StorageServiceProvider extends ServiceProvider {

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ArticleRepository::class, function()
        {
            return new EsArticleRepository(
                new Client(\Config::get('elasticsearch.config')),
                new EloquentArticleRepository()
            );
        });
    }

}
