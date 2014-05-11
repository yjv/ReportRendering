<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\ReportRendering\FilterConstants;

use Symfony\Component\PropertyAccess\PropertyAccess;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

use Yjv\ReportRendering\ReportData\ReportData;

class ArrayDatasource implements MappedFilterDatasourceInterface
{
    protected $sortMap = array();
    protected $filterMap = array();
    protected $propertyAccessor;
    protected $data;

    public function __construct($data, PropertyAccessorInterface $propertyAccessor = null)
    {
        if ($data instanceof \Traversable) {

            $data = iterator_to_array($data);
        }

        if (!is_array($data)) {

            throw new \InvalidArgumentException('$data must be either an array or an instance of Traversable');
        }

        $this->data = $data;
        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::getPropertyAccessor();
    }

    public function getData(array $filterValues)
    {
        $processedData = $this->data;
        $propertyAccessor = $this->propertyAccessor;

        $sort = isset($filterValues[FilterConstants::SORT]) ? $filterValues[FilterConstants::SORT] : false;
        $limit = isset($filterValues[FilterConstants::LIMIT]) ? $filterValues[FilterConstants::LIMIT] : FilterConstants::DEFAULT_LIMIT;
        $offset = isset($filterValues[FilterConstants::LIMIT]) ? $filterValues[FilterConstants::OFFSET] : FilterConstants::DEFAULT_OFFSET;
        unset(
            $filterValues[FilterConstants::SORT],
            $filterValues[FilterConstants::LIMIT],
            $filterValues[FilterConstants::OFFSET]
        );

        foreach ($filterValues as $name => $value) {

            $filterPath = $this->mapFilter($name);

            $processedData = array_filter(
                $processedData,
                function ($data) use ($value, $propertyAccessor, $filterPath)
                {
                    $data = $propertyAccessor->getValue($data, $filterPath);
                    if ($value === '' || is_null($value) || stripos($data, $value) === 0) {

                        return true;
                    }

                    return false;
                }
            );
        }

        if ($sort) {

            $order = reset($sort);
            $sort = $this->mapFilter(key($sort));

            usort(
                $processedData,
                function ($a, $b) use ($propertyAccessor, $order, $sort)
                {
                    $valueA = $propertyAccessor->getValue($a, (string)$sort);
                    $valueB = $propertyAccessor->getValue($b, (string)$sort);
                    return ($order == FilterConstants::SORT_ORDER_ASCENDING ? 1 : -1) * strcasecmp($valueA, $valueB);
                }
            );
        }

        return new ReportData(
            array_slice($processedData, $offset, $limit),
            count($processedData)
        );
    }

    public function setFilterMap(array $filterMap)
    {
        $this->filterMap = $filterMap;
        return $this;
    }

    protected function mapFilter($filter)
    {
        return isset($this->filterMap[$filter]) ? $this->filterMap[$filter] : $filter;
    }
}
