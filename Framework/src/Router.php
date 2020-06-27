<?php
declare(strict_types=1);

namespace UserFrosting;

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Router
{
    public function loadRoutes(App $app): void
    {
        $app->get('/', function (Request $request, Response $response, $args) {
            $response->getBody()->write("Hello world!");
            return $response;
        });
    }
}
