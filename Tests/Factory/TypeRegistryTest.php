<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer\Grid\Column;

use Yjv\Bundle\ReportRenderingBundle\Tests\Factory\TestExtension;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeRegistry;

use Mockery;

class TypeRegistryTest extends \PHPUnit_Framework_TestCase{

	protected $registry;
	protected $extension;
	
	/**
	 * 
	 */
	protected function setUp() {

		$this->extension = new TestExtension();
	    $this->registry = new TypeRegistry();
		$this->assertSame($this->registry, $this->registry->addExtension($this->extension));
	}
	
	public function testTypeGetters() {
		
		$name1 = 'name1';
		$name2 = 'name2';
		$name3 = 'name3';
		
		$type1 = $this->getType($name1);
		$type2 = $this->getType($name2);
		
		$this->extension->addType($type1);
		
		$this->assertTrue($this->registry->hasType($name1));
		$this->assertSame($type1, $this->registry->getType($name1));
		$this->assertFalse($this->registry->hasType($name2));
		$this->extension->addType($type2);
		$this->assertTrue($this->registry->hasType($name2));
		$this->assertSame($type2, $this->registry->getType($name2));
		$this->registry->addExtension($this->extension);
		$this->assertTrue($this->registry->hasType($name2));
		$this->assertFalse($this->registry->hasType($name3));
	}
	
	public function testTypeExtensionsGetters() {
		
		$name1 = 'name1';
		$name2 = 'name2';
		$name3 = 'name3';
		
		$typeExtension1 = $this->getTypeExtension($name1);
		$typeExtension2 = $this->getTypeExtension($name2);
		
		$this->extension->addTypeExtension($typeExtension1);
		
		$this->assertTrue($this->registry->hasTypeExtensions($name1));
		$this->assertSame(array($typeExtension1), $this->registry->getTypeExtensions($name1));
		$this->assertFalse($this->registry->hasTypeExtensions($name2));
		$this->extension->addTypeExtension($typeExtension2);
		$this->assertTrue($this->registry->hasTypeExtensions($name2));
		$this->assertSame(array($typeExtension2), $this->registry->getTypeExtensions($name2));
		$this->registry->addExtension($this->extension);
		$this->assertTrue($this->registry->hasTypeExtensions($name2));
		$this->assertFalse($this->registry->hasTypeExtensions($name3));
	}
	
	public function testExceptionOnTypeNotFound(){
		
		$this->setExpectedException('Yjv\Bundle\ReportRenderingBundle\Factory\TypeNotFoundException');
		$this->registry->getType('name3');
	}
	
	public function testExceptionOnTypeExtensionsNotFound(){
		
		$this->setExpectedException('Yjv\Bundle\ReportRenderingBundle\Factory\TypeExtensionsNotFoundException');
		$this->registry->getTypeExtensions('name3');
	}
	
	/**
	 * @expectedException Yjv\Bundle\ReportRenderingBundle\Factory\TypeNotSupportedException
	 * @expectedExceptionMessage stdClass
	 */
	public function testExceptionOnNonSupportedType()
	{
	    $this->extension->addType($this->getType('name1'));
	    $registry = new TypeRegistry('stdClass');
	    $registry->addExtension($this->extension);
	    $registry->getType('name1');
	}
	
	public function testClearResolved()
	{
	    $extension = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\RegistryExtensionInterface')
	        ->shouldReceive('hasType')
	        ->twice()
	        ->with('name')
	        ->andReturn(true)
	        ->getMock()
	        ->shouldReceive('getType')
	        ->twice()
	        ->with('name')
	        ->andReturn($this->getType('name'))
	        ->getMock()
	        ->shouldReceive('hasTypeExtensions')
	        ->twice()
	        ->with('name')
	        ->andReturn(true)
	        ->getMock()
	        ->shouldReceive('getTypeExtensions')
	        ->twice()
	        ->with('name')
	        ->andReturn(array($this->getTypeExtension('name')))
	        ->getMock()
	    ;
	    
	    $this->registry->addExtension($extension);
	    
	    $this->assertTrue($this->registry->hasType('name'));
	    $this->assertTrue($this->registry->hasType('name'));
	    $this->registry->clearResolved();
	    $this->assertTrue($this->registry->hasType('name'));
	}
	
	public function testGetExtensions()
	{
	    $extension = Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\RegistryExtensionInterface');
	    $this->assertSame(array($this->extension), $this->registry->getExtensions());
	    $this->registry->addExtension($extension);
	    $this->assertSame(array($this->extension, $extension), $this->registry->getExtensions());
	}

	protected function getType($name) {
		
		return Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface')
		    ->shouldReceive('getName')
		    ->andReturn($name)
		    ->getMock()
		;
	}
	
	protected function getTypeExtension($name)
	{
	    return Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeExtensionInterface')
	        ->shouldReceive('getExtendedType')
	        ->andReturn($name)
	        ->getMock()
	    ;
	}
}
