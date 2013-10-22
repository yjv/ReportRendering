<?php
namespace Yjv\ReportRendering\Tests\Datasource;

use Yjv\ReportRendering\Datasource\AbstractDatasourceType;

use Mockery;

class AbstractDatasourceTypeTest extends \PHPUnit_Framework_TestCase
{
    protected $type;
    
    public function setUp()
    {
        $this->type = new TestAbstractDatasourceType();
    }

    public function testCreateBuilder()
    {
        $this->type->createBuilder(Mockery::mock('Yjv\TypeFactory\TypeFactoryInterface'), array());
    }
    
    public function testSetDefaultOptions()
    {
        $this->type->setDefaultOptions(Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface'));
    }
    
    public function testBuild()
    {
        $this->type->build(Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceBuilderInterface'), array());
        $this->type->buildDatasource(Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceBuilderInterface'), array());
    }
    
    public function testGetParent()
    {
        $this->assertEquals('datasource', $this->type->getParent());
    }
}

class TestAbstractDatasourceType extends AbstractDatasourceType
{
    public function getName(){
        
        return 'test';
    }
}
