<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\BuilderInterfaces;
use Yjv\TypeFactory\TypeFactoryInterface;
use Yjv\TypeFactory\TypeResolverInterface;
use Yjv\TypeFactory\TypeFactory;

class RendererFactory extends TypeFactory implements RendererFactoryInterface
{
    protected $columnFactory;

    public function __construct(
        TypeResolverInterface $resolver,
        TypeFactoryInterface $columnFactory,
        $builderInterfaceName = BuilderInterfaces::RENDERER
    ) {
        $this->columnFactory = $columnFactory;
        parent::__construct($resolver, $builderInterfaceName);
    }

    /**
     * 
     */
    public function getColumnFactory()
    {
        return $this->columnFactory;
    }
}
