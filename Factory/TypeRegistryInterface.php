<?php
namespace Yjv\ReportRendering\Factory;

interface TypeRegistryInterface
{
    public function getType($name);
    public function hasType($name);
    public function getTypeExtensions($name);
    public function hasTypeExtensions($name);
}
