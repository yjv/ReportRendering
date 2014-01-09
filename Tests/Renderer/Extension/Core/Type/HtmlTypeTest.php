<?php
namespace Yjv\ReportRendering\Tests\Renderer\Extension\Core;

use Yjv\ReportRendering\Renderer\Html\HtmlRenderer;

use Yjv\ReportRendering\Util\Factory;

use Yjv\ReportRendering\Renderer\Extension\Core\Type\HtmlType;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Yjv\ReportRendering\Tests\Renderer\Extension\Core\Type\TypeTestCase;

use Mockery;

class HtmlTypeTest extends TypeTestCase
{
    protected $formFactory;
    protected $renderer;
    
    public function setUp()
    {
        parent::setUp();
        $this->renderer = Mockery::mock('Symfony\Component\Templating\EngineInterface');
        $this->formFactory = Mockery::mock('Symfony\Component\Form\FormFactoryInterface');
        $this->type = new HtmlType($this->renderer, $this->formFactory);
    }
    
    public function testSetDefaultOptions()
    {
        $testCase = $this;
        $type = $this->type;
        
        $resolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface')
            ->shouldReceive('setRequired')
            ->once()
            ->with(array('template'))
            ->andReturn(Mockery::self())
            ->getMock()
            ->shouldReceive('setDefaults')
            ->once()
            ->with(Mockery::on(function($value) use ($testCase, $type) 
            {
                $testCase->assertEquals(array(
        
                    'filter_form' => function(Options $options) use ($type) {
                        
                        return $type->buildFilterForm($options);
                    },
                    'renderer_attributes' => array(),
                    'constructor' => array($type, 'rendererConstructor'),
                    'filter_fields' => array(),
                    'filter_form_options' => array('csrf_protection' => false),
                    'data_key' => 'report_filters',
                    'filter_uri' => null,
                    'paginate' => true,
                    'options' => function(Options $options) {
                        
                        return array(
                            'data_key' => $options['data_key'], 
                            'filter_uri' => $options['filter_uri'],
                            'paginate' => $options['paginate']
                        );
                    }
                ), $value);
                return true;
            }))
            ->andReturn(Mockery::self())
            ->getMock()
            ->shouldReceive('setAllowedTypes')
            ->once()
            ->with(array(
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
            ->andReturn(Mockery::self())
            ->getMock()
            ->shouldReceive('setNormalizers')
            ->once()
            ->with(Mockery::on(function($value) use ($testCase) 
            {
                $testCase->assertEquals(array(
                    'filter_fields' => function(Options $options, $filterFields)
                    {
                        return Factory::normalizeCollectionToFactoryArguments($filterFields);
                    }
                ), $value);
                return true;
            }))
            ->andReturn(Mockery::self())
            ->getMock()
        ;
        $this->type->setDefaultOptions($resolver);
    }
    
    public function testRendererConstructor()
    {
        $grid = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\GridInterface');
        $form = Mockery::mock('Symfony\Component\Form\FormInterface');
        $attributes = array('key' => 'value');
        $expectedRenderer = new HtmlRenderer($this->renderer, $grid, 'template');
        $expectedRenderer->setAttribute('key', 'value');
        $expectedRenderer->setOption('option_name', 'value');
        $expectedRenderer->setFilterForm($form);
        $builder = Mockery::mock('Yjv\ReportRendering\Renderer\RendererBuilderInterface')
            ->shouldReceive('getGrid')
            ->once()
            ->andReturn($grid)
            ->getMock()
            ->shouldReceive('getOption')
            ->once()
            ->with('template')
            ->andReturn('template')
            ->getMock()
            ->shouldReceive('getOption')
            ->twice()
            ->with('filter_form')
            ->andReturn($form)
            ->getMock()
            ->shouldReceive('getOption')
            ->once()
            ->with('renderer_attributes')
            ->andReturn($attributes)
            ->getMock()
            ->shouldReceive('getOption')
            ->once()
            ->with('options')
            ->andReturn(array('option_name' => 'value'))
            ->getMock()
        ;
        $this->assertEquals($expectedRenderer, $this->type->rendererConstructor($builder));
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
            $options['options']
        );
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
            ->getMock()
        ;
        $this->formFactory
            ->shouldReceive('createBuilder')
            ->once()
            ->with('form', null, $formOptions)
            ->andReturn($builder)
        ;
        $this->assertSame($form, $this->type->buildFilterForm($options));
    }
    
    public function testBuildFilterFormWithNoFormFactory()
    {
        $type = new HtmlType($this->renderer);
        $this->assertNull($type->buildFilterForm(Mockery::mock('Symfony\Component\OptionsResolver\Options')));
    }
    
    public function testBuildFilterFormWithoutFormFields()
    {
        $options = Mockery::mock('Symfony\Component\OptionsResolver\Options')
            ->shouldReceive('offsetExists')
            ->once()
            ->with('filter_fields')
            ->andReturn(false)
            ->getMock()
        ;
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
}
