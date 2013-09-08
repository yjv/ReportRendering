<?php
namespace Yjv\ReportRendering\Renderer\Grid;
use Yjv\ReportRendering\Renderer\Grid\Column\ColumnInterface;

use Yjv\ReportRendering\ReportData\ImmutableDataInterface;

class Grid implements \IteratorAggregate, GridInterface
{
    protected $data;
    protected $columns = array();
    protected $rows = array();
    protected $forceReload = false;

    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Renderer\RendererInterface::setData()
     */
    public function setData(ImmutableDataInterface $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param array $options
     */
    public function getRows()
    {
        $this->loadRows();
        return $this->rows;
    }

    public function addColumn(ColumnInterface $column)
    {
        $this->columns[] = $column;
        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getRows());
    }
    
    public function setForceReload($forceReload)
    {
        $this->forceReload = $forceReload;
        return $this;
    }

    protected function loadRows()
    {
        $this->assertDataSet();
        
        if (!empty($this->rows) && !$this->forceReload) {

            return;
        }

        $this->rows = array();

        foreach ($this->data->getData() as $rowData) {

            $row = array('cells' => array(), 'options' => array());

            foreach ($this->columns as $column) {

                $column->setData($rowData);

                $row['cells'][] = array(
                    'options' => $column->getCellOptions(),
                    'data' => $column->getCellData()
                );

                $row['options'] = $column->getRowOptions($row['options']);
            }

            $this->rows[] = $row;
        }
    }

    protected function assertDataSet()
    {
        if (empty($this->data)) {
    
            throw new \BadMethodCallException('data must be set to use this method');
        }
    }
}
