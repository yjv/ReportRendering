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
use Yjv\TypeFactory\TypeFactoryInterface;

class ReportRendering
{
    /**
     * @param EngineInterface $templatingEngine
     * @return TypeFactoryInterface
     */
    public static function createReportFactory(
        EngineInterface $templatingEngine = null
    ) {
        return self::createReportFactoryBuilder($templatingEngine)->build();
    }

    /**
     * @param EngineInterface $templatingEngine
     * @param FormFactoryInterface $formFactory
     * @return TypeFactoryInterface
     */
    public static function createReportFactoryWithSymfonyFormFactory(
        FormFactoryInterface $formFactory,
        EngineInterface $templatingEngine = null
    ) {
        return self::createReportFactoryBuilderWithSymfonyFormFactory(
            $formFactory,
            $templatingEngine
        )->build();
    }

    /**
     * @param EngineInterface $templatingEngine
     * @return ReportFactoryBuilder
     */
    public static function createReportFactoryBuilder(
        EngineInterface $templatingEngine = null
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
            ->addExtension(new CoreRendererExtension($templatingEngine))
        ;
        
        $reportFactoryBuilder
            ->getRendererFactoryBuilder()
            ->getColumnFactoryBuilder()
            ->addExtension(new CoreColumnExtension())
        ;
        
        return $reportFactoryBuilder;
    }

    /**
     * @param FormFactoryInterface $formFactory
     * @param EngineInterface $templatingEngine
     * @return ReportFactoryBuilder
     */
    public static function createReportFactoryBuilderWithSymfonyFormFactory(
        FormFactoryInterface $formFactory,
        EngineInterface $templatingEngine = null

    ) {
        $reportFactoryBuilder = self::createReportFactoryBuilder($templatingEngine);
        $reportFactoryBuilder
            ->getRendererFactoryBuilder()
            ->addExtension(new SymfonyRendererExtension($formFactory))
        ;
        return $reportFactoryBuilder;
    }
}
