<?php
namespace Laravel5Elasticsearch\Storage\Article;

use Illuminate\Support\Collection;
use Laravel5Elasticsearch\Article;

class EloquentArticleRepository implements ArticleRepository
{
    /**
     *
     * for search on db
     *
     * @param string $sQuery = ""
     * @param int $iLimit
     * @return Collection
     * @internal param int $iFrom
     */
    public function search($sQuery = "", $iLimit = ArticleRepository::DEFAULT_LIMIT_PAGINATE)
    {
        return Article::where('short_desc', 'like', "%{$sQuery}%")
            ->orWhere('long_desc', 'like', "%{$sQuery}%")
            ->orWhere('title', 'like', "%{$sQuery}%")
            ->get();
    }

    /**
     *
     * get all articles
     *
     * @return Collection
     */
    public function all()
    {
        return Article::all();
    }

    /**
     *
     * find an article with id @var $iId
     *
     * @param $iId
     * @return Article
     */
    public function find($iId)
    {
        return Article::find($iId);
    }


    /**
     *
     * get paginated articles
     *
     * @param null $sQuery
     * @param int|null $iLimit
     * @return mixed
     */
    public function paginate($sQuery = null, $iLimit = ArticleRepository::DEFAULT_LIMIT_PAGINATE)
    {
        return Article::paginate($iLimit);
    }
}