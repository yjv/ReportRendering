<?php
namespace Yjv\ReportRendering\Renderer;


use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Templating\EngineInterface;
use Yjv\ReportRendering\BuilderInterfaces;
use Yjv\ReportRendering\Renderer\Extension\Core\CoreExtension;
use Yjv\ReportRendering\Renderer\Extension\Symfony\SymfonyExtension;
use Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryBuilder;
use Yjv\TypeFactory\TypeFactoryBuilder;

class RendererFactoryBuilder extends TypeFactoryBuilder
{
    protected $columnFactoryBuilder;
    protected $templatingEngine;
    protected $formFactory;

    /**
     * @return ColumnFactoryBuilder
     */
    public function getColumnFactoryBuilder()
    {
        if (!$this->columnFactoryBuilder) {

            $this->columnFactoryBuilder = $this->getDefaultColumnFactoryBuilder();
        }

        return $this->columnFactoryBuilder;
    }

    /**
     * @param ColumnFactoryBuilder $columnFactoryBuilder
     * @return $this
     */
    public function setColumnFactoryBuilder(ColumnFactoryBuilder $columnFactoryBuilder)
    {
        $this->columnFactoryBuilder = $columnFactoryBuilder;
        return $this;
    }

    /**
     * @param EngineInterface $templatingEngine
     * @return $this
     */
    public function setTemplatingEngine(EngineInterface $templatingEngine)
    {
        $this->templatingEngine = $templatingEngine;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTemplatingEngine()
    {
        return $this->templatingEngine;
    }

    /**
     * @param FormFactoryInterface $formFactory
     * @return $this
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFormFactory()
    {
        return $this->formFactory;
    }

    protected function getDefaultBuilderInterfaceName()
    {
        return BuilderInterfaces::RENDERER;
    }

    protected function getDefaultColumnFactoryBuilder()
    {
        return ColumnFactoryBuilder::create();
    }
    protected function getDefaultExtensions()
    {
        $extensions = array(new CoreExtension($this->templatingEngine));

        if ($this->formFactory) {

            $extensions[] = new SymfonyExtension($this->formFactory);
        }

        return $extensions;
    }

    protected function getFactoryInstance()
    {
        return new RendererFactory(
            $this->getTypeResolver(),
            $this->getColumnFactoryBuilder()->build(),
            $this->getBuilderInterfaceName()
        );
    }

}
