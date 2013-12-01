<?php
namespace Yjv\ReportRendering\Report;

use Yjv\TypeFactory\TypeFactoryInterface;

use Yjv\TypeFactory\TypeResolverInterface;

use Yjv\ReportRendering\Renderer\RendererFactoryInterface;
use Yjv\TypeFactory\AbstractTypeFactory;

class ReportFactory extends AbstractTypeFactory implements ReportFactoryInterface
{
    protected $datasourceFactory;
    protected $rendererFactory;

    public function __construct(
        TypeResolverInterface $typeResolver, 
        TypeFactoryInterface $datasourceFactory,
        RendererFactoryInterface $rendererFactory
    ) {
        $this->datasourceFactory = $datasourceFactory;
        $this->rendererFactory = $rendererFactory;
        parent::__construct($typeResolver);
    }

    public function create($type, array $options = array())
    {
        return $this->createBuilder($type, $options)->getReport();
    }

    public function getBuilderInterfaceName()
    {
        return 'Yjv\ReportRendering\Report\ReportBuilderInterface';
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
