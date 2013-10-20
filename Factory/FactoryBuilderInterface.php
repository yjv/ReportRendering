<?php
namespace Yjv\ReportRendering\Factory;

use Yjv\ReportRendering\Factory\TypeResolverInterface;

use Yjv\ReportRendering\Factory\TypeRegistryInterface;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

interface FactoryBuilderInterface
{
    public function addExtension(RegistryExtensionInterface $extension);
    public function setTypeRegistry(TypeRegistryInterface $typeRegistry);
    public function getTypeRegistry();
    public function setTypeResolver(TypeResolverInterface $typeResolver);
    public function getTypeResolver();
    public function setTypeName($typeName);
    public function getTypeName();
    public function build();
}
