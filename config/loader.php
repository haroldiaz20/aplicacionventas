<?php

/**
 * Registering an autoloader
 */
$loader = new \Phalcon\Loader();

// Es necesario registrar los namespaces para poder usarlos en la aplicación, en cualquier parte.
// Lcobucci => Es la librería que nos permite generar JWT
$loader->registerNamespaces(
        array(
            "Lcobucci\JWT" => APP_PATH . "/vendor/lcobucci/jwt/src/",
            "SekurApp\Modelos" => APP_PATH . "/models/"
        )
);

$loader->registerClasses(
    array(
        "SekurApp\Modelos\User"         => APP_PATH."/models/User.php",
        "SekurApp\Modelos\Invoice"         => APP_PATH."/models/Invoice.php"
    )
);

$loader->registerDirs(
        array(
            $config->application->modelsDir,
            $config->application->controllersDir,
            $config->application->vendorsDir
        )
)->register();
