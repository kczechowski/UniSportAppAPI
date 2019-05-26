<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 22.04.19
 * Time: 22:45
 */

namespace App\Controllers;


use App\Services\AuthService;
use App\Services\UserService;
use App\Utils\OAuth2Middleware;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;
use Illuminate\Database\Capsule\Manager as Capsule;

class UserController extends Controller
{
    public function getUser(Request $request, Response $response, array $args)
    {
        $id = $args['id'];

        //validate
        $token = $request->getAttribute('oauth_access_token');

        try {
            $user = UserService::getUserById($id);
            // give additional info if owner
            if (AuthService::isAccessTokenOwnedByUser($id, $token))
                $authUser = AuthService::getOAuthUserInfo($token);

        } catch (ModelNotFoundException $e) {
            return $response->withStatus(404);
        } catch (\Exception $e) {
            return $response->withStatus(400);
        }

        $data = $user->toArray();

        if (isset($authUser))
            $data['oauth_info'] = $authUser;

        return $response->withJson($data);
    }

    public function getAllUsers(Request $request, Response $response)
    {
        $users = UserService::getAllUsers();
        $data = $users->toArray();
        return $response->withJson($data);
    }

    public function createUser(Request $request, Response $response)
    {
        $params = $request->getParams();

        $token = $request->getAttribute('oauth_access_token');

        try {
            UserService::createUserWithOAuth($token, $params['username'], $request->getAttribute('oauth_client_id'));
        }catch (\Exception $exception){
            return $response->withStatus(400);
        }
        return $response->withStatus(201, 'user created');
    }

    public function deleteUser(Request $request, Response $response, array $args)
    {

        $id = $args['id'];

        try {
            UserService::deleteUser($id);
        }catch (\Exception $exception){
            return $response->withStatus(400, $exception->getMessage());
        }
        return $response->withStatus(200);
    }

}