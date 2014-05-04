<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid\Column\Extension\Core\Type;

use Yjv\ReportRendering\DataTransformer\DataTransformerInterface;
use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type\FormatStringType;
use Yjv\ReportRendering\DataTransformer\FormatStringTransformer;
use Mockery;

class FormatStringTypeTest extends TypeTestCase
{
	protected $type;
	
	public function setUp()
    {
		parent::setUp();
		$this->type = new FormatStringType();
	}
	
	public function testGetName()
    {
		$this->assertEquals('format_string', $this->type->getName());
	}
	
	public function testBuildColumnWithNoEscaping()
    {
		$options = array(
	        'format_string' => '{column}', 
	        'required' => true, 
	        'empty_value' => 'empty value',
            'escape_values' => false
		);
        $expectedTransformer = new FormatStringTransformer(
            $options['format_string'],
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
	        'format_string' => '{column}',
	        'required' => true,
	        'empty_value' => 'empty value',
            'escape_values' => true,
            'escape_strategies' => array('column' => 'html')
		);
        $expectedTransformer = new FormatStringTransformer(
            $options['format_string'],
            $options['required'],
            $options['empty_value']
        );
        $expectedTransformer
            ->turnOnEscaping()
            ->setPathStrategies($options['escape_strategies'])
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

	public function testSetDefaultOptions()
    {
		$optionsResolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface')
		    ->shouldReceive('setRequired')
		    ->once()
		    ->with(array('format_string'))
		    ->andReturn(Mockery::self())
		    ->getMock()
		    ->shouldReceive('setDefaults')
		    ->once()
		    ->with(array(
                'required' => true, 
                'empty_value' => '',
                'escape_values' => true,
                'escape_strategies' => array()
            ))
		    ->andReturn(Mockery::self())
		    ->getMock()
		    ->shouldReceive('setAllowedTypes')
		    ->once()
		    ->with(array(
                'format_string' => 'string', 
                'required' => 'bool', 
                'empty_value' => 'string',
                'escape_values' => 'bool',
                'escape_strategies' => 'array'
            ))
		    ->andReturn(Mockery::self())
		    ->getMock()
		;
		
		$this->type->setDefaultOptions($optionsResolver);
	}
}
