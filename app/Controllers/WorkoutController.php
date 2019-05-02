<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 02.05.19
 * Time: 00:55
 */

namespace App\Controllers;


use App\Services\WorkoutService;
use Slim\Http\Request;
use Slim\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WorkoutController extends Controller
{
    public function getWorkout(Request $request, Response $response, array $args)
    {
        $id = $args['id'];

        try {
            $workout = WorkoutService::getWorkoutById($id);
        } catch (ModelNotFoundException $e) {
            return $response->withStatus(404);
        }

        $data = $workout->toArray();

        return $response->withJson($data);
    }

    public function getUserWorkouts(Request $request, Response $response, array $args)
    {
        $id = $args['id'];

        $workouts = WorkoutService::getWorkoutsByUserId($id);

        $data = $workouts->toArray();

        return $response->withJson($data);

    }
}