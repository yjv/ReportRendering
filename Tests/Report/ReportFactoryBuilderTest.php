<?php
namespace Yjv\ReportRendering\Tests\Factory;

use Yjv\ReportRendering\Report\ReportFactoryBuilder;
use Mockery;

class ReportFactoryBuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $builder;

    protected function setUp()
    {
        $this->builder = new ReportFactoryBuilder();
    }
    
    public function testBuild()
    {
        $this->assertInstanceOf('Yjv\ReportRendering\Report\ReportFactory', $this->builder->build());
    }
    
    public function testGettersSetters()
    {
        $this->assertInstanceOf('Yjv\ReportRendering\Datasource\DatasourceFactoryBuilder', $this->builder->getDatasourceFactoryBuilder());
        $datasourceFactoryBuilder = Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceFactoryBuilder');
        $this->assertSame($this->builder, $this->builder->setDatasourceFactoryBuilder($datasourceFactoryBuilder));
        $this->assertSame($datasourceFactoryBuilder, $this->builder->getDatasourceFactoryBuilder());
        $rendererFactoryBuilder = Mockery::mock('Yjv\ReportRendering\Renderer\RendererFactoryBuilder');
        $this->assertInstanceOf('Yjv\ReportRendering\Renderer\RendererFactoryBuilder', $this->builder->getRendererFactoryBuilder());
        $rendererFactoryBuilder = Mockery::mock('Yjv\ReportRendering\Renderer\RendererFactoryBuilder');
        $this->assertSame($this->builder, $this->builder->setRendererFactoryBuilder($rendererFactoryBuilder));
        $this->assertSame($rendererFactoryBuilder, $this->builder->getRendererFactoryBuilder());
    }
}
