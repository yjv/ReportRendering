<?php
namespace Yjv\ReportRendering\Factory;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractType implements TypeInterface
{
    public function getParent()
    {
        return false;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }

    public function getOptionsResolver()
    {
        return new OptionsResolver();
    }
}
