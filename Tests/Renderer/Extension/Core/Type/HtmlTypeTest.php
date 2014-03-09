<?php
namespace Yjv\ReportRendering\Tests\Renderer\Extension\Core;

use Symfony\Component\OptionsResolver\Options;
use Yjv\ReportRendering\Renderer\Extension\Core\Builder\HtmlBuilder;
use Yjv\ReportRendering\Util\Factory;
use Yjv\ReportRendering\Renderer\Extension\Core\Type\HtmlType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Yjv\ReportRendering\Tests\Renderer\Extension\Core\Type\TypeTestCase;
use Mockery;

/**
 * Class HtmlTypeTest
 * @package Yjv\ReportRendering\Tests\Renderer\Extension\Core
 *
 * @property HtmlType $type
 */
class HtmlTypeTest extends TypeTestCase
{
    protected $formFactory;
    protected $templatingEngine;

    public function setUp()
    {
        parent::setUp();
        $this->templatingEngine = Mockery::mock('Symfony\Component\Templating\EngineInterface');
        $this->formFactory = Mockery::mock('Symfony\Component\Form\FormFactoryInterface');
        $this->type = new HtmlType($this->templatingEngine, $this->formFactory);
    }


    public function testSetDefaultOptions()
    {
        $testCase = $this;
        $type = $this->type;
        $templatingEngine = $this->templatingEngine;

        $resolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface')
            ->shouldReceive('setRequired')
            ->once()
            ->with(array('template'))
            ->andReturn(Mockery::self())
            ->getMock()
            ->shouldReceive('setDefaults')
            ->once()
            ->with(
                Mockery::on(
                    function ($value) use ($testCase, $type, $templatingEngine) {
                        $testCase->assertEquals(
                            array(
                                'filter_form' => function (Options $options) use ($type, $templatingEngine) {
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
                                },
                                'templating_engine' => $templatingEngine
                            ),
                            $value
                        );
                        return true;
                    }
                )
            )
            ->andReturn(Mockery::self())
            ->getMock()
            ->shouldReceive('setAllowedTypes')
            ->once()
            ->with(
                array(
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
                    'renderer_options' => 'array',
                    'templating_engine' => 'Symfony\Component\Templating\EngineInterface'
                )
            )
            ->andReturn(Mockery::self())
            ->getMock()
            ->shouldReceive('setNormalizers')
            ->once()
            ->with(
                Mockery::on(
                    function ($value) use ($testCase) {
                        $testCase->assertEquals(
                            array(
                                'filter_fields' => function (Options $options, $filterFields)
                                {
                                    return Factory::normalizeCollectionToFactoryArguments($filterFields);
                                }
                            ),
                            $value
                        );
                        return true;
                    }
                )
            )
            ->andReturn(Mockery::self())
            ->getMock();
        $this->type->setDefaultOptions($resolver);
    }

    public function testOptionsDefaulting()
    {
        $resolver = new OptionsResolver();
        $this->type->setDefaultOptions($resolver);
        $options = $resolver->resolve(array('template' => 'template'));
        $this->assertEquals(
            array(
                'data_key' => $options['data_key'],
                'filter_uri' => $options['filter_uri'],
                'paginate' => true
            ),
            $options['renderer_options']
        );
        $this->assertSame($this->templatingEngine, $options['templating_engine']);
    }

    public function testBuildFilterForm()
    {
        $fields = array(
            'field1' => array('sfsdfds', array('key1' => 'value1')),
            'field2' => array('sfsdfds', array('key2' => 'value2')),
        );
        $formOptions = array('key' => 'value');

        $options = Mockery::mock('Symfony\Component\OptionsResolver\Options')
            ->shouldReceive('offsetGet')
            ->once()
            ->with('filter_form_options')
            ->andReturn($formOptions)
            ->getMock()
            ->shouldReceive('offsetExists')
            ->once()
            ->with('filter_fields')
            ->andReturn(true)
            ->getMock()
            ->shouldReceive('offsetGet')
            ->twice()
            ->with('filter_fields')
            ->andReturn($fields)
            ->getMock()
        ;
        $form = Mockery::mock('Symfony\Component\Form\FormInterface');
        $builder = Mockery::mock('Symfony\Component\Form\FormBuilderInterface')
            ->shouldReceive('add')
            ->once()
            ->with('field1', $fields['field1'][0], $fields['field1'][1])
            ->getMock()
            ->shouldReceive('add')
            ->once()
            ->with('field2', $fields['field2'][0], $fields['field2'][1])
            ->getMock()
            ->shouldReceive('getForm')
            ->once()
            ->andReturn($form)
            ->getMock();
        $this->formFactory
            ->shouldReceive('createBuilder')
            ->once()
            ->with('form', null, $formOptions)
            ->andReturn($builder);
        $this->assertSame($form, $this->type->buildFilterForm($options));
    }

