<?php
/**
 * Created by PhpStorm.
 * User: stefanriedel
 * Date: 27.03.15
 * Time: 12:32
 */

return array(
    'default'     => 'sqlite',
    'connections' => array(
        'sqlite' => array(
            'driver'   => 'sqlite',
            'database' => __DIR__ . '/../../database/local.sqlite',
            'prefix'   => ''
        ),
    )
);