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

$app->post('/store_msg/', function(Request $request, Response $response, $args){
    $json = $request->getBody();
    $data = json_decode($json);
    
    $rawEvent = new RawEvents();
    $eventType = $rawEvent->getJsonResult($data->event->eventType);
    $eventTypeData = json_decode($eventType);
    
    $data_response = null;
    if($eventTypeData[0][0]->evtTypePk != null){
        $rawEvent->setData($eventTypeData[0][0]->evtTypePk, $data->event->timestamp, $data->event->value, $data->event->metadata);
        $data_response = array(
            "success" => true,
            "message" => "Data was stored in the database"
        );
    }else{
        $data_response = array(
            "success" => false,
            "message" => "An error Ocurred"
        );
    }
    
    $response->getBody()->write(json_encode($data_response));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
