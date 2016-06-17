<?php

defined('APP_PATH') || define('APP_PATH', realpath('.'));

return new \Phalcon\Config(array(

    'database' => array(
        'adapter'    => 'Postgresql',
        'host'       => 'localhost',
        'username'   => 'postgres',
        'password'   => '123456',
        'dbname'     => 'erplima'
    ),

    'application' => array(
        'controllersDir' => APP_PATH.'/controllers',
        'modelsDir'      => APP_PATH . '/models/',
        'vendorsDir'      => APP_PATH . '/vendor/',
        'viewsDir'       => APP_PATH . '/views/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'baseUri'        => '/aplicacionventas/',
    )
));
