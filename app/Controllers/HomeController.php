<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class HomeController extends Controller
{
    public function index(Request $request, Response $response)
    {
        return 'Hello world';
    }
}
