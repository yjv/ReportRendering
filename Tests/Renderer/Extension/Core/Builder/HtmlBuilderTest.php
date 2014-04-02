<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 3/5/14
 * Time: 10:38 PM
 */

namespace Yjv\ReportRendering\Tests\Renderer\Extension\Core\Builder;

use Mockery;
use Yjv\ReportRendering\Renderer\Extension\Core\Builder\HtmlBuilder;
use Yjv\ReportRendering\Renderer\Html\HtmlRenderer;
use Yjv\ReportRendering\Tests\Renderer\AbstractRendererBuilderTest;

class HtmlBuilderTest extends AbstractRendererBuilderTest
{
    /**
     * @var Mockery\MockInterface
     */
    protected $templatingEngine;

    /**
     * @var HtmlBuilder
     */
    protected $builder;

    public function setUp()
    {
        parent::setUp();
        $this->templatingEngine = Mockery::mock('Symfony\Component\Templating\EngineInterface');
        $this->builder = new HtmlBuilder($this->factory);
    }

    public function testGettersSetters()
    {
        parent::testGettersSetters();
        $this->assertSame($this->builder, $this->builder->setRendererOptions($rendererOptions = array('key' => 'value')));
        $this->assertEquals($rendererOptions, $this->builder->getRendererOptions());
        $this->assertSame($this->builder, $this->builder->setFilterForm($filterForm = Mockery::mock('Yjv\ReportRendering\Renderer\Html\Filter\FormInterface')));
        $this->assertSame($filterForm, $this->builder->getFilterForm());
        $this->assertSame($this->builder, $this->builder->setTemplate($template = 'saddaads'));
        $this->assertEquals($template, $this->builder->getTemplate());
        $this->assertSame($this->builder, $this->builder->setTemplatingEngine($this->templatingEngine));
        $this->assertSame($this->templatingEngine, $this->builder->getTemplatingEngine());
        $this->assertSame($this->builder, $this->builder->setWidgetAttributes($attributes = array('fsdfdssdf' => 'vadule')));
        $this->assertEquals($attributes, $this->builder->getWidgetAttributes());
        $this->assertSame($this->builder, $this->builder->setJavascripts($javascripts = array('zxczzczcx' => 'tyuyt')));
        $this->assertEquals($javascripts, $this->builder->getJavascripts());
        $this->assertSame($this->builder, $this->builder->setStylesheets($stylesheets = array('hkhjkhk' => 'asdsa')));
        $this->assertEquals($stylesheets, $this->builder->getStylesheets());
    }

    public function testGetRenderer()
    {
        $grid = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\GridInterface');
        $template = 'fsfsdsfd';
        $attributes = array('fsdfdssdf' => 'vadule');
        $filterForm = Mockery::mock('Yjv\ReportRendering\Renderer\Html\Filter\FormInterface');
        $rendererOptions = array('key' => 'value');
        $javascripts = array('zxczzczcx' => 'tyuyt');
        $stylesheets = array('hkhjkhk' => 'asdsa');
        $this->builder
            ->setGrid($grid)
            ->setTemplate($template)
            ->setWidgetAttributes($attributes)
            ->setRendererOptions($rendererOptions)
            ->setTemplatingEngine($this->templatingEngine)
            ->setJavascripts($javascripts)
            ->setStylesheets($stylesheets)
        ;
        $renderer = new HtmlRenderer($this->templatingEngine, $grid, $template);
        $renderer
            ->setAttribute('fsdfdssdf', 'vadule')
            ->setOption('key', 'value')
            ->addJavascript(key($javascripts), current($javascripts))
            ->addStylesheet(key($stylesheets), current($stylesheets))
        ;
        $this->assertEquals($renderer, $this->builder->getRenderer());
        $this->builder
            ->setFilterForm($filterForm)
        ;
        $renderer->setFilterForm($filterForm);
        $this->assertEquals($renderer, $this->builder->getRenderer());
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage The templating engine is required to build the html renderer
     */
    public function testGetRendererWithNoTemplatingEngine()
    {
        $this->builder->getRenderer();
    }
}
 