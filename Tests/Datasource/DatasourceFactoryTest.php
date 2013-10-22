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
	
	public function testCreate()
	{
	    $factory = $this
			->getMockBuilder(get_class($this->factory))
			->disableOriginalConstructor()
			->setMethods(array('createBuilder'))
			->getMock()
	    ;
	    
	    $type = 'type';
	    $options = array('key' => 'value');
	    $datasource = Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceInterface');
	    
	    $builder = Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceBuilderInterface')
	        ->shouldReceive('getDatasource')
	        ->once()
	        ->andReturn($datasource)
	        ->getMock()
	    ;
	    
	    $factory
    	    ->expects($this->once())
    	    ->method('createBuilder')
    	    ->with($type, $options)
    	    ->will($this->returnValue($builder))
	    ;
	    
	    $this->assertSame($datasource, $factory->create($type, $options));
	}
	
	public function testGetBuilderInterfaceName()
	{
	    $this->assertEquals('Yjv\ReportRendering\Datasource\DatasourceBuilderInterface', $this->factory->getBuilderInterfaceName());
	}
}
