<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer\Grid\Column;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeRegistry;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerRegistry;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnRegistry;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnFactory;

class ColumnFactoryTest extends \PHPUnit_Framework_TestCase{

	protected $factory;
	protected $registry;
	protected $dataTransformerRegistry;
	
	/**
	 * 
	 */
	protected function setUp() {

		$this->registry = new TypeRegistry();
		$this->dataTransformerRegistry = new DataTransformerRegistry();
		$this->factory = new ColumnFactory($this->registry, $this->dataTransformerRegistry);
	}
	
	/**
	 * 
	 */
	public function testCreate(){
		
		$type = 'type';
		$options = array('key' => 'value');
		$column = new Column();
		$builder = $this->getMock('Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilderInterface');
		$builder->expects($this->once())->method('getColumn')->will($this->returnValue($column));
		
		$factory = $this
			->getMockBuilder(get_class($this->factory))
			->disableOriginalConstructor()
			->setMethods(array('createBuilder'))
			->getMock();
		$factory->expects($this->once())->method('createBuilder')->with($type, $options)->will($this->returnValue($builder));
		$this->assertSame($column, $factory->create($type, $options));
	}
	
	public function testGetAddType(){
		
		$columnType1 = $this->getColumnType('name1');
		$this->assertSame($this->factory, $this->factory->addType($columnType1));
		$this->assertSame($columnType1, $this->factory->getType($columnType1->getName()));
	}
	
	public function testGetBuilderInterfaceName(){
		
		$this->assertEquals('Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilderInterface', $this->factory->getBuilderInterfaceName());
	}
	
	protected function getColumnType($name, $parent = false) {
	
		$tester = $this;
		$type = $this->getMockBuilder('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface')->getMock();
		$type->expects($this->any())->method('getName')->will($this->returnValue($name));
		$type->expects($this->any())->method('getParent')->will($this->returnValue($parent));
		return $type;
	}
}
