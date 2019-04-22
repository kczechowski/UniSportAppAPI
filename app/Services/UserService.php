<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 22.04.19
 * Time: 23:10
 */

namespace App\Services;


use App\Models\User;

class UserService
{
    public static function getUserById($id): User
    {
        $user = User::find($id);
        return $user;
    }
}