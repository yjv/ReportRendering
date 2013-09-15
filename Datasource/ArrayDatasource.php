<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\ReportRendering\FilterConstants;

use Symfony\Component\PropertyAccess\PropertyAccess;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

use Yjv\ReportRendering\ReportData\ReportData;
use Yjv\ReportRendering\Filter\NullFilterCollection;
use Yjv\ReportRendering\Filter\FilterCollectionInterface;

class ArrayDatasource implements MappedFilterDatasourceInterface
{
    protected $data;
    protected $processedData;
    protected $unpaginatedCount;
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

        return new ReportData($this->processedData, $this->unpaginatedCount);
    }

    public function setFilters(FilterCollectionInterface $filters)
    {
        $this->filters = $filters;
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
        
        unset(
            $filters[FilterConstants::SORT], 
            $filters[FilterConstants::LIMIT], 
            $filters[FilterConstants::OFFSET]
        );

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
        
        if ($sort = $this->filters->get(FilterConstants::SORT, false)) {

            reset($sort);
            $order = current($sort);
            $sort = $this->mapFilter(key($sort));

            usort(
                $this->processedData,
                function ($a, $b) use ($propertyAccessor, $order, $sort)
                {
                    $valueA = $propertyAccessor->getValue($a, (string)$sort);
                    $valueB = $propertyAccessor->getValue($b, (string)$sort);
                    return ($order == FilterConstants::SORT_ORDER_ASCENDING ? 1 : -1) * strcasecmp($valueA, $valueB);
                }
            );
        }

        $this->unpaginatedCount = count($this->processedData);

        $limit = $this->filters->get(FilterConstants::LIMIT, FilterConstants::DEFAULT_LIMIT);
        $offset = $this->filters->get(FilterConstants::OFFSET, FilterConstants::DEFAULT_OFFSET);
        
        $this->processedData = array_slice($this->processedData, $offset, $limit);
    }

    protected function mapFilter($filter)
    {
        return isset($this->filterMap[$filter]) ? $this->filterMap[$filter] : $filter;
    }
}
