<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 22.04.19
 * Time: 22:45
 */

namespace App\Controllers;


use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController extends Controller
{
    public function getUser(Request $request, Response $response, array $args)
    {
        $id = $args['id'];

        try {
            $user = UserService::getUserById($id);
        } catch (ModelNotFoundException $e) {
            return $response->withStatus(404);
        }

        $data = $user->toArray();

        return $response->withJson($data);
    }

    public function getAllUsers(Request $request, Response $response)
    {
        $users = UserService::getAllUsers();
        $data = $users->toArray();
        return $response->withJson($data);
    }

}