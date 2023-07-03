<?php
namespace Aguirre\Antonio{

use LDAP\Result;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../poo/Usuario.php';
require_once __DIR__ . '/../poo/Perfiles.php';


$app = AppFactory::create();



$app->post('/usuario', function(Request $request, Response $response, $args) : Response{
    return Usuario::Alta($request, $response, $args);
});

$app->get('[/]', function(Request $request, Response $response, $args) : Response{
    return Usuario::Listado($request, $response, $args);
});

$app->post('[/]', function(Request $request, Response $response, $args) : Response{
    return Perfiles::Alta($request, $response, $args);
});

$app->get('/perfil', function(Request $request, Response $response, $args) : Response{
    return Perfiles::Listado($request, $response, $args);
});

$app->post('/login', function(Request $request, Response $response, $args) : Response{
    return Usuario::Login($request, $response, $args);
});

$app->get('/login', function(Request $request, Response $response, $args) : Response{
    return Usuario::LoginToken($request, $response, $args);
});

$app->delete('/perfiles', function(Request $request, Response $response, $args) : Response{
    return Perfiles::Borrar($request, $response, $args);
});

$app->put('/perfiles', function(Request $request, Response $response, $args) : Response{
    return Perfiles::Modificar($request, $response, $args);
});

$app->delete('/usuarios', function(Request $request, Response $response, $args) : Response{
    return Usuario::Borrar($request, $response, $args);
});

$app->run();
}