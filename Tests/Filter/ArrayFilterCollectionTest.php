<?php
namespace Yjv\ReportRendering\Tests\Filter;

use Yjv\ReportRendering\Filter\ArrayFilterCollection;

class ArrayFilterCollectionTest extends \PHPUnit_Framework_TestCase
{
    /** @var ArrayFilterCollection  */
	protected $filters;
	
	public function setUp()
    {
		$this->filters = new ArrayFilterCollection();
	}
	
	public function testGettersSetters()
    {
		$name = 'sdfsds';
		$value = 'tretet';
		$default = 'ewcvxvdfg';
		$additionalData = array('sdfsdfds' => 'sdfdsfds');
		$defaults = array('sdfsdfds' => 'sdfdssdfsfds', $name => $default);
        $replacingValues = array('xcvvxvxc' => 'erttre', 'iyuiuy' => 'xzccxz');
		
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
        $this->assertSame($this->filters, $this->filters->replace($replacingValues));
        $this->assertEquals($replacingValues, $this->filters->all());
        unset($replacingValues['xcvvxvxc']);
        $this->assertSame($this->filters, $this->filters->remove('xcvvxvxc'));
        $this->assertEquals($replacingValues, $this->filters->all());
        $this->assertSame($this->filters, $this->filters->clear());
        $this->assertEquals(array(), $this->filters->all());
    }
}
