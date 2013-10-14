<?php
namespace Yjv\ReportRendering\Factory;

interface TypeRegistryInterface extends RegistryExtensionInterface
{
    public function addExtension(RegistryExtensionInterface $extension);
}
