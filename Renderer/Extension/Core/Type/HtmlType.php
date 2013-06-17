<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Type;

use Yjv\ReportRendering\Util\Factory;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\FormFactoryInterface;

use Yjv\ReportRendering\Widget\WidgetRenderer;

use Yjv\ReportRendering\Renderer\Html\HtmlRenderer;

use Yjv\ReportRendering\Renderer\RendererBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\ReportRendering\Renderer\AbstractRendererType;

class HtmlType extends AbstractRendererType
{
   protected $widgetRenderer;
   protected $formFactory;
   
   public function __construct(WidgetRenderer $widgetRenderer, FormFactoryInterface $formFactory = null)
   {
       $this->widgetRenderer = $widgetRenderer;
       $this->formFactory = $formFactory;
   }

   /**
    * @param OptionsResolverInterface $resolver
    */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {

        $formFactory = $this->formFactory;
        
        $resolver->setDefaults(array(

            'template' => null,
            'filter_form' => function(Options $options) use ($formFactory) {
                
                if (!$formFactory) {
                    
                    return null;
                }
                
                $builder = $formFactory->createBuilder('form', null, $options['filter_form_options']);
                
                foreach ($options['filter_fields'] as $name => $options) {
                    
                    $builder->add($name, $options[0], $options[1]);
                }
                
                return $builder->getForm();
            },
            'widget_attributes' => array(),
            'constructor' => array($this, 'rendererConstructor'),
            'filter_fields' => array(),
            'filter_form_options' => array('csrf_protection' => false)
        ))
        ->setAllowedTypes(array(
            'filter_form' => array(
                'null', 
                'Symfony\Component\Form\FormInterface'
            ),
            'widget_attributes' => 'array',
            'template' => 'string',
            'filter_fields' => 'array'
        ))
        ->setNormalizers(array(
            'filter_fields' => function(Options $options, $filterFields)
            {
                return Factory::normalizeOptionsCollectionToFactoryArguments($options, $filterFields);
            }
        ))
        ;
        
    }
    
    public function rendererConstructor(RendererBuilderInterface $builder)
    {
        $renderer =  new HtmlRenderer(
            $this->widgetRenderer, 
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
