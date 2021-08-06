<?php

namespace Tests\Framework;

use App\Blog\BlogModule;
use Exception;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Tests\Framework\Modules\ErrorModule;
use Tests\Framework\Modules\StringModule;

class AppTest extends TestCase {

    public function testRedirectTralingSlash() {
        $app = new App();
        $request = new ServerRequest('GET', '/testslash/');
        $response = $app->run($request);
        $this->assertContains('/testslash', $response->getHeader('Location'));
        $this->assertEquals(301, $response->getStatusCode());
    }

    public function testBlog() {
        $app = new App([
            BlogModule::class
        ]);
        $request = new ServerRequest('GET', '/blog');
        $response = $app->run($request);
        $this->assertContains('<h1>Bienvenue sur le blog</h1>', [(string)$response->getBody()]);
        $this->assertEquals(200, $response->getStatusCode());

        $requestSingle = new ServerRequest('GET', '/blog/article-de-test');
        $responseSingle = $app->run($requestSingle);
        $this->assertContains('<h1>Bienvenue sur l\'article article-de-test</h1>', [(string)$responseSingle->getBody()]);
    }

    public function testThrowsExceptionIfNotResponseSent() {
        $app = new App([
            ErrorModule::class
        ]);

        $request = new ServerRequest('GET', '/demo');
        $this->expectException(Exception::class);
        $app->run($request);
    }

    public function testConvertsStringToResponse() {
        $app = new App([
            StringModule::class
        ]);

        $request = new ServerRequest('GET', '/demo');
        $response = $app->run($request);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals('DEMO', (string)$response->getBody());
    }

}
