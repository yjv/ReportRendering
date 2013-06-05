<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\ReportData\ImmutableReportData;

use Mockery;

class LazyLoadedRendererTest extends \PHPUnit_Framework_TestCase
{
    protected $renderer;
    protected $lazyRenderer;
    protected $rendererFactory;
    protected $type = 'type';
    protected $options = array('key' => 'value');
    
    public function setUp()
    {
        $this->rendererFactory = Mockery::mock('Yjv\ReportRendering\Renderer\RendererFactoryInterface');
        $this->renderer = Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
        $this->lazyRenderer = new LazyLoadedRenderer($this->rendererFactory, $this->type, $this->options);
    }
    
    public function testGetRenderer()
    {
        $this->setUpLoadExpectations();
        $this->assertSame($this->renderer, $this->lazyRenderer->getRenderer());
        $this->assertSame($this->renderer, $this->lazyRenderer->getRenderer());
    }
    
    public function testGetForceReload()
    {
        $this->setUpLoadExpectations();
        $this->renderer->shouldReceive('getForceReload')->twice()->andReturn(true);
        $this->assertTrue($this->lazyRenderer->getForceReload());
        $this->assertTrue($this->lazyRenderer->getForceReload());
    }
    
    public function testRender()
    {
        $this->setUpLoadExpectations();
        $options = array('key' => 'value');
        $this->renderer->shouldReceive('render')->twice()->with($options)->andReturn('rendered');
        $this->assertEquals('rendered', $this->lazyRenderer->render($options));
        $this->assertEquals('rendered', $this->lazyRenderer->render($options));
    }
    
    public function testSetData()
    {
        $this->setUpLoadExpectations();
        $data = new ImmutableReportData(array(), 0);
        $this->renderer->shouldReceive('setData')->twice()->with($data);
        $this->assertSame($this->lazyRenderer, $this->lazyRenderer->setData($data));
        $this->assertSame($this->lazyRenderer, $this->lazyRenderer->setData($data));
    }
    
    public function testSetReportId()
    {
        $this->setUpLoadExpectations();
        $reportId = 7;
        $this->renderer->shouldReceive('setReportId')->twice()->with($reportId);
        $this->assertSame($this->lazyRenderer, $this->lazyRenderer->setReportId($reportId));
        $this->assertSame($this->lazyRenderer, $this->lazyRenderer->setReportId($reportId));
    }
    
    protected function setUpLoadExpectations()
    {
        $this->rendererFactory
            ->shouldReceive('create')
            ->with($this->type, $this->options)
            ->once()
            ->andReturn($this->renderer)
        ;
    }
}
