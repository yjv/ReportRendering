<?php
namespace Yjv\ReportRendering\Renderer\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\ReportRendering\Renderer\AbstractRendererType;

class HtmlType extends AbstractRendererType
{
    
    /**
    * @param OptionsResolverInterface $resolver
    */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
    // TODO: Auto-generated method stub
    
    }
    
    public function getName()
    {
        return 'html';
    }
}
