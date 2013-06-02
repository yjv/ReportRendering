<?php
namespace Yjv\ReportRendering\Test\Event;

use Yjv\ReportRendering\Renderer\Grid\Grid;

use Yjv\ReportRendering\Filter\NullFilterCollection;

use Yjv\ReportRendering\Datasource\FakeDatasource;

use Yjv\ReportRendering\Event\DataEvent;


class DataEventTest extends \PHPUnit_Framework_TestCase{

	protected $rendererName;
	protected $renderer;
	protected $datasource;
	protected $filters;
	protected $dataEvent;
	
	public function setUp() {
		
		$this->rendererName = 'test';
		$this->renderer = $this->getMockBuilder('Yjv\ReportRendering\Renderer\RendererInterface')->getMock();
		$this->datasource = new FakeDatasource();
		$this->filters = new NullFilterCollection();
		$this->dataEvent = new DataEvent($this->rendererName, $this->renderer, $this->datasource, $this->filters);
	}
	
	public function testGettersSetters() {
		
		$this->assertEquals($this->rendererName, $this->dataEvent->getRendererName());
		$this->assertEquals($this->renderer, $this->dataEvent->getRenderer());
		$this->assertEquals($this->datasource, $this->dataEvent->getDatasource());
		$this->assertEquals($this->filters, $this->dataEvent->getFilters());
	}
}
