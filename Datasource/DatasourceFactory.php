<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\ReportRendering\BuilderInterfaces;
use Yjv\TypeFactory\TypeFactory;

use Yjv\TypeFactory\TypeResolverInterface;

class DatasourceFactory extends TypeFactory
{
    public function __construct(
        TypeResolverInterface $typeResolver,
        $builderInterfaceName = BuilderInterfaces::DATASOURCE
    ) {
        parent::__construct(
            $typeResolver,
            $builderInterfaceName
        );
    }
}
