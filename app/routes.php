<?php

$app->get('/', '\App\Controllers\HomeController:index');
//$app->post('/login', '\App\Controllers\AuthController:login');
$app->get('/token', '\App\Controllers\AuthController:getTokenUserID')->add($authMiddleware);
$app->get('/api/users/', '\App\Controllers\UserController:getAllUsers')->add($authMiddleware);
$app->get('/api/users/{id}', '\App\Controllers\UserController:getUser')->add($authMiddleware);
$app->post('/api/users/', '\App\Controllers\UserController:createUser')->add($authMiddleware);
$app->get('/api/users/{id}/workouts/', '\App\Controllers\WorkoutController:getUserWorkouts')->add($authMiddleware);
$app->get('/api/workouts/{id}', '\App\Controllers\WorkoutController:getWorkout')->add($authMiddleware);