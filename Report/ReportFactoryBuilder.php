<?php
namespace Yjv\ReportRendering\Report;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Templating\EngineInterface;
use Yjv\ReportRendering\BuilderInterfaces;
use Yjv\ReportRendering\Renderer\RendererFactoryBuilder;

use Yjv\ReportRendering\Datasource\DatasourceFactoryBuilder;

use Yjv\ReportRendering\Report\Extension\Core\CoreExtension;
use Yjv\TypeFactory\TypeFactoryBuilder;

class ReportFactoryBuilder extends TypeFactoryBuilder
{
    protected $rendererFactoryBuilder;
    protected $datasourceFactoryBuilder;
    protected $templatingEngine;
    protected $formFactory;

    /**
     * @return RendererFactoryBuilder
     */
    public function getRendererFactoryBuilder()
    {
        if (!$this->rendererFactoryBuilder) {
    
            $this->rendererFactoryBuilder = $this->getDefaultRendererFactoryBuilder();
        }
    
        return $this->rendererFactoryBuilder;
    }
    
    public function setRendererFactoryBuilder(RendererFactoryBuilder $rendererFactoryBuilder)
    {
        $this->rendererFactoryBuilder = $rendererFactoryBuilder;
        return $this;
    }

    /**
     * @return DatasourceFactoryBuilder
     */
    public function getDatasourceFactoryBuilder()
    {
        if (!$this->datasourceFactoryBuilder) {
            
            $this->datasourceFactoryBuilder = $this->getDefaultDatasourceFactoryBuilder();
        }
        
        return $this->datasourceFactoryBuilder;
    }
    
    public function setDatasourceFactoryBuilder(DatasourceFactoryBuilder $datasourceFactoryBuilder)
    {
        $this->datasourceFactoryBuilder = $datasourceFactoryBuilder;
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

    protected function getFactoryInstance()
    {
        $rendererFactoryBuilder = $this->getRendererFactoryBuilder();

        if ($this->templatingEngine) {

            $rendererFactoryBuilder->setTemplatingEngine($this->templatingEngine);
        }

        if ($this->formFactory) {

            $rendererFactoryBuilder->setFormFactory($this->formFactory);
        }

        return new ReportFactory(
            $this->getTypeResolver(), 
            $this->getDatasourceFactoryBuilder()->build(), 
            $rendererFactoryBuilder->build(),
            $this->getBuilderInterfaceName()
        );
    }
    
    protected function getDefaultRendererFactoryBuilder()
    {
        return RendererFactoryBuilder::create();
    }
    
    protected function getDefaultDatasourceFactoryBuilder()
    {
        return DatasourceFactoryBuilder::create();
    }

    protected function getDefaultExtensions()
    {
        return array(new CoreExtension());
    }

    public function getBuilderInterfaceName()
    {
        return BuilderInterfaces::REPORT;
    }
}
