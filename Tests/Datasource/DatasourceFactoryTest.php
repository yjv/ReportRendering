<?php
namespace Yjv\ReportRendering\Tests\Datasource;

use Yjv\ReportRendering\Datasource\DatasourceFactory;

use Mockery;

class DatasourceFactoryTest extends \PHPUnit_Framework_TestCase
{
	protected $factory;
	protected $resolver;
	
	public function setUp(){
		
		$this->resolver = Mockery::mock('Yjv\TypeFactory\TypeResolverInterface');
		$this->factory = new DatasourceFactory($this->resolver);
	}
	
	public function testGetBuilderInterfaceName()
	{
	    $this->assertEquals('Yjv\ReportRendering\Datasource\DatasourceBuilderInterface', $this->factory->getBuilderInterfaceName());
	}
}
