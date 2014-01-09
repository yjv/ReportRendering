<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid\Column\Extension\Core\Type;

use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type\FormatStringType;

use Yjv\ReportRendering\DataTransformer\FormatStringTransformer;

use Yjv\ReportRendering\Data\DataEscaperInterface;

use Yjv\ReportRendering\DataTransformer\PropertyPathTransformer;

use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type\PropertyPathType;

use Yjv\ReportRendering\Renderer\Grid\Column\Column;

use Mockery;

class FormatStringTypeTest extends TypeTestCase{

	protected $type;
	
	protected function setUp() {

		parent::setUp();
		$this->dataTransformerRegistry->set('format_string', new FormatStringTransformer());
		$this->type = new FormatStringType();
	}
	
	public function testGetName() {
		
		$this->assertEquals('format_string', $this->type->getName());
	}
	
	public function testBuildColumn(){
		
		$options = array(
	        'format_string' => '{column}', 
	        'required' => true, 
	        'empty_value' => '', 
	        'ignored_option' => 'ignored',
            'escape_values' => true,
            'escape_strategies' => array('column' => 'html')
		);
		$this->type->buildColumn($this->builder, $options);
		$column = $this->builder->getColumn();
		$dataTransformers = $column->getDataTransformers();
		$this->assertCount(1, $dataTransformers);
		$transformer = $dataTransformers[0];
		$this->assertInstanceOf('Yjv\ReportRendering\DataTransformer\FormatStringTransformer', $transformer);
		$this->assertEquals('{column}', $transformer->getConfig()->get('format_string'));
		$this->assertEquals(true, $transformer->getConfig()->get('required'));
		$this->assertEquals('', $transformer->getConfig()->get('empty_value'));
		$this->assertEquals(true, $transformer->getConfig()->get('escape_values'));
		$this->assertEquals(array('column' => 'html'), $transformer->getConfig()->get('escape_strategies'));
	}
	
	public function testSetDefaultOptions() {
		
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
