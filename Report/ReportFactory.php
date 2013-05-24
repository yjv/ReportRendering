<?php
namespace Yjv\Bundle\ReportRenderingBundle\Report;

use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererFactoryInterface;
use Yjv\Bundle\ReportRenderingBundle\Factory\TypeRegistryInterface;
use Yjv\Bundle\ReportRenderingBundle\Factory\TypeRegistry;
use Yjv\Bundle\ReportRenderingBundle\Factory\AbstractTypeFactory;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportFactory extends AbstractTypeFactory implements ReportFactoryInterface
{
    protected $rendererFactory;

    public function __construct(TypeRegistryInterface $reportTypeRegistry, RendererFactoryInterface $rendererFactory)
    {
        $this->rendererFactory = $rendererFactory;
        parent::__construct($reportTypeRegistry, true);
    }

    public function create($type, array $options = array())
    {
        return $this->createBuilder($type, $options)->getReport();
    }

    public function getBuilderInterfaceName()
    {
        return 'Yjv\Bundle\ReportRenderingBundle\Report\ReportBuilderInterface';
    }

    /**
     * 
     */
    public function getRendererFactory()
    {
        return $this->rendererFactory;
    }

}
