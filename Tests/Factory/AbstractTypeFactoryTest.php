<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Factory;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeFactoryInterface;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeRegistry;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeFactoryTest extends \PHPUnit_Framework_TestCase{

	protected $factory;
	protected $registry;
	
	/**
	 * 
	 */
	protected function setUp() {

		$this->registry = new TypeRegistry();
		$this->factory = $this->getMockForAbstractClass('Yjv\Bundle\ReportRenderingBundle\Factory\AbstractTypeFactory');
		$reflectionProperty = new \ReflectionProperty($this->factory, 'registry');
		$reflectionProperty->setAccessible(true);
		$reflectionProperty->setValue($this->factory, $this->registry);
	}
	
	/**
	 * 
	 * @dataProvider createDataProvider
	 */
	public function testCreateBuilder($optionsResolverIndex, $builderIndex, array $expectedArray){
		
		$passedOptions = array('option1' => '1');
		$returnedOptions = array('option1' => '1', 'option2' => '2');
		$array = array();
		$builder = new \stdClass();
		$this->factory->expects($this->once())->method('getBuilderInterfaceName')->will($this->returnValue(get_class($builder)));
		$optionsResolver = $this->getMockBuilder('Symfony\Component\OptionsResolver\OptionsResolver')->getMock();
		$optionsResolver->expects($this->once())->method('resolve')->with($passedOptions)->will($this->returnValue($returnedOptions));
		$name1 = 'name1';
		$name2 = 'name2';
		$name3 = 'name3';
		$type3 = $this->getType($name3, false, 3, $array, $builderIndex == 3 ? $builder : false, $optionsResolverIndex == 3 ? $optionsResolver : false, $returnedOptions);
		$type2 = $this->getType($name2, $type3, 2, $array, $builderIndex == 2 ? $builder : false, $optionsResolverIndex == 2 ? $optionsResolver : false, $returnedOptions);
		$type1 = $this->getType($name1, $name2, 1, $array, $builderIndex == 1 ? $builder : false, $optionsResolverIndex == 1 ? $optionsResolver : false, $returnedOptions);
		
		$this->registry->set($type2)
		->set($type1);
		
		$this->assertSame($builder, $this->factory->createBuilder('name1', $passedOptions));
		$this->assertSame($expectedArray, $array);
	}
	
	/**
	 * 
	 */
	public function testCreateBuilderWithBadBuilderClass(){
		
		$array = array();
		$builder = new \stdClass();
		$this->factory->expects($this->once())->method('getBuilderInterfaceName')->will($this->returnValue('BuilderInterface'));
		$optionsResolver = $this->getMockBuilder('Symfony\Component\OptionsResolver\OptionsResolver')->getMock();
		$optionsResolver->expects($this->once())->method('resolve')->will($this->returnValue(array()));
		$name1 = 'name1';
		$type1 = $this->getType($name1, false, 1, $array, $builder, $optionsResolver);
		
		$this->registry->set($type1);
		
		$this->setExpectedException('Yjv\Bundle\ReportRenderingBundle\Factory\BuilderNotSupportedException');
		$this->factory->createBuilder('name1');
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
	
	public function testGetType(){
		
		$type1 = $this->getType('name1');
		$this->registry->set($type1);
		$this->assertSame($type1, $this->factory->getType($type1->getName()));
	}
	
	public function testGetTypeChain(){
		
		$name1 = 'name1';
		$name2 = 'name2';
		$name3 = 'name3';
		
		$type3 = $this->getType($name3);
		$type2 = $this->getType($name2, $type3);
		$type1 = $this->getType($name1, $name2);
		
		$this->registry->set($type2)
		->set($type1);
		
		$this->assertSame(array($type3, $type2, $type1), $this->factory->getTypeChain($type1));
		$this->assertSame(array($type3, $type2, $type1), $this->factory->getTypeChain($name1));
	}
	
	public function testResolveType(){
		
		$name1 = 'name1';
		$name2 = 'name2';
		$type1 = $this->getType($name1);
		$type2 = $this->getType($name2);
		
		$this->registry->set($type1);
		
		$this->assertSame($type1, $this->factory->resolveType($type1));
		$this->assertSame($type2, $this->factory->resolveType($type2));
		$this->assertSame($type1, $this->factory->resolveType($name1));
	}
	
	public function testGetTypeRegistry(){
		
		$this->assertSame($this->registry, $this->factory->getTypeRegistry());
	}
	
	protected function getType($name, $parent = false, $index = 0, &$array = array(), $builder = false, $optionsResolver = false, $passedOptions = array()) {
	
		$tester = $this;
		$factory = $this->factory;
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
			->method('createBuilder')
			->will($this->returnCallback(function(TypeFactoryInterface $factory, array $options) use (&$array, $index, $builder, $tester, $passedOptions){
				
				$tester->assertEquals($passedOptions, $options);
				
				$array[] = $index;
				return $builder;
			}));
		$type
			->expects($this->any())
			->method('build')
			->will($this->returnCallback(function($sentBuilder, array $options) use (&$array, $index, $builder, $tester, $passedOptions){
				
				$tester->assertEquals($passedOptions, $options);
				
				if ($builder) {
						
					$tester->assertEquals($builder, $sentBuilder);
				}
				
				$array[] = $index;
			}));
		return $type;
	}
}
