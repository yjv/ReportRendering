<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column;

use Yjv\TypeFactory\BuilderInterface;

interface ColumnBuilderInterface extends BuilderInterface
{
    /**
     * sets the columns row options
     * @param array $options
     */
    public function setRowOptions(array $options);

    /**
     * 
     * @param string $name
     * @param string|callable $value
     * @return \Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface
     */
    public function setRowOption($name, $value);

    /**
     * should return the options for the row
     * @return array the options for the row
     */
    public function getRowOptions();

    /**
     * sets a columns cell options
     * @param array $options
     * @return \Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface
     */
    public function setCellOptions(array $options);

    /**
     * 
     * @param string $name
     * @param string|callable $value
     * @return \Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface
     */
    public function setCellOption($name, $value);

    /**
     * @return array the options for the cell
     */
    public function getCellOptions();

    /**
     * sets the array of data transformers for processing data
     * @param array $dataTransformers
     * @return \Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface
     */
    public function setDataTransformers(array $dataTransformers);

    /**
     * gets the array of data transformers set so far
     */
    public function getDataTransformers();

    /**
     * appends a datatransformer to the array
     * @param DataTransofrmerInterface|callable $dataTransformer
     * @return \Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface
     */
    public function appendDataTransformer($dataTransformer);

    /**
     * prepends a datatransformer to the array
     * @param DataTransofrmerInterface|callable $dataTransformer
     * @return \Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface
     */
    public function prependDataTransformer($dataTransformer);
}
