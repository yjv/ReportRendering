<?php
namespace Yjv\ReportRendering\Tests;

use Yjv\ReportRendering\ReportRendering;

class ReportRenderingTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateReportFactoryBuilder()
    {
        $this->assertInstanceOf('Yjv\ReportRendering\Report\ReportFactoryBuilder', ReportRendering::createReportFactoryBuilder());
    }
    
    public function testCreateReportFactory()
    {
        $this->assertInstanceOf('Yjv\ReportRendering\Report\ReportFactory', ReportRendering::createReportFactory());
    }
}
