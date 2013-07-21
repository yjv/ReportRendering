<?php
namespace Yjv\ReportRendering\Datasource;

use Symfony\Component\PropertyAccess\PropertyAccess;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

use Yjv\ReportRendering\ReportData\ReportData;
use Yjv\ReportRendering\Filter\NullFilterCollection;
use Yjv\ReportRendering\Filter\FilterCollectionInterface;

class ArrayDatasource implements MappedSortDatasourceInterface
{
    protected $data;
    protected $processedData;
    protected $filters;
    protected $sortMap = array();
    protected $filterMap = array();
    protected $propertyAccessor;

    public function __construct($data, PropertyAccessorInterface $propertyAccessor = null)
    {
        if ($data instanceof \Traversable) {

            $data = iterator_to_array($data);
        }

        if (!is_array($data)) {

            throw new \InvalidArgumentException('$data must be either an array or an instance of Traversable');
        }

        $this->data = $data;
        $this->filters = new NullFilterCollection();
        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::getPropertyAccessor();
    }

    public function getData($forceReload = false)
    {
        if ($forceReload || empty($this->processedData)) {

            $this->processData();
        }

        return new ReportData($this->processedData, count($this->data));
    }

    public function setFilters(FilterCollectionInterface $filters)
    {
        $this->filters = $filters;
        return $this;
    }

    public function setSortMap(array $sortMap)
    {
        $this->sortMap = $sortMap;
        return $this;
    }

    public function setFilterMap(array $filterMap)
    {
        $this->filterMap = $filterMap;
        return $this;
    }

    protected function processData()
    {
        $this->processedData = $this->data;
        $propertyAccessor = $this->propertyAccessor;

        $filters = $this->filters->all();
        unset($filters['sort']);

        foreach ($filters as $name => $value) {

            $filterPath = $this->mapFilter($name);

            $this->processedData = array_filter(
                $this->processedData,
                function ($data) use ($value, $propertyAccessor, $filterPath)
                {
                    $data = $propertyAccessor->getValue($data, $filterPath);
                    if ($value === '' || stripos($data, $value) === 0) {

                        return true;
                    }
                    
                    return false;
                }
            );
        }

        if ($this->filters->get('sort', false)) {

            $sort = $this->filters->get('sort');
            reset($sort);
            $order = current($sort);
            $sort = $this->mapSort(key($sort));

            uasort(
                $this->processedData,
                function ($a, $b) use ($propertyAccessor, $order, $sort)
                {
                    $valueA = $propertyAccessor->getValue($a, (string)$sort);
                    $valueB = $propertyAccessor->getValue($b, (string)$sort);
                    return ($order == 'asc' ? 1 : -1) * strcasecmp($valueA, $valueB);
                }
            );
        }
    }

    protected function mapSort($sort)
    {
        return isset($this->sortMap[$sort]) ? $this->sortMap[$sort] : $sort;
    }

    protected function mapFilter($filter)
    {
        return isset($this->filterMap[$filter]) ? $this->filterMap[$filter] : $filter;
    }
}
