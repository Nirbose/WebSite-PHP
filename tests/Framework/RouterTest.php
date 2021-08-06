<?php
namespace Tests\Framework;

use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase {

    private Router $router;

    public function setUp():void
    {
        $this->router = new Router();
    }

    public function testGetMethods()
    {
        $request = new ServerRequest('GET', '/blog');
        $this->router->get('/blog', function () { return 'Hello World'; }, 'blog');
        $route = $this->router->match($request);
        $this->assertEquals('blog', $route->getName());
        $this->assertEquals('Hello World', call_user_func_array($route->getCallback(), [$request]));
    }

    public function testGetMethodsIfURLDoesNotExistance()
    {
        $request = new ServerRequest('GET', '/blog');
        $this->router->get('/notexists', function () { return 'Hello World'; }, 'blog');
        $route = $this->router->match($request);
        $this->assertEquals(null, $route);
    }

    public function testGetMethodsWithParameters()
    {
        $request = new ServerRequest('GET', '/blog/mon-slug-1');
        $this->router->get('/blog', function () { return 'hello'; }, 'post');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () { return 'hello'; }, 'post.show');
        $route = $this->router->match($request);
        $this->assertEquals('post.show', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
        $this->assertEquals(['slug' => 'mon-slug', 'id' => '1'], $route->getParams());

        // Test Route not existe
        $route = $this->router->match(new ServerRequest('GET', '/blog/mon_post-1'));
        $this->assertEquals(null, $route);
    }

    public function testGeneratUri()
    {
        $this->router->get('/blog', function () { return 'hello'; }, 'post');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () { return 'hello'; }, 'post.show');
        $uri = $this->router->generateUri('post.show', ['slug' => 'mon-articles', 'id' => '5']);
        $this->assertEquals('/blog/mon-articles-5', $uri);
    }
}
