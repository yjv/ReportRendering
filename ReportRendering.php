<?php
namespace Yjv\ReportRendering;

use Yjv\ReportRendering\Report\Extension\Core\CoreExtension as CoreReportExtension;
use Yjv\ReportRendering\Renderer\Extension\Core\CoreExtension as CoreRendererExtension;
use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\CoreExtension as CoreColumnExtension;

use Yjv\ReportRendering\Report\ReportFactoryBuilder;

class ReportRendering
{
    public function createReportFactory()
    {
        return static::createReportFactoryBuilder()->build();
    }
    
    public function createReportFactoryBuilder()
    {
        $reportFactoryBuilder = ReportFactoryBuilder::getInstance();
        
        $reportFactoryBuilder
            ->addExtension(new CoreReportExtension())
        ;
        
        $reportFactoryBuilder
            ->getRendererFactoryBuilder()
            ->addExtension(new CoreRendererExtension())
        ;
        
        $reportFactoryBuilder
            ->getRendererFactoryBuilder()
            ->getColumnFactoryBuilder()
            ->addExtension(new CoreColumnExtension())
        ;
        
        return $reportFactoryBuilder;
    }
}
