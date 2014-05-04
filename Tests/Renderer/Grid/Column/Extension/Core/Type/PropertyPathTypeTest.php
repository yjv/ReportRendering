<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid\Column\Extension\Core\Type;

use Yjv\ReportRendering\Data\DataEscaperInterface;

use Yjv\ReportRendering\DataTransformer\DataTransformerInterface;
use Yjv\ReportRendering\DataTransformer\PropertyPathTransformer;

use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type\PropertyPathType;

use Yjv\ReportRendering\Renderer\Grid\Column\Column;

use Mockery;

class PropertyPathTypeTest extends TypeTestCase
{
	protected $type;
	
	public function setUp()
    {
		parent::setUp();
		$this->type = new PropertyPathType();
	}
	
	public function testGetName()
    {
		$this->assertEquals('property_path', $this->type->getName());
	}


    public function testBuildColumnWithNoEscaping()
    {
        $options = array(
            'path' => 'column',
            'required' => true,
            'empty_value' => 'empty value',
            'escape_value' => false
        );
        $expectedTransformer = new PropertyPathTransformer(
            $options['path'],
            $options['required'],
            $options['empty_value']
        );
        $testCase = $this;
        $this->mockedBuilder
            ->shouldReceive('appendDataTransformer')
            ->once()
            ->with(Mockery::on(function(DataTransformerInterface $transformer) use ($testCase, $expectedTransformer)
            {
                $testCase->assertEquals($expectedTransformer, $transformer);
                return true;
            }))
        ;
        $this->type->buildColumn($this->mockedBuilder, $options);
    }

    public function testBuildColumnWithEscaping()
    {
        $options = array(
            'path' => 'column',
            'required' => true,
            'empty_value' => 'empty value',
            'escape_value' => true,
            'escape_strategy' => 'html'
        );
        $expectedTransformer = new PropertyPathTransformer(
            $options['path'],
            $options['required'],
            $options['empty_value']
        );
        $expectedTransformer
            ->turnOnEscaping()
            ->setPathStrategies(array($options['path'] => $options['escape_strategy']))
        ;
        $testCase = $this;
        $this->mockedBuilder
            ->shouldReceive('appendDataTransformer')
            ->once()
            ->with(Mockery::on(function(DataTransformerInterface $transformer) use ($testCase, $expectedTransformer)
                    {
                        $testCase->assertEquals($expectedTransformer, $transformer);
                        return true;
                    }))
        ;
        $this->type->buildColumn($this->mockedBuilder, $options);
    }
	
	public function testSetDefaultOptions() {
		
		$optionsResolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface')
		    ->shouldReceive('setRequired')
		    ->once()
		    ->with(array('path'))
		    ->andReturn(Mockery::self())
		    ->getMock()
		    ->shouldReceive('setDefaults')
		    ->once()
		    ->with(array(
                'required' => true, 
                'empty_value' => '',
                'escape_value' => true,
                'escape_strategy' => DataEscaperInterface::DEFAULT_STRATEGY,
            ))
		    ->andReturn(Mockery::self())
		    ->getMock()
		    ->shouldReceive('setAllowedTypes')
		    ->once()
		    ->with(array(
                'path' => 'string', 
                'required' => 'bool', 
                'empty_value' => 'string',
                'escape_value' => 'bool',
                'escape_strategy' => 'string'
            ))
		    ->andReturn(Mockery::self())
		    ->getMock()
		;
		
		$this->type->setDefaultOptions($optionsResolver);
	}
}
