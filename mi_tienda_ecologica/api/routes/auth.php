<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Slim\Routing\RouteCollectorProxy;

require_once __DIR__ . '/../controllers/userController.php';

$app->group('/api/users', function (RouteCollectorProxy $group) {
    $group->post('/register', 'registerUser');
    $group->post('/login', 'loginUser');
    $group->get('/logout', 'logoutUser');
    $group->get('/loggedin', 'getLoginStatus');
    $group->get('/getuser', 'getUserProfile');
    $group->patch('/updateuser', 'updateUser');
    $group->patch('/changepassword', 'changePassword');
    $group->post('/forgotpassword', 'forgotPassword');
    $group->put('/resetpassword/{token}', 'resetPassword');
});
