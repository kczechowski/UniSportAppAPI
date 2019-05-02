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

    public static function getWorkoutsByUserId($id): Collection
    {
        $workouts = Workout::where('user_id', $id)->get();
        return $workouts;
    }
}