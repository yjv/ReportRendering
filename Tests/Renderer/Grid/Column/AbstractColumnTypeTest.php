<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid\Column;


use Mockery;

class AbstractColumnTypeTest extends \PHPUnit_Framework_TestCase{

	protected $type;
	protected $factory;
	
	/**
	 * 
	 */
	protected function setUp() {

		$this->type = $this->getMockForAbstractClass('Yjv\ReportRendering\Renderer\Grid\Column\AbstractColumnType');
		$this->factory = $this->getMockBuilder('Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactory')->disableOriginalConstructor()->getMock();
	}
	
	public function testBuildColumn(){
		
		$this->assertNull($this->type->build($this->getMock('Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface'), array()));
		$this->assertNull($this->type->buildColumn($this->getMock('Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface'), array()));
	}
	
	public function testCreateBuilder()
	{
	    $this->type->createBuilder(Mockery::mock('Yjv\TypeFactory\TypeFactoryInterface'), array());
	}
	
	public function testSetDefaultOptions(){
		
		$this->type->setDefaultOptions($this->getMock('Symfony\Component\OptionsResolver\OptionsResolverInterface'));
	}
	
	public function testGetParent(){
		
		$this->assertEquals('column', $this->type->getParent());
	}
	
	public function testGetOptionsResolver() {
		
		$this->assertInstanceOf('Symfony\Component\OptionsResolver\OptionsResolverInterface', $this->type->getOptionsResolver());
	}
}
