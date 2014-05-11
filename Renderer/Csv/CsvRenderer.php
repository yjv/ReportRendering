<?php
namespace Yjv\ReportRendering\Renderer\Csv;


use Yjv\ReportRendering\FilterConstants;
use Yjv\ReportRendering\Renderer\FilterValuesProcessingRendererInterface;
use Yjv\ReportRendering\Renderer\Grid\Column\ColumnInterface;
use Yjv\ReportRendering\Report\ReportInterface;
use Yjv\ReportRendering\ReportData\ImmutableDataInterface;
use Yjv\ReportRendering\Renderer\Grid\GridInterface;
use Symfony\Component\HttpFoundation\Response;

class CsvRenderer implements FilterValuesProcessingRendererInterface
{
    protected $grid;
    protected $csvOptions;
    protected $csvEncoder;
    protected $forceReload;

    public function __construct(GridInterface $grid, $csvOptions = array(), $forceReload = false)
    {
        $this->grid = $grid;
        $this->csvOptions = $csvOptions;
        $this->forceReload = $forceReload;
    }

    public function renderResponse(array $options = array())
    {
        $filename = !empty($options['filename']) ? $options['filename'] : uniqid() . '.csv';

        return new Response($this->render($options), 200, array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
            'Pragma' => 'no-cache', 
            'Expires' => '0'
        ));
    }

    public function setData(ImmutableDataInterface $data)
    {
        $this->grid->setData($data);
        return $this;
    }

    public function getForceReload()
    {
        return $this->forceReload;
    }

    public function render(array $options = array())
    {
        $data = array();

        $columnNames = array();

        /** @var ColumnInterface $column */
        foreach ($this->grid->getColumns() as $column) {

            $columnOptions = $column->getOptions();
            $columnNames[] = isset($columnOptions['name']) ? $columnOptions['name'] : '';
        }

        $data[] = $columnNames;

        foreach ($this->grid->getRows() as $row) {

            $rowData = array();

            foreach ($row['cells'] as $cell) {

                $rowData[] = $cell['data'];
            }

            $data[] = $rowData;
        }

        return $this->getCsvEncoder()->encode($data);
    }

    public function setReport(ReportInterface $report)
    {
        return $this;
    }

    public function setCsvOption($name, $value)
    {
        $this->getCsvEncoder()->setOption($name, $value);
        return $this;
    }

    public function processFilterValues(array $filterValues)
    {
        $filterValues[FilterConstants::LIMIT] = 100000;
        return $filterValues;
    }

    public function getCsvEncoder()
    {
        if (empty($this->csvEncoder)) {

            $this->csvEncoder = new CsvEncoder($this->csvOptions);
        }

        return $this->csvEncoder;
    }

    public function setCsvEncoder(CsvEncoder $csvEncoder)
    {
        $this->csvEncoder = $csvEncoder;
        return $this;
    }
}
