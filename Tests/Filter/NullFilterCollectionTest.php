<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Filter;

use Yjv\Bundle\ReportRenderingBundle\Filter\NullFilterCollection;

class NullFilterCollectionTest extends \PHPUnit_Framework_TestCase{

	protected $filters;
	
	public function setUp() {
		
		$this->filters = new NullFilterCollection();
	}
	
	public function testGettersSetters(){
		
		$name = 'sdfsds';
		$value = 'tretet';
		$default = 'ewcvxvdfg';
		
		$this->filters->set($name, $value);
		$this->assertEquals($default, $this->filters->get($name, $default));
		$this->assertEmpty($this->filters->all());
		$this->filters->setAll(array($name => $value));
		$this->assertEmpty($this->filters->all());
	}
}
