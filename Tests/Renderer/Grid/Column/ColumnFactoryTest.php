<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid\Column;

use Yjv\TypeFactory\Tests\TypeFactoryTest;
use Mockery;
use Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactory;

class ColumnFactoryTest extends TypeFactoryTest
{
	/**
	 * 
	 */
	protected function setUp()
    {
        parent::setUp();
		$this->factory = new ColumnFactory($this->resolver);
        $this->builder = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface');

    }
	
	public function testGetBuilderInterfaceName()
    {
		$this->assertEquals('Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface', $this->factory->getBuilderInterfaceName());
	}
}
