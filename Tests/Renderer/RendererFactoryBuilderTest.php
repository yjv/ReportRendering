<?php
namespace Yjv\ReportRendering\Tests\Renderer;

use Yjv\ReportRendering\Renderer\Extension\Core\CoreExtension;
use Yjv\ReportRendering\Renderer\Extension\Symfony\SymfonyExtension;
use Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryBuilder;
use Yjv\ReportRendering\Renderer\RendererFactory;
use Yjv\ReportRendering\Renderer\RendererFactoryBuilder;

use Mockery;
use Yjv\TypeFactory\TypeRegistry;
use Yjv\TypeFactory\TypeResolver;

class RendererFactoryBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var RendererFactoryBuilder  */
    protected $builder;
    /** @var  Mockery\MockInterface */
    protected $templatingEngine;
    /** @var  Mockery\MockInterface */
    protected $formFactory;

    public function setUp()
    {
        $this->builder = new RendererFactoryBuilder();
        $this->templatingEngine = Mockery::mock('Symfony\Component\Templating\EngineInterface');
        $this->formFactory = Mockery::mock('Symfony\Component\Form\FormFactoryInterface');
    }

    public function testBuildWithNoFormFactoryAndNoTemplatingEngine()
    {
        $factory = new RendererFactory(
            new TypeResolver(new TypeRegistry($this->builder->getTypeName())),
            ColumnFactoryBuilder::create()->build()
        );
        $factory->getTypeRegistry()->addExtension(new CoreExtension());
        $this->assertEquals($factory, $this->builder->build());
    }

    public function testBuildWithNoFormFactoryAndTemplatingEngine()
    {
        $factory = new RendererFactory(
            new TypeResolver(new TypeRegistry($this->builder->getTypeName())),
            ColumnFactoryBuilder::create()->build()
        );
        $factory->getTypeRegistry()->addExtension(new CoreExtension($this->templatingEngine));
        $this->builder->setTemplatingEngine($this->templatingEngine);
        $this->assertEquals($factory, $this->builder->build());
    }

    public function testBuildWithFormFactoryAndTemplatingEngine()
    {
        $factory = new RendererFactory(
            new TypeResolver(new TypeRegistry($this->builder->getTypeName())),
            ColumnFactoryBuilder::create()->build()
        );
        $factory->getTypeRegistry()
            ->addExtension(new CoreExtension($this->templatingEngine))
            ->addExtension(new SymfonyExtension($this->formFactory))
        ;
        $this->builder
            ->setTemplatingEngine($this->templatingEngine)
            ->setFormFactory($this->formFactory)
        ;
        $this->assertEquals($factory, $this->builder->build());
    }

    public function testGettersSetters()
    {
        $this->assertInstanceOf('Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryBuilder', $this->builder->getColumnFactoryBuilder());
        $columnFactoryBuilder = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryBuilder');
        $this->assertSame($this->builder, $this->builder->setColumnFactoryBuilder($columnFactoryBuilder));
        $this->assertSame($columnFactoryBuilder, $this->builder->getColumnFactoryBuilder());
        $templatingEngine = Mockery::mock('Symfony\Component\Templating\EngineInterface');
        $this->assertSame($this->builder, $this->builder->setTemplatingEngine($templatingEngine));
        $this->assertSame($templatingEngine, $this->builder->getTemplatingEngine());
        $formFactory = Mockery::mock('Symfony\Component\Form\FormFactoryInterface');
        $this->assertSame($this->builder, $this->builder->setFormFactory($formFactory));
        $this->assertSame($formFactory, $this->builder->getFormFactory());
    }
}
