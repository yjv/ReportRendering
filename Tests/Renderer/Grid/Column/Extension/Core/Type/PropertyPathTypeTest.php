<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid\Column\Extension\Core\Type;

use Yjv\ReportRendering\Data\DataEscaperInterface;

use Yjv\ReportRendering\DataTransformer\PropertyPathTransformer;

use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type\PropertyPathType;

use Yjv\ReportRendering\Renderer\Grid\Column\Column;

use Mockery;

class PropertyPathTypeTest extends TypeTestCase{

	protected $type;
	
	protected function setUp() {

		parent::setUp();
		$this->dataTransformerRegistry->set('property_path', new PropertyPathTransformer());
		$this->type = new PropertyPathType();
	}
	
	public function testGetName() {
		
		$this->assertEquals('property_path', $this->type->getName());
	}
	
	public function testBuildColumn(){
		
		$options = array(
	        'path' => 'column', 
	        'required' => true, 
	        'empty_value' => '', 
	        'ignored_option' => 'ignored',
            'escape_value' => true,
            'escape_strategy' => 'html'
		);
		$this->type->buildColumn($this->builder, $options);
		$column = $this->builder->build();
		$dataTransformers = $column->getDataTransformers();
		$this->assertCount(1, $dataTransformers);
		$transformer = $dataTransformers[0];
		$this->assertInstanceOf('Yjv\ReportRendering\DataTransformer\PropertyPathTransformer', $transformer);
		$this->assertEquals('column', $transformer->getConfig()->get('path'));
		$this->assertEquals(true, $transformer->getConfig()->get('required'));
		$this->assertEquals('', $transformer->getConfig()->get('empty_value'));
		$this->assertEquals(true, $transformer->getConfig()->get('escape_value'));
		$this->assertEquals('html', $transformer->getConfig()->get('escape_strategy'));
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
