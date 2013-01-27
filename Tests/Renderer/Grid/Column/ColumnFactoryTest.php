<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer\Grid\Column;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnRegistry;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnFactory;

class ColumnFactoryTest extends \PHPUnit_Framework_TestCase{

	protected $factory;
	protected $registry;
	
	/**
	 * 
	 */
	protected function setUp() {

		$this->registry = new ColumnRegistry();
		$this->factory = new ColumnFactory($this->registry);
	}
	
	/**
	 * 
	 * @dataProvider createDataProvider
	 */
	public function testCreate($optionsResolverIndex, $columnIndex, array $expectedArray){
		
		$passedOptions = array('option1' => '1');
		$returnedOptions = array('option1' => '1', 'option2' => '2');
		$array = array();
		$column = new Column();
		$optionsResolver = $this->getMockBuilder('Symfony\Component\OptionsResolver\OptionsResolver')->getMock();
		$optionsResolver->expects($this->once())->method('resolve')->with($passedOptions)->will($this->returnValue($returnedOptions));
		$name1 = 'name1';
		$name2 = 'name2';
		$name3 = 'name3';
		$columnType3 = $this->getColumnType($name3, false, 3, $array, $columnIndex == 3 ? $column : false, $optionsResolverIndex == 3 ? $optionsResolver : false, $returnedOptions);
		$columnType2 = $this->getColumnType($name2, $columnType3, 2, $array, $columnIndex == 2 ? $column : false, $optionsResolverIndex == 2 ? $optionsResolver : false, $returnedOptions);
		$columnType1 = $this->getColumnType($name1, $name2, 1, $array, $columnIndex == 1 ? $column : false, $optionsResolverIndex == 1 ? $optionsResolver : false, $returnedOptions);
		
		$this->factory->addType($columnType2)
		->addType($columnType1);
		
		$this->assertSame($column, $this->factory->create('name1', $passedOptions));
		$this->assertSame($expectedArray, $array);
	}
	
	public function createDataProvider(){
		
		return array(
			array(3, 2, array(1, 2, 3, 3, 2, 1, 1, 2, 3, 2, 1)),	
			array(3, 1, array(1, 2, 3, 3, 2, 1, 1, 3, 2, 1)),		
			array(2, 1, array(1, 2, 3, 2, 1, 1, 3, 2, 1)),		
			array(2, 3, array(1, 2, 3, 2, 1, 1, 2, 3, 3, 2, 1)),		
			array(1, 3, array(1, 3, 2, 1, 1, 2, 3, 3, 2, 1)),		
			array(1, 2, array(1, 3, 2, 1, 1, 2, 3, 2, 1)),		
		);
	}
	
	public function testGetAddType(){
		
		$columnType1 = $this->getColumnType('name1');
		$this->assertSame($this->factory, $this->factory->addType($columnType1));
		$this->assertSame($columnType1, $this->factory->getType($columnType1->getName()));
	}
	
	public function testGetTypeList(){
		
		$name1 = 'name1';
		$name2 = 'name2';
		$name3 = 'name3';
		
		$columnType3 = $this->getColumnType($name3);
		$columnType2 = $this->getColumnType($name2, $columnType3);
		$columnType1 = $this->getColumnType($name1, $name2);
		
		$this->factory->addType($columnType2)
		->addType($columnType1);
		
		$this->assertSame(array($columnType3, $columnType2, $columnType1), $this->factory->getTypeList($columnType1));
		$this->assertSame(array($columnType3, $columnType2, $columnType1), $this->factory->getTypeList($name1));
	}
	
	public function testResolveType(){
		
		$name1 = 'name1';
		$name2 = 'name2';
		$columnType1 = $this->getColumnType($name1);
		$columnType2 = $this->getColumnType($name2);
		
		$this->registry->set($columnType1);
		
		$this->assertSame($columnType1, $this->factory->resolveType($columnType1));
		$this->assertSame($columnType2, $this->factory->resolveType($columnType2));
		$this->assertSame($columnType1, $this->factory->resolveType($name1));
	}
	
	protected function getColumnType($name, $parent = false, $index = 0, &$array = array(), $column = false, $optionsResolver = false, $passedOptions = array()) {
	
		$tester = $this;
		$type = $this->getMockBuilder('Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnTypeInterface')->getMock();
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
