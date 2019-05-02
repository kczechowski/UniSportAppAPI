<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 01.05.19
 * Time: 23:59
 */


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'start_time' => 'timestamp',
        'end_time' => 'timestamp'
    ];
}