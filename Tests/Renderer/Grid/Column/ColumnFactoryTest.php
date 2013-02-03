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
		
		
	}
	
	public function testGetAddType(){
		
		$columnType1 = $this->getColumnType('name1');
		$this->assertSame($this->factory, $this->factory->addType($columnType1));
		$this->assertSame($columnType1, $this->factory->getType($columnType1->getName()));
	}
	
	protected function getColumnType($name, $parent = false, $index = 0, &$array = array(), $column = false, $optionsResolver = false, $passedOptions = array()) {
	
		$tester = $this;
		$type = $this->getMockBuilder('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface')->getMock();
		$type->expects($this->any())->method('getName')->will($this->returnValue($name));
		$type->expects($this->any())->method('getParent')->will($this->returnValue($parent));
		
		$type
			->expects($this->any())
			->method('getOptionsResolver')
			->will($this->returnCallback(function() use (&$array, $index, $optionsResolver){
				
				$array[] = $index;
				return $optionsResolver;
			}));
		$type
			->expects($this->any())
			->method('setDefaultOptions')
			->will($this->returnCallback(function(OptionsResolverInterface $sentOptionsResolver) use (&$array, $index, $optionsResolver, $tester){
				
				if ($optionsResolver) {
					
					$tester->assertEquals($optionsResolver, $sentOptionsResolver);
				}
				
				$array[] = $index;
			}));
		$type
			->expects($this->any())
			->method('createColumn')
			->will($this->returnCallback(function(array $options) use (&$array, $index, $column, $tester, $passedOptions){
				
				$tester->assertEquals($passedOptions, $options);
				
				$array[] = $index;
				return $column;
			}));
		$type
			->expects($this->any())
			->method('buildColumn')
			->will($this->returnCallback(function(ColumnInterface $sentColumn, array $options) use (&$array, $index, $column, $tester, $passedOptions){
				
				$tester->assertEquals($passedOptions, $options);
				
				if ($column) {
						
					$tester->assertEquals($column, $sentColumn);
				}
				
				$array[] = $index;
			}));
		return $type;
	}
}