    public function testBuildFilterFormWithNoFormFactory()
    {
        $type = new HtmlType($this->templatingEngine);
        $this->assertNull($type->buildFilterForm(Mockery::mock('Symfony\Component\OptionsResolver\Options')));
    }

    public function testBuildFilterFormWithoutFormFields()
    {
        $options = Mockery::mock('Symfony\Component\OptionsResolver\Options')
            ->shouldReceive('offsetExists')
            ->once()
            ->with('filter_fields')
            ->andReturn(false)
            ->getMock();
        $this->assertNull($this->type->buildFilterForm($options));
    }

    public function testGetName()
    {
        $this->assertEquals('html', $this->type->getName());
    }

    public function testGetParent()
    {
        $this->assertEquals('gridded', $this->type->getParent());
    }

    public function testBuildRendererWithEverythingEmpty()
    {
        $options = array(
            'filter_form' => null,
            'renderer_options' => array(),
            'widget_attributes' => array(),
            'template' => 'wrewer',
            'templating_engine' => $this->templatingEngine
        );
        $builder = Mockery::mock('Yjv\ReportRendering\Renderer\RendererBuilderInterface')
            ->shouldReceive('setTemplate')
            ->once()
            ->with($options['template'])
            ->getMock()
            ->shouldReceive('setTemplatingEngine')
            ->once()
            ->with($options['templating_engine'])
            ->getMock()
        ;
        $this->type->buildRenderer($builder, $options);
    }

    public function testBuildRendererWithFilterFormNotEmpty()
    {
        $options = array(
            'filter_form' => Mockery::mock('Symfony\Component\Form\FormInterface'),
            'renderer_options' => array(),
            'widget_attributes' => array(),
            'template' => 'wrewer',
            'templating_engine' => $this->templatingEngine
        );
        $builder = Mockery::mock('Yjv\ReportRendering\Renderer\RendererBuilderInterface')
            ->shouldReceive('setTemplate')
            ->once()
            ->with($options['template'])
            ->getMock()
            ->shouldReceive('setFilterForm')
            ->once()
            ->with($options['filter_form'])
            ->getMock()
            ->shouldReceive('setTemplatingEngine')
            ->once()
            ->with($options['templating_engine'])
            ->getMock()
        ;
        $this->type->buildRenderer($builder, $options);
    }

    public function testBuildRendererWithRendererOptionsNotEmpty()
    {
        $options = array(
            'filter_form' => null,
            'renderer_options' => array('key' => 'value'),
            'widget_attributes' => array(),
            'template' => 'wrewer',
            'templating_engine' => $this->templatingEngine
        );
        $builder = Mockery::mock('Yjv\ReportRendering\Renderer\RendererBuilderInterface')
            ->shouldReceive('setTemplate')
            ->once()
            ->with($options['template'])
            ->getMock()
            ->shouldReceive('setRendererOptions')
            ->once()
            ->with($options['renderer_options'])
            ->getMock()
            ->shouldReceive('setTemplatingEngine')
            ->once()
            ->with($options['templating_engine'])
            ->getMock()
        ;
        $this->type->buildRenderer($builder, $options);
    }

    public function testBuildRendererWithWidgetAttributesNotEmpty()
    {
        $options = array(
            'filter_form' => null,
            'renderer_options' => array(),
            'widget_attributes' => array('key' => 'value'),
            'template' => 'wrewer',
            'templating_engine' => $this->templatingEngine
        );
        $builder = Mockery::mock('Yjv\ReportRendering\Renderer\RendererBuilderInterface')
            ->shouldReceive('setTemplate')
            ->once()
            ->with($options['template'])
            ->getMock()
            ->shouldReceive('setWidgetAttributes')
            ->once()
            ->with($options['widget_attributes'])
            ->getMock()
            ->shouldReceive('setTemplatingEngine')
            ->once()
            ->with($options['templating_engine'])
            ->getMock()
        ;
        $this->type->buildRenderer($builder, $options);
    }

    public function testCreateBuilder()
    {
        $factory = Mockery::mock('Yjv\TypeFactory\TypeFactoryInterface');
        $options = array('key' => 'value');
        $this->assertEquals(
            new HtmlBuilder($factory, $options),
            $this->type->createBuilder($factory, $options)
        );
    }
}
