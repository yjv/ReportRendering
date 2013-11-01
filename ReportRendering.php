<?php
namespace Yjv\ReportRendering;

use Symfony\Component\Templating\EngineInterface;

use Symfony\Component\Form\Forms;

use Yjv\ReportRendering\Widget\WidgetRenderer;

use Yjv\ReportRendering\Report\Extension\Core\CoreExtension as CoreReportExtension;
use Yjv\ReportRendering\Datasource\Extension\Core\CoreExtension as CoreDatasourceExtension;
use Yjv\ReportRendering\Renderer\Extension\Core\CoreExtension as CoreRendererExtension;
use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\CoreExtension as CoreColumnExtension;

use Yjv\ReportRendering\Report\ReportFactoryBuilder;

class ReportRendering
{
    public static function createReportFactory(EngineInterface $templatingEngine = null)
    {
        return self::createReportFactoryBuilder($templatingEngine)->build();
    }
    
    public static function createReportFactoryBuilder(EngineInterface $templatingEngine = null)
    {
        $reportFactoryBuilder = ReportFactoryBuilder::getInstance();
        
        $reportFactoryBuilder
            ->addExtension(new CoreReportExtension())
        ;

        $reportFactoryBuilder
            ->getDatasourceFactoryBuilder()
            ->addExtension(new CoreDatasourceExtension())
        ;

        if ($templatingEngine) {
            
            $rendererExtension = new CoreRendererExtension(
                new WidgetRenderer($templatingEngine),
                Forms::createFormFactory()
            );
        } else {

            $rendererExtension = new CoreRendererExtension();
        }
        
        $reportFactoryBuilder
            ->getRendererFactoryBuilder()
            ->addExtension($rendererExtension)
        ;
        
        $reportFactoryBuilder
            ->getRendererFactoryBuilder()
            ->getColumnFactoryBuilder()
            ->addExtension(new CoreColumnExtension())
        ;
        
        return $reportFactoryBuilder;
    }
}
