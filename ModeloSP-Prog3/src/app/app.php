<?php
namespace Aguirre\Antonio{

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../poo/Usuario.php';
require_once __DIR__ . '/../poo/Auto.php';


$app = AppFactory::create();

$app->post('/usuario', function(Request $request, Response $response, $args) : Response{
    return Usuario::Alta($request, $response, $args);
});

$app->get('[/]', function(Request $request, Response $response, $args) : Response{
    return Usuario::Listado($request, $response, $args);
});

$app->post('[/]', function(Request $request, Response $response, $args) : Response{
    return Auto::Alta($request, $response, $args);
});

$app->run();

}