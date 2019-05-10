<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 22.04.19
 * Time: 23:10
 */

namespace App\Services;


use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService
{

    public static function isUserExists($id): bool
    {
        $user = User::find($id);
        return ($user === null) ? false : true;
    }

    public static function getUserById($id): User
    {
        $user = User::findOrFail($id);
        return $user;
    }

    public static function getAllUsers(): Collection
    {
        $users = User::all();
        return $users;
    }

    public static function createUser($username, $email){
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->save();
    }
}