<?php
namespace Yjv\ReportRendering\Tests\Report;

use Yjv\ReportRendering\Report\AbstractReportType;

use Mockery;

class AbstractreportTypeTest extends \PHPUnit_Framework_TestCase
{
    protected $type;
    
    public function setUp()
    {
        $this->type = new TestAbstractReportType();
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
        $this->type->build(Mockery::mock('Yjv\ReportRendering\Report\ReportBuilderInterface'), array());
    }
    
    public function testBuildReport()
    {
        $this->type->buildReport(Mockery::mock('Yjv\ReportRendering\Report\ReportBuilderInterface'), array());
    }
    
    public function testFinalize()
    {
        $this->type->finalize(Mockery::mock('Yjv\ReportRendering\Report\ReportInterface'), array());
    }
    
    public function testFinalizeReport()
    {
        $this->type->finalizeReport(Mockery::mock('Yjv\ReportRendering\Report\ReportInterface'), array());
    }
    
    public function testGetParent()
    {
        $this->assertEquals('report', $this->type->getParent());
    }
}

class TestAbstractReportType extends AbstractReportType
{
    function getName()
    {
        return 'test';
    }
}