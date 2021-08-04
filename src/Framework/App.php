<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;

class App
{

    private $modules = [];

    /**
     * App constructor function
     *
     * @param string[] $modules Listes de modules à charger
     */
    public function __construct(array $modules = [])
    {
        foreach($modules as $module) {
            $this->modules[] = new $module();
        }
    }

    public function run(ServerRequest $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === "/") {
            return $response = (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($uri, 0, -1));
        }

        return new Response(200, [], '<p>Bonjour !</p>');
    }
}
