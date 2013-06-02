<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Report;

use Yjv\Bundle\ReportRenderingBundle\Report\AbstractReportType;

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
        $this->type->createBuilder(Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Factory\TypeFactoryInterface'), array());
    }
    
    public function testSetDefaultOptions()
    {
        $this->type->setDefaultOptions(Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface'));
    }
    
    public function testBuild()
    {
        $this->type->build(Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Report\ReportBuilderInterface'), array());
    }
    
    public function testBuildReport()
    {
        $this->type->buildReport(Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Report\ReportBuilderInterface'), array());
    }
    
    public function testFinalize()
    {
        $this->type->finalize(Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Report\ReportInterface'), array());
    }
    
    public function testFinalizeReport()
    {
        $this->type->finalizeReport(Mockery::mock('Yjv\Bundle\ReportRenderingBundle\Report\ReportInterface'), array());
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