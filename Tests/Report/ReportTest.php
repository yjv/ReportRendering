<?php
namespace Yjv\ReportRendering\Tests\Report;

use Yjv\ReportRendering\Event\FilterDataEvent;

use Mockery;

use Yjv\ReportRendering\Event\DataEvent;

use Yjv\ReportRendering\Report\ReportEvents;

use Yjv\ReportRendering\ReportData\ReportData;

use Yjv\ReportRendering\Renderer\RendererNotFoundException;

use Yjv\ReportRendering\Datasource\FakeDatasource;

use Yjv\ReportRendering\Renderer\Grid\Grid;

use Symfony\Component\EventDispatcher\EventDispatcher;

use Yjv\ReportRendering\Report\Report;

class ReportTest extends \PHPUnit_Framework_TestCase {

	protected $renderer;
	protected $datasource;
	protected $eventDispatcher;
	protected $report;
    protected $name;
	
	public function setUp(){
	
		$this->datasource = $this->getMock('Yjv\\ReportRendering\\Datasource\\DatasourceInterface');
		$this->renderer = $this->getMock('Yjv\\ReportRendering\\Renderer\\RendererInterface');
		$this->eventDispatcher = $this->getMock('Symfony\\Component\\EventDispatcher\\EventDispatcher');
		$this->name = 'report';
        $this->report = new Report($this->name, $this->datasource, $this->renderer, $this->eventDispatcher);
	}
	
	public function testGettersSetters() {
		
		$datasource = $this->getMock('Yjv\\ReportRendering\\Datasource\\DatasourceInterface');
		$eventDispatcher = $this->getMock('Symfony\\Component\\EventDispatcher\\EventDispatcher');
		$this->assertSame($this->datasource, $this->report->getDatasource());
		$this->report->setDatasource($datasource);
		$this->assertSame($datasource,	$this->report->getDatasource());
		$this->assertSame($this->eventDispatcher, $this->report->getEventDispatcher());
		$this->report->setEventDispatcher($eventDispatcher);
		$this->assertSame($eventDispatcher, $this->report->getEventDispatcher());
		$this->assertEquals($this->name, $this->report->getName());
	}
	
	public function testRendererGettersSetters() {
		
		$renderer = $this->getMock('Yjv\\ReportRendering\\Renderer\\RendererInterface');
		$filterAwareRenderer = $this->getMock('Yjv\\ReportRendering\\Renderer\\FilterAwareRendererInterface');
		$name = 'renderer';
		$this->datasource
			->expects($this->any())
			->method('getData')
			->will($this->returnValue(new ReportData(array(), 10)))
		;
		
		$filterAwareRenderer
			->expects($this->once())
			->method('setFilters')
			->with($this->report->getFilters())
		;
		
		$this->assertSame($this->renderer, $this->report->getRenderer());
		$this->report->addRenderer($name, $renderer);
		$this->assertSame($renderer, $this->report->getRenderer($name));

		$this->assertEquals(array('default' => $this->renderer, $name => $renderer), $this->report->getRenderers());
		
		$this->report->addRenderer($name, $filterAwareRenderer);
		$this->report->getRenderer($name);
		
		try {
			
			$this->report->getRenderer('notFound');
			$this->fail('did not thorw exception on non existent renderer');
		} catch (RendererNotFoundException $e) {
		}
		
		$this->report->removeRenderer($name);
		
		try {
			
			$this->report->getRenderer($name);
			$this->fail('failed to remove renderer');
		} catch (RendererNotFoundException $e) {
		}
	}
	
	public function testGetRendererWithLazyLoadedRenderer()
	{
	    $renderer = Mockery::mock('Yjv\ReportRendering\Renderer\RendererInterface');
	    $lazyRenderer = Mockery::mock('Yjv\ReportRendering\Renderer\LazyLoadedRendererInterface')
	        ->shouldReceive('getRenderer')
	        ->once()
	        ->andReturn($renderer)
	        ->getMock()
	    ;
		$this->datasource
			->expects($this->any())
			->method('getData')
			->will($this->returnValue(new ReportData(array(), 10)))
		;
		$renderer
    		->shouldReceive('setData')
    		->twice()
    		->getMock()
    		->shouldReceive('setReport')
            ->with($this->report)
    		->twice()
    		->getMock()
    		->shouldReceive('getForceReload')
    		->twice()
    		->andReturn(true)
		;
		$this->report->addRenderer('lazy', $lazyRenderer);
		$this->assertSame($renderer, $this->report->getRenderer('lazy'));
		$this->assertSame($renderer, $this->report->getRenderer('lazy'));
	}
	
