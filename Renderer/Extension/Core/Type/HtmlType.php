<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Type;

use Symfony\Component\Templating\EngineInterface;
use Yjv\ReportRendering\Renderer\Extension\Core\Builder\HtmlBuilder;
use Symfony\Component\OptionsResolver\Options;
use Yjv\ReportRendering\Renderer\RendererBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yjv\ReportRendering\Renderer\AbstractRendererType;
use Yjv\TypeFactory\TypeFactoryInterface;

class HtmlType extends AbstractRendererType
{
    protected $templatingEngine;

    public function __construct(EngineInterface $templatingEngine)
    {
        $this->templatingEngine = $templatingEngine;
    }

    /**
     * @param RendererBuilderInterface|HtmlBuilder $builder
     * @param array $options
     */
    public function buildRenderer(RendererBuilderInterface $builder, array $options)
    {
        $builder->setTemplatingEngine($options['templating_engine']);
        $builder->setTemplate($options['template']);

        if ($options['filter_form']) {

            $builder->setFilterForm($options['filter_form']);
        }

        if ($options['renderer_options']) {

            $builder->setRendererOptions($options['renderer_options']);
        }

        if ($options['widget_attributes']) {

            $builder->setWidgetAttributes($options['widget_attributes']);
        }

        $builder->setJavascripts($options['javascripts']);
        $builder->setStylesheets($options['stylesheets']);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $type = $this;

        $resolver
            ->setDefaults(array(
                'template' => 'html.html.twig',
                'filter_form' => null,
                'widget_attributes' => array(),
                'data_key' => 'report_filters',
                'filter_uri' => null,
                'paginate' => true,
                'renderer_options' => function (Options $options)
                {
                    return array(
                        'data_key' => $options['data_key'],
                        'filter_uri' => $options['filter_uri'],
                        'paginate' => $options['paginate']
                    );
                },
                'templating_engine' => $this->templatingEngine,
                'report_rendering_resources_dir' => dirname(dirname(dirname(dirname(__DIR__)))).DIRECTORY_SEPARATOR.'Resources'.DIRECTORY_SEPARATOR.'views',
                'javascripts' => array(),
                'stylesheets' => array()
            ))
            ->setAllowedTypes(array(
                'filter_form' => array(
                    'null',
                    'Yjv\ReportRendering\Renderer\Html\Filter\FormInterface'
                ),
                'widget_attributes' => 'array',
                'template' => 'string',
                'data_key' => 'string',
                'filter_uri' => array('null', 'string'),
                'paginate' => 'bool',
                'renderer_options' => 'array',
                'templating_engine' => 'Symfony\Component\Templating\EngineInterface',
                'report_rendering_resources_dir' => 'string',
                'javascripts' => 'array',
                'stylesheets' => 'array',
            ));

    }

    public function getName()
    {
        return 'html';
    }

    public function getParent()
    {
        return 'gridded';
    }

    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
        return new HtmlBuilder($factory, $options);
    }

}
