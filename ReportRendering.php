<?php
namespace Yjv\ReportRendering;

use Yjv\ReportRendering\Report\Extension\Core\CoreExtension as CoreReportExtension;
use Yjv\ReportRendering\Datasource\Extension\Core\CoreExtension as CoreDatasourceExtension;
use Yjv\ReportRendering\Renderer\Extension\Core\CoreExtension as CoreRendererExtension;
use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\CoreExtension as CoreColumnExtension;

use Yjv\ReportRendering\Report\ReportFactoryBuilder;

class ReportRendering
{
    public function createReportFactory()
    {
        return self::createReportFactoryBuilder()->build();
    }
    
    public function createReportFactoryBuilder()
    {
        $reportFactoryBuilder = ReportFactoryBuilder::getInstance();
        
        $reportFactoryBuilder
            ->addExtension(new CoreReportExtension())
        ;

        $reportFactoryBuilder
            ->getDatasourceFactoryBuilder()
            ->addExtension(new CoreDatasourceExtension())
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
