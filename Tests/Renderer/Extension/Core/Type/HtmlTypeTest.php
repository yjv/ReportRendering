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
            ->shouldReceive('setDefaults')
            ->once()
            ->with(
                Mockery::on(
                    function ($value) use ($testCase, $type, $templatingEngine) {
                        $testCase->assertEquals(
                            array(
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
                                'templating_engine' => $templatingEngine,
                                'report_rendering_resources_dir' => dirname(dirname(dirname(dirname(dirname(__DIR__))))).DIRECTORY_SEPARATOR.'Resources'.DIRECTORY_SEPARATOR.'views',
                                'javascripts' => array(),
                                'stylesheets' => array()
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
            ->with(array(
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
            ))
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
            'templating_engine' => $this->templatingEngine,
            'javascripts' => array('key' => 'value'),
            'stylesheets' => array('key2' => 'value2')
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
            ->shouldReceive('setJavascripts')
            ->once()
            ->with($options['javascripts'])
            ->getMock()
            ->shouldReceive('setStylesheets')
            ->once()
            ->with($options['stylesheets'])
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
            'templating_engine' => $this->templatingEngine,
            'javascripts' => array('key' => 'value'),
            'stylesheets' => array('key2' => 'value2')
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
            ->shouldReceive('setJavascripts')
            ->once()
            ->with($options['javascripts'])
            ->getMock()
            ->shouldReceive('setStylesheets')
            ->once()
            ->with($options['stylesheets'])
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
            'templating_engine' => $this->templatingEngine,
            'javascripts' => array('key' => 'value'),
            'stylesheets' => array('key2' => 'value2')
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
            ->shouldReceive('setJavascripts')
            ->once()
            ->with($options['javascripts'])
            ->getMock()
            ->shouldReceive('setStylesheets')
            ->once()
            ->with($options['stylesheets'])
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
            'templating_engine' => $this->templatingEngine,
            'javascripts' => array('key' => 'value'),
            'stylesheets' => array('key2' => 'value2')
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
            ->shouldReceive('setJavascripts')
            ->once()
            ->with($options['javascripts'])
            ->getMock()
            ->shouldReceive('setStylesheets')
            ->once()
            ->with($options['stylesheets'])
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
