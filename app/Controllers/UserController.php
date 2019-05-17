<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 22.04.19
 * Time: 22:45
 */

namespace App\Controllers;


use App\Services\UserService;
use App\Utils\OAuth2Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController extends Controller
{
    public function getUser(Request $request, Response $response, array $args)
    {
        $id = $args['id'];

        //validate

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
//        $auth = $request->getHeader('Authorization');
//        $arr = explode(' ', $auth[0]);
//        $token = $arr[1];
        $users = UserService::getAllUsers();
        $data = $users->toArray();
        return $response->withJson($data);
    }

    public function createUser(Request $request, Response $response)
    {
        $params = $request->getParams();
        //validate
        UserService::createUser($params['username'], $params['email']);
        return $response->withStatus(201, 'user created');
    }

}