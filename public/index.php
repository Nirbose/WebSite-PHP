<?php
require_once '../vendor/autoload.php';

use App\Blog\BlogModule;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;

use function Http\Response\send;

$app = new App([
    BlogModule::class
]);

$response = $app->run(ServerRequest::fromGlobals());
send($response);
