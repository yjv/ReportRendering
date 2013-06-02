<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column;

interface ColumnInterface
{
    /**
     * @return array an array of options for the column
     */
    public function getOptions();

    /**
     * should return the options for the row taking the previous options into account
     * @param array $previousOptions
     * @return array the options for the row given the data the column has at that point, probably merged with the previous columns options
     */
    public function getRowOptions(array $previousOptions = array());

    /**
     * @return array the options for the cell given the data the column has at that point
     */
    public function getCellOptions();

    /**
     * @return array the data for the given cell given the data set in setData
     */
    public function getCellData();

    /**
     * set the current row data
     * @param mixed $data
     * @return mixed should be something castable to a string
     */
    public function setData($data);
}
