<?php

namespace Tests\Framework;

use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase {

    public function testRedirectTralingSlash() {
        $app = new App();
        $request = new ServerRequest('GET', '/testslash/');
        $response = $app->run($request);
        $this->assertContains('/testslash', $response->getHeader('Location'));
        $this->assertEquals(301, $response->getStatusCode());
    }

}