<?php

/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */
/**
 * Add your routes here
 */
$app->get('/', function () use ($app) {
    echo $app['view']->render('index');
});

/**
 * Rutas para la autenticación de los usuarios y la generación de lo JWT
 */
$userCtlr = new UserController();
$app->post('/users/verificar', array($userCtlr, "verificarAction"));

//// List all users
//$app->get('/users');
//
//// Save one user
//$app->post('/users');
//
//// Read one user
//$app->get('/users/{id}');
//
////Update one user
//$app->put('/users/{id}');

/**
 * Esta ruta nos permitirá obtener información sobre los pedidos de venta
 */
$pedidoCtrl = new InvoiceController();
$app->get('/pedido/invoice/new', array($pedidoCtrl, 'newInvoice'));
$app->get('/pedido/invoice/formaPago/{codigo:[a-zA-Z0-9\_\-]+}/nroDias', array($pedidoCtrl, "listarNroDias"));
$app->post('/pedido/invoice/save', array($pedidoCtrl, "save"));

/**
 * Rutas para encontrar información sobre productos
 */
$productoCtrl = new ProductController();
$app->get('/products/{value:[a-zA-Z0-9\_\-]+}', array($productoCtrl, "consultar"));

/**
 * Rutas para encontrar la información sobre los clientes
 */
$client = new ClienteController();
$app->get('/client/{value:[a-zA-Z0-9\_\-]+}', array($client, "consultar"));
$app->post('/client/save', array($client, "save"));

/**
 * Rutas para encontrar información sobre ubicaciones
 */
$locCtrl = new LocationController();
$app->get('/location/paises',array($locCtrl,"paisesAction"));
$app->get('/location/paises/{codigo:[0-9]+}/regiones',array($locCtrl,"regionesAction"));

/**
 * Not found handler
 */
$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo $app['view']->render('404');
});


