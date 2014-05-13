<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 3/30/14
 * Time: 9:39 PM
 */

namespace Yjv\ReportRendering\Tests\Renderer\Extension\Symfony\Type\Extension;


use Mockery\MockInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Yjv\ReportRendering\Renderer\Extension\Symfony\Type\Extension\SymfonyFormTypeExtension;
use Yjv\ReportRendering\Renderer\Html\Filter\SymfonyForm;

class SymfonyFormTypeExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Yjv\ReportRendering\Renderer\Extension\Symfony\Type\Extension\SymfonyFormTypeExtension */
    protected $typeExtension;
    /** @var MockInterface */
    protected $formFactory;

    public function setUp()
    {
        parent::setUp();
        $this->formFactory = \Mockery::mock('Symfony\Component\Form\FormFactoryInterface');
        $this->typeExtension = new SymfonyFormTypeExtension($this->formFactory);
    }

    public function testBuildFilterForm()
    {
        $fields = array(
            'field1' => array('sfsdfds', array('key1' => 'value1')),
            'field2' => array('sfsdfds', array('key2' => 'value2')),
        );
        $formOptions = array('key' => 'value');

        $options = \Mockery::mock('Symfony\Component\OptionsResolver\Options')
            ->shouldReceive('offsetGet')
            ->once()
            ->with('symfony_form_options')
            ->andReturn($formOptions)
            ->getMock()
            ->shouldReceive('offsetExists')
            ->once()
            ->with('symfony_form_fields')
            ->andReturn(true)
            ->getMock()
            ->shouldReceive('offsetGet')
            ->twice()
            ->with('symfony_form_fields')
            ->andReturn($fields)
            ->getMock()
        ;
        $form = \Mockery::mock('Symfony\Component\Form\FormInterface');
        $builder = \Mockery::mock('Symfony\Component\Form\FormBuilderInterface')
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
        $this->assertSame($form, $this->typeExtension->buildFilterForm($options));
    }

    public function testBuildFilterFormWithoutFormFields()
    {
        $options = \Mockery::mock('Symfony\Component\OptionsResolver\Options')
            ->shouldReceive('offsetExists')
            ->once()
            ->with('symfony_form_fields')
            ->andReturn(false)
            ->getMock()
        ;
        $this->assertNull($this->typeExtension->buildFilterForm($options));
    }

    public function testGetExtendedType()
    {
        $this->assertEquals('html', $this->typeExtension->getExtendedType());
    }

    public function testSetDefaultOptions()
    {
        $testCase = $this;
        $typeExtension = $this->typeExtension;
        $resolver = \Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface')
            ->shouldReceive('setDefaults')
            ->once()
            ->with(
                \Mockery::on(
                    function ($value) use ($testCase, $typeExtension) {
                        $testCase->assertEquals(
                            array(
                                'filter_form' => function(Options $options)
                                    {
                                    },
                                'symfony_form' => function (Options $options) use ($typeExtension)
                                    {
                                    },
                                'symfony_form_fields' => array(),
                                'symfony_form_options' => array()
                            ),
                            $value
                        );
                        return true;
                    }
                )
            )
            ->andReturn(\Mockery::self())
            ->getMock()
            ->shouldReceive('setAllowedTypes')
            ->once()
            ->with(array(
                'symfony_form' => array(
                    'null',
                    'Symfony\Component\Form\FormInterface'
                ),
                'symfony_form_fields' => 'array',
                'symfony_form_options' => 'array'
            ))
            ->andReturn(\Mockery::self())
            ->getMock()
            ->shouldReceive('setNormalizers')
            ->once()
            ->with(
                \Mockery::on(
                    function ($value) use ($testCase, $typeExtension) {
                        $testCase->assertEquals(
                            array(
                                'symfony_form_fields' => function (Options $options, $filterFields)
                                {
                                }
                            ),
                            $value
                        );
                        return true;
                    }
                )
            )
            ->andReturn(\Mockery::self())
            ->getMock()
        ;
        $this->typeExtension->setDefaultOptions($resolver);
    }

    public function testFilterFormWhenNoSymfonyFormSet()
    {
        $resolver = new OptionsResolver();
        $this->typeExtension->setDefaultOptions($resolver);
        $options = $resolver->resolve();
        $this->assertNull($options['filter_form']);
    }

    public function testFilterFormWhenSymfonyFormSet()
    {
        $resolver = new OptionsResolver();
        $this->typeExtension->setDefaultOptions($resolver);
        $form = \Mockery::mock('Symfony\Component\Form\FormInterface');
        $options = $resolver->resolve(array('symfony_form' => $form));
        $this->assertEquals(new SymfonyForm($form), $options['filter_form']);
    }
}
 