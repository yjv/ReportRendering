<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeRegistryInterface;
use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnFactoryInterface;
use Yjv\Bundle\ReportRenderingBundle\Factory\AbstractTypeFactory;

class RendererFactory extends AbstractTypeFactory implements RendererFactoryInterface
{
    protected $columnFactory;

    public function __construct(TypeRegistryInterface $registry, ColumnFactoryInterface $columnFactory)
    {
        $this->columnFactory = $columnFactory;
        parent::__construct($registry);
    }

    public function create($type, array $options = array())
    {
        return $this->createBuilder($type, $options)->getRenderer();
    }

    public function getBuilderInterfaceName()
    {
        return 'Yjv\Bundle\ReportRenderingBundle\Renderer\RendererBuilderInterface';
    }

    /**
     * 
     */
    public function getColumnFactory()
    {
        return $this->columnFactory;
    }

}
