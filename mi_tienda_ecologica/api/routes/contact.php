<?php

use Slim\Routing\RouteCollectorProxy;

require_once __DIR__ . '/../controllers/contactController.php';

$app->group('/api/contact', function (RouteCollectorProxy $group) {
    $group->post('/send', 'sendContactMessage');
});
