<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/13/14
 * Time: 9:58 PM
 */

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
 