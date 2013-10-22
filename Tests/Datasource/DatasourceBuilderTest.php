<?php
namespace Yjv\ReportRendering\Tests\Datasource;

use Yjv\ReportRendering\Datasource\DatasourceBuilder;

use Yjv\ReportRendering\Renderer\RendererBuilder;

use Mockery;

class DatasourceBuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $builder;
    protected $factory;
    
    public function setUp()
    {
        $this->factory = Mockery::mock('Yjv\TypeFactory\TypeFactoryInterface');
        $this->builder = new DatasourceBuilder($this->factory);
    }
    
    public function testGetRenderer()
    {
        $datasource = Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceInterface');
        
        $callback = function() use ($datasource){
            
            return $datasource;
        };
        
        $this->builder->setConstructor($callback);
        $this->assertSame($datasource, $this->builder->getDatasource());
    }
    
    /**
     * @expectedException Yjv\ReportRendering\Datasource\ValidDatasourceNotReturnedException
     * @expectedExceptionMessage No valid datasource was returned from the builder's constructor callback.
     */
    public function testGetRendererWithInvalidDatasoucre()
    {
        $callback = function(){};
        $this->builder->setConstructor($callback);
        $this->builder->getDatasource();
    }
}
