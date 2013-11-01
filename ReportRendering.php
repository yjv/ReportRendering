<?php
namespace Yjv\ReportRendering;

use Symfony\Component\Form\FormFactoryInterface;

use Yjv\ReportRendering\Report\ReportFactoryInterface;

use Symfony\Component\Templating\EngineInterface;

use Symfony\Component\Form\Forms;

use Yjv\ReportRendering\Report\Extension\Core\CoreExtension as CoreReportExtension;
use Yjv\ReportRendering\Datasource\Extension\Core\CoreExtension as CoreDatasourceExtension;
use Yjv\ReportRendering\Renderer\Extension\Core\CoreExtension as CoreRendererExtension;
use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\CoreExtension as CoreColumnExtension;

use Yjv\ReportRendering\Report\ReportFactoryBuilder;

class ReportRendering
{
    public static function createReportFactory(
        EngineInterface $templatingEngine = null,
        FormFactoryInterface $formFactory = null
    ) {
        return self::createReportFactoryBuilder($templatingEngine, $formFactory)->build();
    }
    
    public static function createReportFactoryBuilder(
        EngineInterface $templatingEngine = null,
        FormFactoryInterface $formFactory = null
    ) {
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
            ->addExtension(new CoreRendererExtension(
                $templatingEngine,
                $formFactory ?: Forms::createFormFactory()
            ))
        ;
        
        $reportFactoryBuilder
            ->getRendererFactoryBuilder()
            ->getColumnFactoryBuilder()
            ->addExtension(new CoreColumnExtension())
        ;
        
        return $reportFactoryBuilder;
    }
}
