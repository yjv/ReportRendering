<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer\Html;

use Yjv\Bundle\ReportRenderingBundle\Filter\NullFilterCollection;

use Yjv\Bundle\ReportRenderingBundle\ReportData\ReportData;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Html\HtmlRenderer;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HtmlRendererTest extends WebTestCase{

	protected $grid;
	protected $template;
	protected $widgetRenderer;
	protected $renderer;
	
	public function setUp(){
		
		$this->grid = $this->getMock('Yjv\\Bundle\\ReportRenderingBundle\\Renderer\\Grid\\GridInterface');
		$this->template = 'template';
		$this->widgetRenderer = $this->getMock('Yjv\\Bundle\\ReportRenderingBundle\\Widget\\WidgetRenderer', array(), array($this->getMock('Symfony\\Component\\Templating\\EngineInterface')));
		$this->renderer = new HtmlRenderer($this->widgetRenderer, $this->grid, $this->template);
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
	
	public function testGetUnfilteredCount() {
		
		$unfilteredCount = 12;
		$data = new ReportData(array(), $unfilteredCount);
		
		try {
			
			$this->renderer->getUnfilteredCount();
			$this->fail('getUnfilteredCount did not throw an exception without data set');
		} catch (\BadMethodCallException $e) {
		}
		
		$this->renderer->setData($data);
		$this->assertEquals($unfilteredCount, $this->renderer->getUnfilteredCount());
	}
	
	public function testGetCount() {
		
		$unfilteredCount = 12;
		$data = new ReportData(array(), $unfilteredCount);
		
		try {
			
			$this->renderer->getCount();
			$this->fail('getUnfilteredCount did not throw an exception without data set');
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
		$filterForm = $this->getMock('Symfony\\Component\\Form\\Tests\\FormInterface');
		
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
}
