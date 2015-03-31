<?php namespace Laravel5Elasticsearch\Console\Commands;

use Elasticsearch\Client;
use Illuminate\Console\Command;
use Laravel5Elasticsearch\Article;
use League\Flysystem\Exception;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class IndexToEs extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'l5:index';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Indexiert Dokumente zu ES';

    /**
     * @var Client
     */
    protected $_oEsClient;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

        $this->_prepareIndex();

        $oModels = Article::all();
        $oEs = new Client();

        $this->info('Importiere ' . $oModels->count() . ' Artikel nach: '  . \Config::get('elasticsearch.default_index'));

        foreach ($oModels as $oModel)
        {
            $oEs->index([
                'index' => 'l5es',
                'type' => 'articles',
                'id' => $oModel->id,
                'body' => $oModel->toArray()
            ]);
        }
	}

    protected function _prepareIndex()
    {
        $this->output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $this->_oEsClient = new Client(\Config::get('elasticsearch.config'));
        $this->info('Lösche index: ' . \Config::get('elasticsearch.default_index'));
        try {
            $this->_oEsClient->indices()->delete(['index' => \Config::get('elasticsearch.default_index')]);
        } catch (\Exception $e) {

        }
    }

}
