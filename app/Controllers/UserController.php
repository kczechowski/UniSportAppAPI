<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 22.04.19
 * Time: 22:45
 */

namespace App\Controllers;


use App\Services\UserService;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController extends Controller
{
    public function getUser(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $user = UserService::getUserById($id);
        return $user->toJson();
    }
}