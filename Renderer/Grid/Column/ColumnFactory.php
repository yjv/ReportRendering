<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column;


use Yjv\ReportRendering\BuilderInterfaces;
use Yjv\TypeFactory\TypeResolverInterface;
use Yjv\TypeFactory\TypeFactory;

class ColumnFactory extends TypeFactory
{
    public function __construct(
        TypeResolverInterface $typeResolver,
        $builderInterfaceName = BuilderInterfaces::COLUMN
    ) {
        parent::__construct(
            $typeResolver,
            $builderInterfaceName
        );
    }
}
