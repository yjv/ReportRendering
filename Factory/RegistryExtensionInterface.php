<?php
namespace Yjv\ReportRendering\Factory;

interface RegistryExtensionInterface
{
    public function hasType($name);
    public function getType($name);
    public function hasTypeExtensions($name);
    public function getTypeExtensions($name);
}
