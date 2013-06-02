<?php
namespace Yjv\ReportRendering\Factory;

interface TypeResolverInterface
{
    public function resolveTypeChain($type);
    public function resolveType($type);
    public function getTypeRegistry();
}
