<?php
namespace Laravel5Elasticsearch\Storage\Article;


use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Laravel5Elasticsearch\Article;
use Elasticsearch\Client;

class EsArticleRepository implements ArticleRepository
{
    /**
     *
     * our ES Client
     *
     * @var Client
     */
    protected $_oEsClient;

    protected $_aQuery = array();

    /**
     *
     * our inner ArticleRepository implements ArticleRepository
     *
     * @var ArticleRepository
     */
    protected $_oInnerRepository;

    public function __construct(Client $oClient, ArticleRepository $oInterRepository)
    {
        $this->_oEsClient = $oClient;
        $this->_oInnerRepository = $oInterRepository;
    }

    /**
     *
     * for search on es
     *
     * @param string $sQuery = ""
     * @param int $iLimit
     * @return Collection
     * @internal param int $iFrom
     */
    public function search($sQuery = "", $iLimit = ArticleRepository::DEFAULT_LIMIT_PAGINATE)
    {
        $aItems = $this->_searchOnElasticsearch($sQuery, $iLimit);
        return $this->_buildCollection($aItems);
    }

    /**
     *
     * get all articles
     *
     * @return Collection
     */
    public function all()
    {
        return $this->_oInnerRepository->all();
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
        return $this->_oInnerRepository->find($iId);
    }

    /**
     *
     * simple search on elasticsearch
     *
     * @param $sQuery
     * @param int $iLimit
     * @return array
     * @internal param int $iFrom
     */
    protected function _searchOnElasticsearch($sQuery, $iLimit = ArticleRepository::DEFAULT_LIMIT_PAGINATE)
    {
        $aQuery = $this->_prepareQuery($sQuery);
        $aQuery = $this->_preparePagination($iLimit);
        $aItems = $this->_oEsClient->search($aQuery);

        return $aItems;
    }

    /**
     *
     * builds an Collection from ES result
     *
     * @param array $aItems the elasticsearch result
     * @return Collection of Eloquent models
     */
    protected function _buildCollection($aItems)
    {
        $iResult = $aItems['hits']['hits'];

        return Collection::make(array_map(function ($aArticle) {
            $oArticle = new Article();
            $oArticle->newInstance($aArticle['_source'], true);
            $oArticle->setRawAttributes($aArticle['_source'], true);
            return $oArticle;
        }, $iResult));
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
        if ($sQuery) {
            $aQuery = $this->_prepareQuery($sQuery);
            $aCount = $this->_oEsClient->count($aQuery);
            $iCount = $aCount['count'];
            $iPage = Paginator::resolveCurrentPage();
            $oData = $this->search($sQuery, $iLimit);
            /*return new Paginator($aData, $iLimit, $iPage, [
                'path' => Paginator::resolveCurrentPath()
            ]);*/
            return new LengthAwarePaginator($oData, $iCount, $iLimit, $iPage, [
                'path' => Paginator::resolveCurrentPath(),
            ]);

        }
        return $this->_oInnerRepository->paginate();
    }

    /**
     * @param $sQuery
     * @param int $iLimit
     * @return array
     */
    protected function _prepareQuery($sQuery)
    {
        $this->_aQuery = [
            'index' => \Config::get('elasticsearch.default_index'),
            'type' => 'articles',
            'body' => [
                'query' => [
                    'query_string' => [
                        'query' => $sQuery
                    ]
                ]
            ]
        ];

        return $this->_aQuery;
    }

    protected function _preparePagination($iLimit = ArticleRepository::DEFAULT_LIMIT_PAGINATE) {

        $iFrom = (Paginator::resolveCurrentPage()-1);
        $iFrom = ($iFrom < 0) ? 0 : $iFrom;
        $this->_aQuery['body']['size'] = $iLimit;
        $this->_aQuery['body']['from'] = $iFrom;
        return $this->_aQuery;
    }


}