<?php
require_once '../vendor/autoload.php';

use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;

use function Http\Response\send;

$app = new App();

$response = $app->run(ServerRequest::fromGlobals());
send($response);
