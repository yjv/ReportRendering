<?php
namespace Yjv\ReportRendering\Tests\Factory;

use Yjv\ReportRendering\Datasource\DatasourceFactoryBuilder;
use Yjv\ReportRendering\Renderer\Extension\Symfony\SymfonyExtension;
use Yjv\ReportRendering\Renderer\RendererFactoryBuilder;
use Yjv\ReportRendering\Report\Extension\Core\CoreExtension;
use Yjv\ReportRendering\Report\ReportFactory;
use Yjv\ReportRendering\Report\ReportFactoryBuilder;
use Mockery;
use Yjv\TypeFactory\TypeRegistry;
use Yjv\TypeFactory\TypeResolver;

class ReportFactoryBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var ReportFactoryBuilder  */
    protected $builder;
    /** @var  Mockery\MockInterface */
    protected $templatingEngine;
    /** @var  Mockery\MockInterface */
    protected $formFactory;

    protected function setUp()
    {
        $this->builder = new ReportFactoryBuilder();
        $this->templatingEngine = Mockery::mock('Symfony\Component\Templating\EngineInterface');
        $this->formFactory = Mockery::mock('Symfony\Component\Form\FormFactoryInterface');
    }

    public function testBuildWithNoFormFactoryAndNoTemplatingEngine()
    {
        $factory = new ReportFactory(
            new TypeResolver(new TypeRegistry($this->builder->getTypeName())),
            DatasourceFactoryBuilder::create()->build(),
            RendererFactoryBuilder::create()->build()
        );
        $factory->getTypeRegistry()->addExtension(new CoreExtension());
        $this->assertEquals($factory, $this->builder->build());
    }

    public function testBuildWithNoFormFactoryAndTemplatingEngine()
    {
        $factory = new ReportFactory(
            new TypeResolver(new TypeRegistry($this->builder->getTypeName())),
            DatasourceFactoryBuilder::create()->build(),
            RendererFactoryBuilder::create()
                ->setTemplatingEngine($this->templatingEngine)
                ->build()
        );
        $factory->getTypeRegistry()->addExtension(new CoreExtension());
        $this->builder->setTemplatingEngine($this->templatingEngine);
        $this->assertEquals($factory, $this->builder->build());
    }

    public function testBuildWithFormFactoryAndTemplatingEngine()
    {
        $factory = new ReportFactory(
            new TypeResolver(new TypeRegistry($this->builder->getTypeName())),
            DatasourceFactoryBuilder::create()->build(),
            RendererFactoryBuilder::create()
                ->setTemplatingEngine($this->templatingEngine)
                ->setFormFactory($this->formFactory)
                ->build()
        );
        $factory->getTypeRegistry()->addExtension(new CoreExtension());
        $this->builder
            ->setTemplatingEngine($this->templatingEngine)
            ->setFormFactory($this->formFactory)
        ;
        $this->assertEquals($factory, $this->builder->build());
    }

    public function testGettersSetters()
    {
        $this->assertInstanceOf('Yjv\ReportRendering\Datasource\DatasourceFactoryBuilder', $this->builder->getDatasourceFactoryBuilder());
        $datasourceFactoryBuilder = Mockery::mock('Yjv\ReportRendering\Datasource\DatasourceFactoryBuilder');
        $this->assertSame($this->builder, $this->builder->setDatasourceFactoryBuilder($datasourceFactoryBuilder));
        $this->assertSame($datasourceFactoryBuilder, $this->builder->getDatasourceFactoryBuilder());
        $rendererFactoryBuilder = Mockery::mock('Yjv\ReportRendering\Renderer\RendererFactoryBuilder');
        $this->assertInstanceOf('Yjv\ReportRendering\Renderer\RendererFactoryBuilder', $this->builder->getRendererFactoryBuilder());
        $rendererFactoryBuilder = Mockery::mock('Yjv\ReportRendering\Renderer\RendererFactoryBuilder');
        $this->assertSame($this->builder, $this->builder->setRendererFactoryBuilder($rendererFactoryBuilder));
        $this->assertSame($rendererFactoryBuilder, $this->builder->getRendererFactoryBuilder());
        $templatingEngine = Mockery::mock('Symfony\Component\Templating\EngineInterface');
        $this->assertSame($this->builder, $this->builder->setTemplatingEngine($templatingEngine));
        $this->assertSame($templatingEngine, $this->builder->getTemplatingEngine());
        $formFactory = Mockery::mock('Symfony\Component\Form\FormFactoryInterface');
        $this->assertSame($this->builder, $this->builder->setFormFactory($formFactory));
        $this->assertSame($formFactory, $this->builder->getFormFactory());
    }
}
