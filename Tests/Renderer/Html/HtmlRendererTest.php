<?php
namespace Yjv\ReportRendering\Tests\Renderer\Html;

use Yjv\ReportRendering\FilterConstants;

use Yjv\ReportRendering\Filter\NullFilterCollection;

use Mockery;

use Yjv\ReportRendering\ReportData\ReportData;

use Yjv\ReportRendering\Renderer\Html\HtmlRenderer;


class HtmlRendererTest extends \PHPUnit_Framework_TestCase{

	protected $grid;
	protected $template;
	protected $rendererEngine;
	protected $renderer;
	
	public function setUp(){
		
		$this->grid = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\GridInterface');
		$this->template = 'template';
		$this->rendererEngine = $this->getMockBuilder('Symfony\Component\Templating\EngineInterface')
			->disableOriginalConstructor()
			->getMock();
		$this->renderer = new HtmlRenderer($this->rendererEngine, $this->grid, $this->template);
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
		
		$this->rendererEngine
			->expects($this->once())
			->method('render')
			->with($this->template, array_merge($options, array('renderer' => $this->renderer)))
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
	
	public function testGetPage()
	{
	    $limit = 312;
	    $offset = 632;
	    
	    $filters = Mockery::mock('Yjv\ReportRendering\Filter\FilterCollectionInterface')
	        ->shouldReceive('get')
	        ->once()
	        ->with(FilterConstants::LIMIT, FilterConstants::DEFAULT_LIMIT)
	        ->andReturn($limit)
	        ->getMock()
	        ->shouldReceive('get')
	        ->once()
	        ->with(FilterConstants::OFFSET, FilterConstants::DEFAULT_OFFSET)
	        ->andReturn($offset)
	        ->getMock()
	    ;
	    $this->renderer->setFilters($filters);
	    $this->assertEquals(3, $this->renderer->getPage());
	}
	
	public function testGetMinPage()
	{
	    $filters = Mockery::mock('Yjv\ReportRendering\Filter\FilterCollectionInterface')
	        ->shouldReceive('get')
	        ->times(3)
	        ->with(FilterConstants::LIMIT, FilterConstants::DEFAULT_LIMIT)
	        ->andReturn(100)
	        ->getMock()
	        ->shouldReceive('get')
	        ->times(3)
	        ->with(FilterConstants::OFFSET, FilterConstants::DEFAULT_OFFSET)
	        ->andReturn(200, 200, 500)
	        ->getMock()
	    ;
	    $this->renderer->setFilters($filters);
	    $this->assertEquals(1, $this->renderer->getMinPage());
	    $this->renderer->setOption(HtmlRenderer::PAGINATION_OVERFLOW_KEY, 1);
	    $this->assertEquals(2, $this->renderer->getMinPage());
	    $this->renderer->setOption(HtmlRenderer::PAGINATION_OVERFLOW_KEY, 3);
	    $this->assertEquals(3, $this->renderer->getMinPage());
	}
	
	public function testGetMaxPage()
	{
	    $filters = Mockery::mock('Yjv\ReportRendering\Filter\FilterCollectionInterface')
    	    ->shouldReceive('get')
    	    ->times(6)
    	    ->with(FilterConstants::LIMIT, FilterConstants::DEFAULT_LIMIT)
    	    ->andReturn(100)
    	    ->getMock()
	        ->shouldReceive('get')
	        ->times(3)
	        ->with(FilterConstants::OFFSET, FilterConstants::DEFAULT_OFFSET)
	        ->andReturn(600, 200, 200)
	        ->getMock()
	    ;
	    $data = Mockery::mock('Yjv\ReportRendering\ReportData\ImmutableDataInterface')
    	    ->shouldReceive('getUnpaginatedCount')
    	    ->times(3)
    	    ->andReturn(605)
    	    ->getMock()
	    ;
	    $this->grid
	    ->shouldReceive('setData')
	    ;
	    $this->renderer->setData($data);
	    $this->renderer->setFilters($filters);
	    $this->assertEquals(7, $this->renderer->getMaxPage());
	    $this->renderer->setOption(HtmlRenderer::PAGINATION_OVERFLOW_KEY, 1);
	    $this->assertEquals(4, $this->renderer->getMaxPage());
	    $this->renderer->setOption(HtmlRenderer::PAGINATION_OVERFLOW_KEY, 3);
	    $this->assertEquals(6, $this->renderer->getMaxPage());
	}
	
	public function testGetPageCount()
	{
	    $limit = 312;
	    
	    $filters = Mockery::mock('Yjv\ReportRendering\Filter\FilterCollectionInterface')
	        ->shouldReceive('get')
	        ->once()
	        ->with(FilterConstants::LIMIT, FilterConstants::DEFAULT_LIMIT)
	        ->andReturn($limit)
	        ->getMock()
	    ;
	    $data = Mockery::mock('Yjv\ReportRendering\ReportData\ImmutableDataInterface')
	        ->shouldReceive('getUnpaginatedCount')
	        ->once()
	        ->andReturn(1234)
	        ->getMock()
	    ;
	    $this->grid
	        ->shouldReceive('setData')
	    ;
	    $this->renderer->setData($data);
	    $this->renderer->setFilters($filters);
	    $this->assertEquals(4, $this->renderer->getPageCount());
	}
}
