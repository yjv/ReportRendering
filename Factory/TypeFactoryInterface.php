<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

interface TypeFactoryInterface
{
    public function create($type, array $options = array());
    public function createBuilder($type, array $options = array());
    public function getTypeChain($type);
    public function getTypeRegistry();
    public function getBuilderInterfaceName();
}
