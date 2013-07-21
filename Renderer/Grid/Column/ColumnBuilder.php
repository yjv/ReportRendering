<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column;

use Yjv\ReportRendering\Factory\Builder;

class ColumnBuilder extends Builder implements ColumnBuilderInterface
{
    protected $rowOptions = array();
    protected $cellOptions = array();
    protected $dataTransformers = array();

    /**
     * {@inheritdoc}
     */
    public function setRowOptions(array $options)
    {
        $this->rowOptions = $options;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setRowOption($name, $value)
    {
        $this->rowOptions[$name] = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRowOptions()
    {
        return $this->rowOptions;
    }

    /**
     * {@inheritdoc}
     */
    public function setCellOptions(array $options)
    {
        $this->cellOptions = $options;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setCellOption($name, $value)
    {
        $this->cellOptions[$name] = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCellOptions()
    {
        return $this->cellOptions;
    }

    /**
     * {@inheritdoc}
     */
    public function setDataTransformers(array $dataTransformers)
    {
        $this->dataTransformers = $dataTransformers;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDataTransformers()
    {
        return $this->dataTransformers;
    }

    /**
     * {@inheritdoc}
     */
    public function appendDataTransformer($dataTransformer)
    {
        $this->dataTransformers[] = $dataTransformer;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function prependDataTransformer($dataTransformer)
    {
        array_unshift($this->dataTransformers, $dataTransformer);
        return $this;
    }

    /**
     * @return \Yjv\ReportRendering\Renderer\Grid\Column\ColumnInterface
     */
    public function getColumn()
    {
        $column = new Column();
        $column
            ->setOptions($this->options)
            ->setRowOptions($this->rowOptions)
            ->setCellOptions($this->cellOptions)
            ->setDataTransformers($this->dataTransformers)
        ;

        return $column;
    }
}
