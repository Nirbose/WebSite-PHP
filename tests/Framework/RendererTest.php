<?php
namespace Tests\Framework;

use Framework\Renderer;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase {
    
    private $renderer;

    public function setUp(): void 
    {
        $this->renderer = new Renderer();
    }

    public function testRendererTheRightPath()
    {
        $this->renderer->addPath('blog', __DIR__ . '/views');
        $content = $this->renderer->render('@blog/demo');
        $this->assertEquals('Hello World !', $content);
    }

    public function testRendererTheDefaultPath()
    {
        $this->renderer->addPath(__DIR__ . '/views');
        $content = $this->renderer->render('demo');
        $this->assertEquals('Hello World !', $content);
    }

}
