<?php
namespace Yjv\ReportRendering\Factory\Type\Extension;

use Yjv\ReportRendering\Factory\BuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\ReportRendering\Factory\TypeExtensionInterface;

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