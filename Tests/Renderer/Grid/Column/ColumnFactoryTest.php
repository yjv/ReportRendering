<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid\Column;

use Yjv\TypeFactory\TypeRegistry;

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

		$this->resolver = Mockery::mock('Yjv\TypeFactory\TypeResolver');
		$this->dataTransformerRegistry = new DataTransformerRegistry();
		$this->factory = new ColumnFactory($this->resolver, $this->dataTransformerRegistry);
	}
	
	public function testGetBuilderInterfaceName(){
		
		$this->assertEquals('Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface', $this->factory->getBuilderInterfaceName());
	}
	
	public function testGetDataTransformerRegistry()
	{
	    $this->assertSame($this->dataTransformerRegistry, $this->factory->getDataTransformerRegistry());
	}
}
