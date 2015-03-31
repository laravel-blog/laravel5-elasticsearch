<?php
/**
 * Created by PhpStorm.
 * User: stefanriedel
 * Date: 24.03.15
 * Time: 13:57
 */

namespace Laravel5Elasticsearch\Observers;

use Laravel5Elasticsearch\Article;
use Elasticsearch\Client;

class EsArticleObserver
{

    protected $_oEsClient;

    public function __construct(Client $oEsClient)
    {
        $this->_oEsClient = $oEsClient;
    }

    /**
     *
     * erstellt eine neues Dokument in ES
     *
     * @param Article $oArticle
     */
    public function created(Article $oArticle)
    {
        $this->_oEsClient->index([
            'index' => \Config::get('elasticsearch.default_index'),
            'type' => 'articles',
            'id' => $oArticle->id,
            'body' => $oArticle->toArray()
        ]);

    }

    /**
     *
     * aktuallisiert ein Dokument in ES
     *
     * @param Article $oArticle
     */
    public function updated(Article $oArticle)
    {
        $this->_oEsClient->index([
            'index' => \Config::get('elasticsearch.default_index'),
            'type' => 'articles',
            'id' => $oArticle->id,
            'body' => $oArticle->toArray()
        ]);
    }

    /**
     *
     * löscht ein Dokument in ES
     *
     * @param Article $oArticle
     */
    public function deleted(Article $oArticle)
    {
        $this->_oEsClient->delete([
            'index' => \Config::get('elasticsearch.default_index'),
            'type' => 'articles',
            'id' => $oArticle->id
        ]);
    }

}