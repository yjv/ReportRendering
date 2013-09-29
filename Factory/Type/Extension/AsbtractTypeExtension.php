<?php
namespace Yjv\ReportRendering\Factory\Type\Extension;

use Yjv\ReportRendering\Factory\BuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\ReportRendering\Factory\TypeExtensionInterface;

abstract class AbstractTypeExtension implements TypeExtensionInterface
{
    public function build(BuilderInterface $builder, array $options)
    {
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }
}

