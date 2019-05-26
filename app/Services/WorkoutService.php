<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 02.05.19
 * Time: 00:55
 */

namespace App\Services;


use App\Models\Workout;
use Illuminate\Database\Eloquent\Collection;

class WorkoutService
{
    public static function getWorkoutById($id): Workout
    {
        $workout = Workout::findOrFail($id);
        return $workout;
    }

    public static function createWorkout($userID, \DateTime $startTime, \DateTime $endTime, $type, $title, $message, $calories, $distance)
    {
        $workout = new Workout();
        $workout->user_id = $userID;
        $workout->start_time = $startTime;
        $workout->end_time = $endTime;
        $workout->type = $type;
        $workout->title = $title;
        $workout->message = $message;
        $workout->calories = $calories;
        $workout->distance = $distance;
        $workout->save();
    }

    public static function getWorkoutsByUserId($id, $page = null): Collection
    {
        if(!$page)
            $workouts = Workout::where('user_id', $id)->get();
        else
            $workouts = Workout::where('user_id', $id)->offset(($page-1) * 2)->limit(2)->get();
        return $workouts;
    }


}