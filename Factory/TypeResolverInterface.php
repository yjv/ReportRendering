<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

interface TypeResolverInterface
{
    public function resolveTypeChain($type);
    public function resolveType($type);
    public function getTypeRegistry();
}
