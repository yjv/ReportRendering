<?php
namespace Yjv\ReportRendering\Tests\Filter;

use Yjv\ReportRendering\Filter\NullFilterCollection;

class NullFilterCollectionTest extends \PHPUnit_Framework_TestCase
{
	protected $filters;
	
	public function setUp()
    {
		$this->filters = new NullFilterCollection();
	}
	
	public function testGettersSetters()
    {
		$name = 'sdfsds';
		$value = 'tretet';
		$default = 'ewcvxvdfg';
		
		$this->filters->set($name, $value);
		$this->assertEquals($default, $this->filters->get($name, $default));
		$this->assertEmpty($this->filters->all());
		$this->filters->setAll(array($name => $value));
		$this->assertEmpty($this->filters->all());
        $this->assertSame($this->filters, $this->filters->replace(array()));
        $this->assertSame($this->filters, $this->filters->remove('name'));
        $this->assertSame($this->filters, $this->filters->clear());
	}
}
