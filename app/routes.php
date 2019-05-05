<?php

$app->get('/', '\App\Controllers\HomeController:index');
$app->get('/api/users/', '\App\Controllers\UserController:getAllUsers');
$app->get('/api/users/{id}', '\App\Controllers\UserController:getUser');
$app->get('/api/users/{id}/workouts/', '\App\Controllers\WorkoutController:getUserWorkouts');
$app->get('/api/workouts/{id}', '\App\Controllers\WorkoutController:getWorkout');