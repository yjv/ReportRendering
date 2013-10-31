<?php
namespace Yjv\ReportRendering\Tests;

use Yjv\ReportRendering\ReportRendering;
use Mockery;

class ReportRenderingTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateReportFactoryBuilder()
    {
        $this->assertInstanceOf('Yjv\ReportRendering\Report\ReportFactoryBuilder', ReportRendering::createReportFactoryBuilder());
        $templatingEngine = Mockery::mock('Symfony\Component\Templating\EngineInterface');
        $factory = ReportRendering::createReportFactoryBuilder($templatingEngine)->build();
        $this->assertTrue($factory->getRendererFactory()->getTypeRegistry()->hasType('html'));
    }
    
    public function testCreateReportFactory()
    {
        $this->assertInstanceOf('Yjv\ReportRendering\Report\ReportFactory', ReportRendering::createReportFactory());
        $templatingEngine = Mockery::mock('Symfony\Component\Templating\EngineInterface');
        $factory = ReportRendering::createReportFactory($templatingEngine);
        $this->assertTrue($factory->getRendererFactory()->getTypeRegistry()->hasType('html'));
    }
}
