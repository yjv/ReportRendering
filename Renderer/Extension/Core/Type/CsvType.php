<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Type;

use Yjv\ReportRendering\Renderer\Csv\CsvRenderer;

use Yjv\ReportRendering\Widget\WidgetRenderer;

use Yjv\ReportRendering\Renderer\Html\HtmlRenderer;

use Yjv\ReportRendering\Renderer\RendererBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\ReportRendering\Renderer\AbstractRendererType;

class CsvType extends AbstractRendererType
{
   /**
    * @param OptionsResolverInterface $resolver
    */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {

        $resolver->setDefaults(array(

                'constructor' => function(RendererBuilderInterface $builder) {
            
                    return new CsvRenderer($builder->getGrid());
                }
        ))
        ;
        
    }
    
    public function getName()
    {
        return 'csv';
    }
    
    public function getParent()
    {
        return 'gridded';
    }
}
