<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Filter;

use Yjv\Bundle\ReportRenderingBundle\Filter\ArrayFilterCollection;

class ArrayFilterCollectionTest extends \PHPUnit_Framework_TestCase{

	protected $filters;
	
	public function setUp() {
		
		$this->filters = new ArrayFilterCollection();
	}
	
	public function testGettersSetters(){
		
		$name = 'sdfsds';
		$value = 'tretet';
		$default = 'ewcvxvdfg';
		$additionalData = array('sdfsdfds' => 'sdfdsfds');
		$defaults = array('sdfsdfds' => 'sdfdssdfsfds', $name => $default);
		
		$this->assertEquals($default, $this->filters->get($name, $default));
		$this->filters->setDefault($name, $default);
		$this->assertEquals($default, $this->filters->get($name));
		$this->filters->set($name, $value);
		$this->assertEquals($value, $this->filters->get($name, $default));
		$this->assertEquals(array($name => $value), $this->filters->all());
		$this->filters->setDefaults($defaults);
		$this->assertEquals(array_replace($defaults, array($name => $value)), $this->filters->all());
		$this->filters->setAll($additionalData);
		$this->assertEquals(array_replace(array($name => $value), $additionalData), $this->filters->all());
	}
}
