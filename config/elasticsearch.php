<?php

return array(

    /**
     * default config params for Elasticsearch\Client constructor
     */
    'config' => [
        'hosts'     => ['localhost:9200'],
        'logging'   => true,
        'logPath'   => storage_path() . '/logs/elasticsearch.log',
        'logLevel'  => Monolog\Logger::WARNING,
    ],


    /**
     * your default es index
     */
    'default_index' => 'l5es',

);