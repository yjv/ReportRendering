<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Type;

use Symfony\Component\Templating\EngineInterface;

use Yjv\ReportRendering\Util\Factory;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\Form\FormFactoryInterface;

use Yjv\ReportRendering\Renderer\Html\HtmlRenderer;

use Yjv\ReportRendering\Renderer\RendererBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\ReportRendering\Renderer\AbstractRendererType;

class HtmlType extends AbstractRendererType
{
   protected $renderer;
   protected $formFactory;
   
   public function __construct(EngineInterface $renderer, FormFactoryInterface $formFactory = null)
   {
       $this->renderer = $renderer;
       $this->formFactory = $formFactory;
   }

   /**
    * @param OptionsResolverInterface $resolver
    */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $type = $this;
        
        $resolver
            ->setRequired(array('template'))
            ->setDefaults(array(
    
                'filter_form' => function(Options $options) use ($type)
                {
                    //@codeCoverageIgnoreStart
                    return $type->buildFilterForm($options);
                    //@codeCoverageIgnoreEnd
                },
                'renderer_attributes' => array(),
                'constructor' => array($this, 'rendererConstructor'),
                'filter_fields' => array(),
                'filter_form_options' => array('csrf_protection' => false),
                'data_key' => 'report_filters',
                'filter_uri' => null,
                'paginate' => true,
                'options' => function(Options $options)
                {
                    return array(
                        'data_key' => $options['data_key'], 
                        'filter_uri' => $options['filter_uri'],
                        'paginate' => $options['paginate']
                    );
                }
            ))
            ->setAllowedTypes(array(
                'filter_form' => array(
                    'null', 
                    'Symfony\Component\Form\FormInterface'
                ),
                'renderer_attributes' => 'array',
                'template' => 'string',
                'filter_fields' => 'array',
                'filter_form_options' => 'array',
                'data_key' => 'string',
                'filter_uri' => array('null', 'string'),
                'paginate' => 'bool',
                'options' => 'array'
            ))
            ->setNormalizers(array(
                'filter_fields' => function(Options $options, $filterFields)
                {
                    //@codeCoverageIgnoreStart
                    return Factory::normalizeCollectionToFactoryArguments($filterFields);
                    //@codeCoverageIgnoreEnd
                }
            ))
        ;
        
    }
    
    public function rendererConstructor(RendererBuilderInterface $builder)
    {
        $renderer =  new HtmlRenderer(
            $this->renderer, 
            $builder->getGrid(), 
            $builder->getOption('template')
        );
        
        foreach ($builder->getOption('renderer_attributes') as $name => $value) {
            
            $renderer->setAttribute($name, $value);
        }
        
        if ($builder->getOption('filter_form')) {
            
            $renderer->setFilterForm($builder->getOption('filter_form'));
        }
        
        foreach ($builder->getOption('options') as $name => $value) {
            
            $renderer->setOption($name, $value);
        }
        
        return $renderer;
    }
    
    public function buildFilterForm(Options $options)
    {
        if (!$this->formFactory || empty($options['filter_fields'])) {
                    
            return null;
        }
        
        $builder = $this->formFactory->createBuilder('form', null, $options['filter_form_options']);
        
        foreach ($options['filter_fields'] as $name => $fieldOptions) {
            
            $builder->add($name, $fieldOptions[0], $fieldOptions[1]);
        }
        
        return $builder->getForm();
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
