<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid\Column;

use Yjv\ReportRendering\Factory\TypeRegistry;

use Mockery;

use Yjv\ReportRendering\DataTransformer\DataTransformerRegistry;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Yjv\ReportRendering\Renderer\Grid\Column\Column;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnRegistry;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactory;

class ColumnFactoryTest extends \PHPUnit_Framework_TestCase{

	protected $factory;
	protected $resolver;
	protected $dataTransformerRegistry;
	
	/**
	 * 
	 */
	protected function setUp() {

		$this->resolver = Mockery::mock('Yjv\ReportRendering\Factory\TypeResolver');
		$this->dataTransformerRegistry = new DataTransformerRegistry();
		$this->factory = new ColumnFactory($this->resolver, $this->dataTransformerRegistry);
	}
	
	/**
	 * 
	 */
	public function testCreate(){
		
		$type = 'type';
		$options = array('key' => 'value');
		$column = new Column();
		$builder = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface')
		    ->shouldReceive('getColumn')
		    ->once()
		    ->andReturn($column)
		    ->getMock()
		;
		
		$factory = $this
			->getMockBuilder(get_class($this->factory))
			->disableOriginalConstructor()
			->setMethods(array('createBuilder'))
			->getMock();
		$factory->expects($this->once())->method('createBuilder')->with($type, $options)->will($this->returnValue($builder));
		$this->assertSame($column, $factory->create($type, $options));
	}
	
	public function testGetBuilderInterfaceName(){
		
		$this->assertEquals('Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface', $this->factory->getBuilderInterfaceName());
	}
	
	public function testGetDataTransformerRegistry()
	{
	    $this->assertSame($this->dataTransformerRegistry, $this->factory->getDataTransformerRegistry());
	}
}
