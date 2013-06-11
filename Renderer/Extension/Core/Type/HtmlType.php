<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Type;

use Yjv\ReportRendering\Widget\WidgetRenderer;

use Yjv\ReportRendering\Renderer\Html\HtmlRenderer;

use Yjv\ReportRendering\Renderer\RendererBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\ReportRendering\Renderer\AbstractRendererType;

class HtmlType extends AbstractRendererType
{
   protected $widgetRenderer;
   
   public function __construct(WidgetRenderer $widgetRenderer)
   {
       $this->widgetRenderer = $widgetRenderer;
   }
   
   /**
    * @param RendererBuilderInterface $builder
    * @param array $options
    */
    public function buildRenderer(RendererBuilderInterface $builder, array $options) {

        $widgetRenderer = $this->widgetRenderer;
        
        $builder->setConstructor(function(RendererBuilderInterface $builder) use ($widgetRenderer){
            
            $renderer =  new HtmlRenderer(
                $widgetRenderer, 
                $builder->getGrid(), 
                $builder->getOption('template')
            );
            
            foreach ($builder->getOption('widget_attributes') as $name => $value) {
                
                $renderer->setAttribute($name, $value);
            }
            
            if ($builder->getOption('filter_form')) {
                
                $renderer->setFilterForm($builder->getOption('filter_form'));
            }
            
            return $renderer;
        });
    }

   /**
    * @param OptionsResolverInterface $resolver
    */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {

        $resolver->setDefaults(array(

                'filter_form' => null,
                'widget_attributes' => array()
        ))
        ->setAllowedTypes(array(
            'filter_form' => array(
                'null', 
                'Symfony\Component\Form\FormInterface'
            ),
            'widget_attributes' => 'array'
        ))
        ;
    }
    
    public function getName()
    {
        return 'html';
    }
    
    public function getParent()
    {
        return 'gridded';
    }
}
