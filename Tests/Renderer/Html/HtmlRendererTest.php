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
		
		$this->grid = Mockery::mock('Yjv\\ReportRendering\\Renderer\\Grid\\GridInterface');
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
		$this->assertFalse($this->renderer->getForceReload());
		$this->grid
		    ->shouldReceive('setForceReload')
		    ->once()
		    ->with(true)
		    ->getMock()
		;
		$this->renderer->setForceReload(true);
		$this->assertTrue($this->renderer->getForceReload());
		$filters = Mockery::mock('Yjv\ReportRendering\Filter\FilterCollectionInterface');
		$this->assertSame($this->renderer, $this->renderer->setFilters($filters));
		$this->assertSame($filters, $this->renderer->getFilters());
		$this->assertSame($this->grid, $this->renderer->getGrid());
	}
	
	public function testSetData() {
		
		$data = new ReportData(array(), 12);
		$this->grid
		    ->shouldReceive('setData')
		    ->once()
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
	
	public function testGetUnpaginatedCount() {
		
		$unpaginatedCount = 12;
		$data = new ReportData(array(), $unpaginatedCount);
		
		$this->grid
		    ->shouldReceive('setData')
		    ->once()
		    ->with($data)
		;
		$this->renderer->setData($data);
		$this->assertEquals($unpaginatedCount, $this->renderer->getUnpaginatedCount());
	}
	
	/**
	 * @expectedException BadMethodCallException
	 * @expectedExceptionMessage data must be set to use this method
	 */
	public function testGetUnpaginatedCountWithDataNotSet()
	{
		$this->renderer->getUnpaginatedCount();
	}
	
	public function testGetCount() {
		
		$unpaginatedCount = 12;
		$data = new ReportData(array(), $unpaginatedCount);
		
		$this->grid
		    ->shouldReceive('setData')
		    ->once()
		    ->with($data)
		;
		$this->renderer->setData($data);
		$this->assertEquals(0, $this->renderer->getCount());
	}
	
	/**
	 * @expectedException BadMethodCallException
	 * @expectedExceptionMessage data must be set to use this method
	 */
	public function testGetCountWithDataNotSet()
	{
		$this->renderer->getCount();
	}
	
	public function testAttributeGettersSetters() {
		
		$attribute = 'sfdsdf';
		$value = 'sdfsf';
		
		$this->renderer->setAttribute($attribute, $value);
		$this->assertEquals($value, $this->renderer->getAttribute($attribute));
		$this->assertEquals('reewrr', $this->renderer->getAttribute('sdfwer', 'reewrr'));
		$this->assertEquals(array($attribute => $value), $this->renderer->getAttributes());
	}
	
	public function testOptionGettersSetters() {
		
		$name = 'sfdsdf';
		$value = 'sdfsf';
		
		$this->renderer->setOption($name, $value);
		$this->assertEquals($value, $this->renderer->getOption($name));
		$this->assertEquals('reewrr', $this->renderer->getOption('sdfwer', 'reewrr'));
		$this->assertEquals(array($name => $value), $this->renderer->getOptions());
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
}