	public function test__toString()
	{
	    $this->renderer->expects($this->once())->method('render')->will($this->returnValue('hello'));
		$this->datasource
			->expects($this->any())
			->method('getData')
			->will($this->returnValue(new ReportData(array(), 10)))
		;
	    $this->assertEquals('hello', (string)$this->report);
	}
	
	public function testFiltersGettersSetters() {
		
		$filters = Mockery::mock('Yjv\\ReportRendering\\Filter\\FilterCollectionInterface');
		$multiReportFilters = Mockery::mock('Yjv\\ReportRendering\\Filter\\MultiReportFilterCollectionInterface');
		
		$multiReportFilters
			->shouldReceive('setReportName')
            ->once()
            ->with($this->name)
		;
		
		$this->assertInstanceOf('Yjv\\ReportRendering\\Filter\\FilterCollectionInterface', $this->report->getFilters());
		$this->report->setFilters($filters);
		$this->assertSame($filters, $this->report->getFilters());
		$this->report->setFilters($multiReportFilters);
	}
	
	public function testGetData() {
		
		$data = new ReportData(array('sdfdsf' => 'sddsf'), 10);
		$renderer = $this->getMock('Yjv\\ReportRendering\\Renderer\\RendererInterface');
		$rendererName = 'renderer';
		$filters = $this->getMock('Yjv\\ReportRendering\\Filter\\FilterCollectionInterface');
		$datasource = $this->datasource;
		$this->report->setFilters($filters);
		
		$tester = $this;
		
		$this->eventDispatcher
			->addListener(ReportEvents::PRE_LOAD_DATA, function (DataEvent $dataEvent) use ($tester, $renderer, $rendererName, $filters, $datasource){
			
				$tester->assertEquals($name, $dataEvent->getRendererName());
				$tester->assertSame($renderer, $dataEvent->getRenderer());
				$tester->assertSame($filters, $dataEvent->getFilters());
				$tester->assertSame($datasource, $dataEvent->getDatasource());
			})
		;
		$this->eventDispatcher
			->addListener(ReportEvents::POST_LOAD_DATA, function (FilterDataEvent $dataEvent) use ($tester, $data, $renderer, $rendererName, $filters, $datasource){
				
				$tester->assertEquals($name, $dataEvent->getRendererName());
				$tester->assertSame($renderer, $dataEvent->getRenderer());
				$tester->assertSame($filters, $dataEvent->getFilters());
				$tester->assertSame($datasource, $dataEvent->getDatasource());
				$tester->assertEquals($data, $dataEvent->getData());
			})
		;
		$this->eventDispatcher
			->expects($this->exactly(2))
			->method('dispatch')
		;
		
		$this->datasource
			->expects($this->once())
			->method('getData')
			->will($this->returnValue($data))
		;
		
		$result = $this->report->getData($rendererName, $renderer);
		$this->assertInstanceOf('Yjv\\ReportRendering\\ReportData\\ImmutableReportData', $result);
		$this->assertEquals($data->getData(), $result->getData());
		$this->assertEquals($data->getUnpaginatedCount(), $result->getUnpaginatedCount());
		$this->assertEquals($data->getCount(), $result->getCount());
	}
	
	public function testEventListenerAdditions() {
		
		$eventSubscriber = $this->getMock('Symfony\\Component\\EventDispatcher\\EventSubscriberInterface');
		$eventListener = function(){};
		$event = ReportEvents::POST_LOAD_DATA;
		
		$this->eventDispatcher
			->expects($this->once())
			->method('addListener')
			->with($event, $eventListener, 10)
		;
		
		$this->eventDispatcher
			->expects($this->once())
			->method('addSubscriber')
			->with($eventSubscriber)
		;
		
		$this->report->addEventListener($event, $eventListener, 10);
		$this->report->addEventSubscriber($eventSubscriber);
	}

    public function testGetName()
    {
        $this->assertEquals($this->name, $this->report->getName());
    }
}
