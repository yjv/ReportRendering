<?php
namespace Yjv\ReportRendering;

use Symfony\Component\Form\FormFactoryInterface;

use Symfony\Component\Templating\EngineInterface;

use Symfony\Component\Form\Forms;

use Yjv\ReportRendering\DataTransformer\DateTimeTransformer;
use Yjv\ReportRendering\DataTransformer\FormatStringTransformer;
use Yjv\ReportRendering\DataTransformer\MappedDataTransformer;
use Yjv\ReportRendering\DataTransformer\PropertyPathTransformer;
use Yjv\ReportRendering\Report\Extension\Core\CoreExtension as CoreReportExtension;
use Yjv\ReportRendering\Datasource\Extension\Core\CoreExtension as CoreDatasourceExtension;
use Yjv\ReportRendering\Renderer\Extension\Core\CoreExtension as CoreRendererExtension;
use Yjv\ReportRendering\Renderer\Extension\Symfony\SymfonyExtension as SymfonyRendererExtension;
use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\CoreExtension as CoreColumnExtension;

use Yjv\ReportRendering\Report\ReportFactoryBuilder;

class ReportRendering
{
    /**
     * @param EngineInterface $templatingEngine
     * @param FormFactoryInterface $formFactory
     * @return \Yjv\TypeFactory\TypeFactoryInterface
     */
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

        if ($formFactory) {

            $reportFactoryBuilder
                ->getRendererFactoryBuilder()
                ->addExtension(new SymfonyRendererExtension($formFactory))
            ;
        }

        
        $reportFactoryBuilder
            ->getRendererFactoryBuilder()
            ->getColumnFactoryBuilder()
            ->addExtension(new CoreColumnExtension())
            ->addDataTransformer('mapped_data', new MappedDataTransformer())
            ->addDataTransformer('format_string', new FormatStringTransformer())
            ->addDataTransformer('property_path', new PropertyPathTransformer())
            ->addDataTransformer('date_time', new DateTimeTransformer())
        ;
        
        return $reportFactoryBuilder;
    }
}
