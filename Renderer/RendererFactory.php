<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\TypeFactory\TypeResolverInterface;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryInterface;
use Yjv\TypeFactory\AbstractTypeFactory;

class RendererFactory extends AbstractTypeFactory implements RendererFactoryInterface
{
    protected $columnFactory;

    public function __construct(TypeResolverInterface $resolver, ColumnFactoryInterface $columnFactory)
    {
        $this->columnFactory = $columnFactory;
        parent::__construct($resolver);
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
