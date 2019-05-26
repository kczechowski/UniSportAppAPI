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

    public function createWorkout(Request $request, Response $response, array $args)
    {
        $params = $request->getParams();

        $userID = $params['userID'];
        $startTime = $params['startTime'];
        $startTime = \DateTime::createFromFormat('U', $startTime);

        $endTime = $params['endTime'];
        $endTime = \DateTime::createFromFormat('U', $endTime);
        $type = $params['type'];
        $title = $params['title'];
        $message = $params['message'];
        $calories = $params['calories'];
        $distance = $params['distance'];

        try {
            WorkoutService::createWorkout($userID, $startTime, $endTime, $type, $title, $message, $calories, $distance);
        } catch (\Exception $e) {
            return $response->withStatus(404);
        }

        return $response->withStatus(201, 'Workout created');
    }

    public function getUserWorkouts(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $page = isset($args['page']) ? $args['page'] : null;

        if($page) {
            $workouts = WorkoutService::getWorkoutsByUserId($id, (int)$page)->toArray();
            $nextResult = WorkoutService::getWorkoutsByUserId($id, (int)($page+1))->toArray();
            if(count($nextResult) === 0)
                $data = ['workouts' => $workouts, 'hasNext' => false];
            else
                $data = ['workouts' => $workouts, 'hasNext' => true];
        }
        else {
            $workouts = WorkoutService::getWorkoutsByUserId($id);
            $data = ['workouts' => $workouts->toArray()];
        }



        return $response->withJson($data);

    }
}