<?php
namespace Yjv\ReportRendering\Factory\Type\Extension;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DefaultOptionsTypeExtension extends AbstractTypeExtension
{
    protected $extendedType;
    protected $defaults;
    
    public function __construct($extendedType, array $defaults)
    {
        $this->extendedType = $extendedType;
        $this->defaults = $defaults;
    }
    
    public function getExtendedType()
    {
        return $this->extendedType;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults($this->defaults);
    }
}