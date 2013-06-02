<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\Factory\TypeRegistryInterface;
use Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryInterface;
use Yjv\ReportRendering\Factory\AbstractTypeFactory;

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
        return 'Yjv\ReportRendering\Renderer\RendererBuilderInterface';
    }

    /**
     * 
     */
    public function getColumnFactory()
    {
        return $this->columnFactory;
    }

}
