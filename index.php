<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/RawEvents.php';

$app = AppFactory::create();

$app->addErrorMiddleware(true, true, true);

$app->get('/', function(Request $request, Response $response){
    $response->getBody()->write('Hello world');
    return $response;
}); 

$app->get('/test_event_type/{event}', function(Request $request, Response $response, $args){
    $rawEvent = new RawEvents();
    $payload = $rawEvent->getJsonResult($args['event']);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
