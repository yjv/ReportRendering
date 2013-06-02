<?php
namespace Yjv\ReportRendering\Renderer\Csv;

use Yjv\ReportRendering\ReportData\ImmutableDataInterface;
use Yjv\ReportRendering\Renderer\Grid\GridInterface;
use Symfony\Component\HttpFoundation\Response;
use Yjv\ReportRendering\Renderer\ResponseAwareRendererInterface;

class CsvRenderer implements ResponseAwareRendererInterface
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

        foreach ($this->grid->getColumns() as $column) {

            $options = $column->getOptions();
            $columnNames[] = isset($options['name']) ? $options['name'] : '';
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

    public function setReportId($reportId)
    {
        return $this;
    }

    public function setCsvOption($name, $value)
    {
        $this->getCsvEncoder()->setOption($name, $value);
        return $this;
    }

    protected function getCsvEncoder()
    {
        if (empty($this->csvEncoder)) {

            $this->csvEncoder = new CsvEncoder($this->csvOptions);
        }

        return $this->csvEncoder;
    }
}
