<?php
namespace Yjv\ReportRendering\Tests\Renderer\Html;

use Yjv\ReportRendering\Filter\NullFilterCollection;

use Mockery;

use Yjv\ReportRendering\ReportData\ReportData;

use Yjv\ReportRendering\Renderer\Html\HtmlRenderer;


class HtmlRendererTest extends \PHPUnit_Framework_TestCase{

	protected $grid;
	protected $template;
	protected $widgetRenderer;
	protected $renderer;
	
	public function setUp(){
		
		$this->grid = $this->getMock('Yjv\\ReportRendering\\Renderer\\Grid\\GridInterface');
		$this->template = 'template';
		$this->widgetRenderer = $this->getMockBuilder('Yjv\\ReportRendering\\Widget\\WidgetRenderer')
			->disableOriginalConstructor()
			->getMock();
		$this->renderer = new HtmlRenderer($this->widgetRenderer, $this->grid, $this->template);
	}
	
	public function testGettersSetters() {
		
		$reportId = 'sddsffsdsfsd';
		
		$this->renderer->setReportId($reportId);
		$this->assertEquals($reportId, $this->renderer->getReportId()); 
		$this->assertTrue($this->renderer->getForceReload());
		$this->renderer->setForceReload(false);
		$this->assertFalse($this->renderer->getForceReload());
	}
	
	public function testSetData() {
		
		$data = new ReportData(array(), 12);
		$this->grid
			->expects($this->once())
			->method('setData')
			->with($data)
		;
		
		$this->renderer->setData($data);
	}
	
	public function testRender() {
		
		$options = array('werr'=> 'sdfds');
		$return = 'sddsf';
		
		$this->widgetRenderer
			->expects($this->once())
			->method('render')
			->with($this->renderer, $options)
			->will($this->returnValue($return))
		;
		
		$this->assertEquals($return, $this->renderer->render($options));
	}
	
	public function testGetRows() {
		
		$rows = array('asdas' => 'sdfdf');
		
		$this->grid
			->expects($this->once())
			->method('getRows')
			->will($this->returnValue($rows))
		;
		
		$this->assertEquals($rows, $this->renderer->getRows());
	}
	
	public function testGetColumns() {
		
		$columns = array('asdas', 'sdfdf');
		
		$this->grid
			->expects($this->once())
			->method('getColumns')
			->will($this->returnValue($columns))
		;
		
		$this->assertEquals($columns, $this->renderer->getColumns());
	}
	
	public function testGetUnpaginatedCount() {
		
		$unpaginatedCount = 12;
		$data = new ReportData(array(), $unpaginatedCount);
		
		try {
			
			$this->renderer->getUnpaginatedCount();
			$this->fail('getUnpaginatedCount did not throw an exception without data set');
		} catch (\BadMethodCallException $e) {
		}
		
		$this->renderer->setData($data);
		$this->assertEquals($unpaginatedCount, $this->renderer->getUnpaginatedCount());
	}
	
	public function testGetCount() {
		
		$unpaginatedCount = 12;
		$data = new ReportData(array(), $unpaginatedCount);
		
		try {
			
			$this->renderer->getCount();
			$this->fail('getCount did not throw an exception without data set');
		} catch (\BadMethodCallException $e) {
		}
		
		$this->renderer->setData($data);
		$this->assertEquals(0, $this->renderer->getCount());
	}
	
	public function testAttributeGettersSetters() {
		
		$attribute = 'sfdsdf';
		$value = 'sdfsf';
		
		$this->renderer->setAttribute($attribute, $value);
		$this->assertEquals($value, $this->renderer->getAttribute($attribute));
		$this->assertEquals('reewrr', $this->renderer->getAttribute('sdfwer', 'reewrr'));
		$this->assertEquals(array($attribute => $value), $this->renderer->getAttributes());
	}
	
	public function testFilterMethods() {
		
		$filters = new NullFilterCollection();
		$filterForm = Mockery::mock('Symfony\Component\Form\FormInterface')
		    ->shouldReceive('bind')
		    ->getMock()
		;
		
		$this->assertFalse($this->renderer->hasFilterForm());
		
		try {
				
			$this->renderer->getFilterForm();
			$this->fail('getFilterForm did not throw an exception without filterForm set');
		} catch (\BadMethodCallException $e) {
		}
		
		$this->renderer->setFilterForm($filterForm);
		$this->assertTrue($this->renderer->hasFilterForm());
		
		try {
				
			$this->renderer->getFilterForm();
			$this->fail('getFilterForm did not throw an exception without filters set');
		} catch (\BadMethodCallException $e) {
		}
		
		$this->renderer->setFilters($filters);
		
		$this->assertSame($filterForm, $this->renderer->getFilterForm());
	}
	
	public function testGetTemplate() {
		
		$this->assertEquals($this->template, $this->renderer->getTemplate());
	}
	
	public function testIteration() {
		
		$this->assertInstanceOf('Traversable', $this->renderer);
		$rows = array(array('asdas' => 'sdfdf'));
		
		$this->grid
			->expects($this->once())
			->method('getRows')
			->will($this->returnValue($rows))
		;
		
		$retrievedRows = array();
		
		foreach ($this->renderer as $key => $row) {
			
			$retrievedRows[$key] = $row;
		}
		
		$this->assertEquals($rows, $retrievedRows);
	}
}
