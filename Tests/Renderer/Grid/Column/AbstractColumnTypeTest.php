<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer\Grid\Column;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnRegistry;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnFactory;

class AbstractColumnTypeTest extends \PHPUnit_Framework_TestCase{

	protected $type;
	protected $factory;
	
	/**
	 * 
	 */
	protected function setUp() {

		$this->type = $this->getMockForAbstractClass('Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\AbstractColumnType');
		$this->factory = $this->getMockBuilder('Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnFactory')->disableOriginalConstructor()->getMock();
	}
	
	public function testBuildColumn(){
		
		$this->assertNull($this->type->build($this->getMock('Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilderInterface'), array()));
		$this->assertNull($this->type->buildColumn($this->getMock('Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilderInterface'), array()));
	}
	
	public function testSetDefaultOptions(){
		
		$this->assertNull($this->type->setDefaultOptions($this->getMock('Symfony\Component\OptionsResolver\OptionsResolverInterface')));
	}
	
	public function testCreateBuilder() {
		
		$this->assertInstanceOf('Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilderInterface', $this->type->createBuilder($this->factory, array()));
	}
	
	public function testGetParent(){
		
		$this->assertEquals('column', $this->type->getParent());
	}
	
	public function testGetOptionsResolver() {
		
		$this->assertInstanceOf('Symfony\Component\OptionsResolver\OptionsResolverInterface', $this->type->getOptionsResolver());
	}
}
