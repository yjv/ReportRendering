<?php
namespace Yjv\Bundle\ReportRenderingBundle\Test\Event;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Grid;

use Yjv\Bundle\ReportRenderingBundle\Filter\NullFilterCollection;

use Yjv\Bundle\ReportRenderingBundle\Datasource\FakeDatasource;

use Yjv\Bundle\ReportRenderingBundle\Event\DataEvent;


class DataEventTest extends \PHPUnit_Framework_TestCase{

	protected $rendererName;
	protected $grid;
	protected $datasource;
	protected $filters;
	protected $dataEvent;
	
	public function setUp() {
		
		$this->rendererName = 'test';
		$this->grid = new Grid();
		$this->datasource = new FakeDatasource();
		$this->filters = new NullFilterCollection();
		$this->dataEvent = new DataEvent($this->rendererName, $this->grid, $this->datasource, $this->filters);
	}
	
	public function testGettersSetters() {
		
		$this->assertEquals($this->rendererName, $this->dataEvent->getRendererName());
		$this->assertEquals($this->grid, $this->dataEvent->getRenderer());
		$this->assertEquals($this->datasource, $this->dataEvent->getDatasource());
		$this->assertEquals($this->filters, $this->dataEvent->getFilters());
	}
}
