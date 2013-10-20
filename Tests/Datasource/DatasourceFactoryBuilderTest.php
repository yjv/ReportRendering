<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid\Column;

use Yjv\ReportRendering\Datasource\DatasourceFactoryBuilder;

class DatasourceFactoryBuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $builder;

    protected function setUp()
    {
        $this->builder = new DatasourceFactoryBuilder();
    }
    
    public function testBuild()
    {
        $this->assertInstanceOf('Yjv\ReportRendering\Datasource\DatasourceFactory', $this->builder->build());
    }
}
