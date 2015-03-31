<?php namespace Laravel5Elasticsearch\Http\Controllers;
use Laravel5Elasticsearch\Http\Requests\Request;
use Laravel5Elasticsearch\Http\Requests\SearchRequest;
use Laravel5Elasticsearch\Storage\Article\ArticleRepository;
use Laravel5Elasticsearch\Storage\Article\EsArticleRepository;

class EsController extends Controller {

    /**
     * @var EsArticleRepository
     */
	protected $_oArticleRepository;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(ArticleRepository $oArticleRepository)
	{
		$this->_oArticleRepository = $oArticleRepository;
        $this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        if($sQuery = \Input::get('q')) {
            $sQuery = strip_tags($sQuery);
            $oArticles = $this->_oArticleRepository->paginate($sQuery);
            $oArticles->appends(\Input::except('page'));
        } else {
            $oArticles = $this->_oArticleRepository->paginate();
        }
        return view('es', ['articles' => $oArticles, 'query' => $sQuery]);
	}

}
