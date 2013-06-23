<?php
namespace Yjv\ReportRendering\Tests\Renderer\Extension\Core;

use Yjv\ReportRendering\Renderer\Extension\Core\Type\CsvType;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Yjv\ReportRendering\Tests\Renderer\Extension\Core\Type\TypeTestCase;

use Mockery;

class CsvTypeTest extends TypeTestCase
{
    protected $widgetRenderer;
    protected $formFactory;
    
    public function setUp()
    {
        parent::setUp();
        $this->type = new CsvType();
    }
    
    public function testSetDefaultOptions()
    {
        $testCase = $this;
        
        $resolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface')
            ->shouldReceive('setDefaults')
            ->once()
            ->with(Mockery::on(function($value) use ($testCase) 
            {
                $testCase->assertEquals(array(

                    'constructor' => function(RendererBuilderInterface $builder) {
                
                        return new CsvRenderer($builder->getGrid());
                    }
                ), $value);
                return true;
            }))
            ->getMock()
        ;
        $this->type->setDefaultOptions($resolver);
    }
    
    public function testResolvingOfConstructor()
    {
        $resolver = new OptionsResolver();
        $this->type->setDefaultOptions($resolver);
        $options = $resolver->resolve();
        $builder = Mockery::mock('Yjv\ReportRendering\Renderer\RendererBuilderInterface')
            ->shouldReceive('getGrid')
            ->once()
            ->andReturn(Mockery::mock('Yjv\ReportRendering\Renderer\Grid\GridInterface'))
            ->getMock()
        ;
        $this->assertInstanceOf('Yjv\ReportRendering\Renderer\Csv\CsvRenderer', $options['constructor']($builder));
    }
        
    public function testGetName()
    {
        $this->assertEquals('csv', $this->type->getName());
    }
    
    public function testGetParent()
    {
        $this->assertEquals('gridded', $this->type->getParent());
    }
}
