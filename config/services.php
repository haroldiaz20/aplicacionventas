<?php

/**
 * Services are globally registered in this file
 *
 * @var \Phalcon\Config $config
 */
use Phalcon\Mvc\View\Simple as View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Di\FactoryDefault;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Http\Response as Response;
use Phalcon\Http\Response\Cookies;
use Phalcon\Mvc\Dispatcher;

$di = new FactoryDefault();

/**
 * Sets the view component
 */
$di->setShared('view', function () use ($config) {
    $view = new View();
    $view->setViewsDir($config->application->viewsDir);
    return $view;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () use ($config) {
    $dbConfig = $config->database->toArray();
    $adapter = $dbConfig['adapter'];
    unset($dbConfig['adapter']);

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $adapter;

    return new $class($dbConfig);
});

/**
 * Request container
 */
$di->setShared("request", function() {
    return new Phalcon\Http\Request();
});

/**
 * Session container
 */
$di->setShared('session', function () {
    $session = new Session();
    $session->start();
    return $session;
});

/**
 * Response container
 */
$di->setShared('response', function() {
    $response = new Response();
    return $response;
});

/**
 * Cookies container
 */
$di->setShared('cookies', function () {
    $cookies = new Cookies();
    $cookies->useEncryption(false);
    return $cookies;
});

/**
 * Dispatcher container
 */
$di->setShared('dispatcher', function () {
    $dispatcher = new Dispatcher();

    return $dispatcher;
});
