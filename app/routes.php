<?php

$app->get('/', '\App\Controllers\HomeController:index');
$app->get('/api/users/{id}', '\App\Controllers\UserController:getUser');