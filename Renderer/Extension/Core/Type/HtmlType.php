<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Type;

use Symfony\Component\Templating\EngineInterface;

use Yjv\ReportRendering\Renderer\Extension\Core\Builder\HtmlBuilder;
use Yjv\ReportRendering\Util\Factory;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\Form\FormFactoryInterface;
use Yjv\ReportRendering\Renderer\RendererBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yjv\ReportRendering\Renderer\AbstractRendererType;
use Yjv\TypeFactory\TypeFactoryInterface;

class HtmlType extends AbstractRendererType
{
    protected $templatingEngine;
    protected $formFactory;

    public function __construct(EngineInterface $templatingEngine, FormFactoryInterface $formFactory = null)
    {
        $this->templatingEngine = $templatingEngine;
        $this->formFactory = $formFactory;
    }

    /**
     * @param \Yjv\ReportRendering\Renderer\RendererBuilderInterface $builder
     * @param array $options
     */
    public function buildRenderer(RendererBuilderInterface $builder, array $options)
    {
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
                'filter_form' => function (Options $options) use ($type)
                {
                    //@codeCoverageIgnoreStart
                    return $type->buildFilterForm($options);
                    //@codeCoverageIgnoreEnd
                },
                'widget_attributes' => array(),
                'filter_fields' => array(),
                'filter_form_options' => array('csrf_protection' => false),
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
                }
            ))
            ->setAllowedTypes(array(
                'filter_form' => array(
                    'null',
                    'Symfony\Component\Form\FormInterface'
                ),
                'widget_attributes' => 'array',
                'template' => 'string',
                'filter_fields' => 'array',
                'filter_form_options' => 'array',
                'data_key' => 'string',
                'filter_uri' => array('null', 'string'),
                'paginate' => 'bool',
                'renderer_options' => 'array'
            ))
            ->setNormalizers(array(
                'filter_fields' => function (Options $options, $filterFields)
                {
                    //@codeCoverageIgnoreStart
                    return Factory::normalizeCollectionToFactoryArguments($filterFields);
                    //@codeCoverageIgnoreEnd
                }
            ));

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

    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
        return new HtmlBuilder($this->templatingEngine, $factory, $options);
    }

}
