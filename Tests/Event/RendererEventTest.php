<?php
namespace Yjv\ReportRendering\Tests\Event;
use Yjv\ReportRendering\Event\RendererEvent;


class RendererEventTest extends ReportEventTest
{
    protected $rendererName;
    protected $renderer;

    public function setUp()
    {
		parent::setUp();
        $this->rendererName = 'name';
        $this->renderer = \Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
		$this->event = new RendererEvent(
            $this->report,
            $this->rendererName,
            $this->renderer
        );
	}
	
	public function testGettersSetters()
    {
		parent::testGettersSetters();
        $this->assertEquals($this->rendererName, $this->event->getRendererName());
        $this->assertSame($this->renderer, $this->event->getRenderer());
        $renderer = \Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
        $this->assertSame($this->event, $this->event->setRenderer($renderer));
        $this->assertSame($renderer, $this->event->getRenderer());
    }
}
