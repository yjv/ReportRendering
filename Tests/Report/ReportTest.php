<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Report;

use Yjv\Bundle\ReportRenderingBundle\Event\FilterDataEvent;

use Yjv\Bundle\ReportRenderingBundle\Event\DataEvent;

use Yjv\Bundle\ReportRenderingBundle\Report\ReportEvents;

use Yjv\Bundle\ReportRenderingBundle\ReportData\ReportData;

use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererNotFoundException;

use Yjv\Bundle\ReportRenderingBundle\Datasource\FakeDatasource;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Grid;

use Symfony\Component\EventDispatcher\EventDispatcher;

use Yjv\Bundle\ReportRenderingBundle\Report\Report;

class ReportTest extends \PHPUnit_Framework_TestCase {

	protected $renderer;
	protected $datasource;
	protected $eventDispatcher;
	protected $report;
	
	public function setUp(){
	
		$this->datasource = $this->getMock('Yjv\\Bundle\\ReportRenderingBundle\\Datasource\\DatasourceInterface');
		$this->renderer = $this->getMock('Yjv\\Bundle\\ReportRenderingBundle\\Renderer\\RendererInterface');
		$this->eventDispatcher = $this->getMock('Symfony\\Component\\EventDispatcher\\EventDispatcher');
		$this->report = new Report($this->datasource, $this->renderer, $this->eventDispatcher);
	}
	
	public function testGettersSetters() {
		
		$datasource = $this->getMock('Yjv\\Bundle\\ReportRenderingBundle\\Datasource\\DatasourceInterface');
		$eventDispatcher = $this->getMock('Symfony\\Component\\EventDispatcher\\EventDispatcher');
		$idGenerator = $this->getMock('Yjv\\Bundle\\ReportRenderingBundle\\IdGenerator\\IdGeneratorInterface');
		$id = 'reportId';
		$this->assertSame($this->datasource, $this->report->getDatasource());
		$this->report->setDatasource($datasource);
		$this->assertSame($datasource,	$this->report->getDatasource());
		$this->assertSame($this->eventDispatcher, $this->report->getEventDispatcher());
		$this->report->setEventDispatcher($eventDispatcher);
		$this->assertSame($eventDispatcher, $this->report->getEventDispatcher());
		$this->report->setIdGenerator($idGenerator);
		
		$idGenerator
			->expects($this->once())
			->method('getId')
			->with($this->report)
			->will($this->returnValue($id))
		;
		
		$this->assertEquals($id, $this->report->getId());
		$this->assertEquals($id, $this->report->getId());
	}
	
	public function testRendererGettersSetters() {
		
		$renderer = $this->getMock('Yjv\\Bundle\\ReportRenderingBundle\\Renderer\\RendererInterface');
		$filterAwareRenderer = $this->getMock('Yjv\\Bundle\\ReportRenderingBundle\\Renderer\\FilterAwareRendererInterface');
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
	
	public function testFiltersGettersSetters() {
		
		$filters = $this->getMock('Yjv\\Bundle\\ReportRenderingBundle\\Filter\\FilterCollectionInterface');
		$multiReportFilters = $this->getMock('Yjv\\Bundle\\ReportRenderingBundle\\Filter\\MultiReportFilterCollectionInterface');
		
		$filters
			->expects($this->never())
			->method('setReportId')
		;
		
		$multiReportFilters
			->expects($this->once())
			->method('setReportId')
		;
		
		$this->assertInstanceOf('Yjv\\Bundle\\ReportRenderingBundle\\Filter\\FilterCollectionInterface', $this->report->getFilters());
		$this->report->setFilters($filters);
		$this->assertSame($filters, $this->report->getFilters());
		$this->report->setFilters($multiReportFilters);
	}
	
	public function testGetData() {
		
		$data = new ReportData(array('sdfdsf' => 'sddsf'), 10);
		$renderer = $this->getMock('Yjv\\Bundle\\ReportRenderingBundle\\Renderer\\RendererInterface');
		$rendererName = 'renderer';
		$filters = $this->getMock('Yjv\\Bundle\\ReportRenderingBundle\\Filter\\FilterCollectionInterface');
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
		$this->assertInstanceOf('Yjv\\Bundle\\ReportRenderingBundle\\ReportData\\ImmutableReportData', $result);
		$this->assertEquals($data->getData(), $result->getData());
		$this->assertEquals($data->getUnfilteredCount(), $result->getUnfilteredCount());
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
}
