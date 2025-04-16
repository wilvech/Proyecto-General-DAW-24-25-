<?php
use Slim\Routing\RouteCollectorProxy;

require_once __DIR__ . '/../controllers/productController.php';
require_once __DIR__ . '/../middleware/jwtMiddleware.php';

$app->group('/api/products', function (RouteCollectorProxy $group) {
    $group->post('/create', 'createProduct');
    $group->get('/getAll', 'getProducts');
    $group->get('/getProduct/{id}', 'getProduct');
    $group->delete('/delete/{id}', 'deleteProduct');
    $group->post('/update/{id}', 'updateProduct');
})->add('verifyJWT');
