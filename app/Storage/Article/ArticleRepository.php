<?php

namespace Laravel5Elasticsearch\Storage\Article;


use Illuminate\Support\Collection;
use Laravel5Elasticsearch\Article;

interface ArticleRepository {

    /**
     * default pagination limit
     */
    const DEFAULT_LIMIT_PAGINATE = 15;

    /**
     * default pagination from
     */
    const DEFAULT_FROM_PAGINATE = 15;

    /**
     *
     * for search on es
     *
     * @param string $sQuery = ""
     * @param int $iLimit
     * @return Collection
     * @internal param int $iFrom
     */
    public function search($sQuery = "", $iLimit = ArticleRepository::DEFAULT_LIMIT_PAGINATE);

    /**
     *
     * get all articles
     *
     * @return Collection
     */
    public function all();

    /**
     *
     * find an article with id @var $iId
     *
     * @param $iId
     * @return Article
     */
    public function find($iId);

    /**
     *
     * get paginated articles
     *
     * @param null $sQuery
     * @param int $iLimit
     * @return mixed
     */
    public function paginate($sQuery = null, $iLimit = ArticleRepository::DEFAULT_LIMIT_PAGINATE);

}