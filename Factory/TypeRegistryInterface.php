<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

interface TypeRegistryInterface
{
    public function getType($name);
    public function hasType($name);
    public function getTypeExtensions($name);
    public function hasTypeExtensions($name);
}
