<?php
namespace Yjv\ReportRendering\Tests\Event;

use Yjv\ReportRendering\Filter\ArrayFilterCollection;

use Yjv\ReportRendering\Filter\NullFilterCollection;

use Yjv\ReportRendering\Datasource\FakeDatasource;

use Yjv\ReportRendering\Event\DataEvent;
use Yjv\ReportRendering\ReportData\ReportData;


class DataEventTest extends RendererEventTest
{
	protected $rendererName;
	protected $renderer;
	protected $datasource;
	protected $filterValues;
    protected $data;
	protected $event;
	
	public function setUp()
    {
		parent::setUp();
		$this->datasource = \Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceInterface');
		$this->filterValues = array('key' => 'value');
        $this->data = new ReportData(array(), 32);
		$this->event = new DataEvent(
            $this->report,
            $this->rendererName,
            $this->renderer,
            $this->datasource,
            $this->filterValues,
            $this->data
        );
	}
	
	public function testGettersSetters()
    {
        parent::testGettersSetters();
		$this->assertSame($this->datasource, $this->event->getDatasource());
		$this->assertSame($this->filterValues, $this->event->getFilterValues());
		$filters = array('key2' => 'value2');
		$this->assertSame($this->event, $this->event->setFilterValues($filters));
		$this->assertSame($filters, $this->event->getFilterValues());
        $this->assertSame($this->data, $this->event->getData());
        $data = new ReportData(array(), 32);
        $this->assertSame($this->event, $this->event->setData($data));
        $this->assertSame($data, $this->event->getData());
	}
}
