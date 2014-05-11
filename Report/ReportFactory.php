<?php
namespace Yjv\ReportRendering\Report;

use Yjv\ReportRendering\BuilderInterfaces;
use Yjv\TypeFactory\NamedTypeFactory;
use Yjv\TypeFactory\TypeFactoryInterface;

use Yjv\TypeFactory\TypeResolverInterface;

use Yjv\ReportRendering\Renderer\RendererFactoryInterface;

class ReportFactory extends NamedTypeFactory implements ReportFactoryInterface
{
    protected $datasourceFactory;
    protected $rendererFactory;

    public function __construct(
        TypeResolverInterface $typeResolver, 
        TypeFactoryInterface $datasourceFactory,
        RendererFactoryInterface $rendererFactory,
        $builderInterfaceName = BuilderInterfaces::REPORT
    ) {
        $this->datasourceFactory = $datasourceFactory;
        $this->rendererFactory = $rendererFactory;
        parent::__construct($typeResolver, $builderInterfaceName);
    }

    public function getDatasourceFactory()
    {
        return $this->datasourceFactory;
    }
    
    /**
     * 
     */
    public function getRendererFactory()
    {
        return $this->rendererFactory;
    }
}
