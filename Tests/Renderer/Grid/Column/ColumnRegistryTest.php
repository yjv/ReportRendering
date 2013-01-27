<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer\Grid\Column;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnRegistry;

class ColumnRegistryTest extends \PHPUnit_Framework_TestCase{

	protected $registry;
	
	/**
	 * 
	 */
	protected function setUp() {

		$this->registry = new ColumnRegistry();
	}
	
	public function testGettersSetters() {
		
		$name1 = 'name1';
		$name2 = 'name2';
		$name3 = 'name3';
		
		$type1 = $this->getColumnType($name1);
		$type2 = $this->getColumnType($name2);
		
		$this->assertCount(0, $this->registry->all());
		$this->assertSame($this->registry, $this->registry->set($type1));
		$this->assertCount(1, $this->registry->all());
		$this->assertTrue($this->registry->has($name1));
		$this->assertFalse($this->registry->has($name2));
		$this->assertSame($this->registry, $this->registry->set($type2));
		$this->assertCount(2, $this->registry->all());
		$this->assertTrue($this->registry->has($name2));
		$this->assertFalse($this->registry->has($name3));
	}
	
	public function testExceptionOnNotFound(){
		
		$this->setExpectedException('Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnTypeNotFoundException');
		$this->registry->get('name3');
	}

	protected function getColumnType($name) {
		
		$type = $this->getMockBuilder('Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnTypeInterface')->getMock();
		$type->expects($this->any())->method('getName')->will($this->returnValue($name));
		return $type;
	}
}
