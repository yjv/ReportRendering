<?php
namespace Yjv\ReportRendering\Tests\Renderer\Extension\Core\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Yjv\ReportRendering\Util\Factory;

use Symfony\Component\OptionsResolver\Options;

use Yjv\ReportRendering\Renderer\Grid\Column\Column;

use Yjv\ReportRendering\Renderer\Extension\Core\Type\GriddedType;

use Mockery;

class GriddedTypeTest extends TypeTestCase
{
    protected $type;
    
    public function setUp()
    {
        parent::setUp();
        $this->type = new GriddedType();
    }
    
    public function testBuildRenderer()
    {
        $column1 = new Column();
        $column2Name = 'column';
        $column2Options = array('key' => 'value');
        
        $builder = Mockery::mock('Yjv\ReportRendering\Renderer\RendererBuilder')
            ->shouldReceive('addColumn')
            ->once()
            ->with($column1, array())
            ->getMock()
            ->shouldReceive('addColumn')
            ->once()
            ->with($column2Name, $column2Options)
            ->getMock()
        ;
        
        $testCase = $this;
        
        $columns = array(
            array($column1, array()),
            array($column2Name, $column2Options),
        );
        
        $this->type->buildRenderer($builder, array('columns' => $columns, 'grid' => null));
    }
    
    public function testBuilderRendererWithGridSet()
    {
        $grid = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\GridInterface');
        $this->type->buildRenderer($this->builder, array('columns' => array(), 'grid' => $grid));
        $this->assertSame($grid, $this->builder->getGrid());
    }
    
    public function testSetDefaults()
    {
        $testCase = $this;
        
        $resolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface')
            ->shouldReceive('setDefaults')
            ->once()
            ->with(array(
                'columns' => array(),
                'grid' => null
            ))
            ->andReturn(Mockery::self())
            ->getMock()
            ->shouldReceive('setAllowedTypes')
            ->once()
            ->with(array(
                'columns' => 'array', 
                'grid' => array('null', 'Yjv\ReportRendering\Renderer\Grid\GridInterface')
            ))
            ->andReturn(Mockery::self())
            ->getMock()
            ->shouldReceive('setNormalizers')
            ->once()
            ->with(Mockery::on(function($arg) use ($testCase)
            {
                $testCase->assertEquals(array(
                    'columns' => function(Options $options, $columns)
                    {
                        return Factory::normalizeCollectionToFactoryArguments($columns);
                    }
                ), $arg);
                return true;
            }
            ))
            ->andReturn(Mockery::self())
            ->getMock()
        ;
        $this->type->setDefaultOptions($resolver);;
    }
    
    public function testResolvingOfColumns()
    {
        $resolver = new OptionsResolver();
        $this->type->setDefaultOptions($resolver);
        $columns = array(
                
                'column1' => Mockery::mock('Yjv\ReportRendering\Renderer\Grid\Column\ColumnInterface'),
                'column2' => array(Mockery::mock('Yjv\ReportRendering\Renderer\Grid\Column\ColumnInterface')),
                'column3' => array(Mockery::mock('Yjv\ReportRendering\Renderer\Grid\Column\ColumnInterface'), array('key' => 'value'))
        );
        $options = $resolver->resolve(array('columns' => $columns));
        $this->assertEquals(array(
                
                'column1' => array($columns['column1'], array()),
                'column2' => array($columns['column2'][0], array()),
                'column3' => $columns['column3']
        ), $options['columns']);
    }
    
    public function testGetName()
    {
        $this->assertEquals('gridded', $this->type->getName());
    }
}
