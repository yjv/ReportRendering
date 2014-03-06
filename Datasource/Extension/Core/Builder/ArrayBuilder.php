<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 3/5/14
 * Time: 11:27 PM
 */

namespace Yjv\ReportRendering\Datasource\Extension\Core\Builder;


use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Yjv\ReportRendering\Datasource\ArrayDatasource;
use Yjv\ReportRendering\Datasource\DatasourceBuilderInterface;
use Yjv\TypeFactory\Builder;

class ArrayBuilder extends Builder implements DatasourceBuilderInterface
{
    protected $filterMap = array();
    protected $data = array();
    protected $propertyAccessor;

    public function getDatasource()
    {
        $datasource = new ArrayDatasource(
            $this->getData(),
            $this->getPropertyAccessor()
        );
        $datasource->setFilterMap($this->getFilterMap());
        return $datasource;
    }

    public function getPropertyAccessor()
    {
        if (!$this->propertyAccessor) {

            $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        }

        return $this->propertyAccessor;
    }

    public function setPropertyAccessor(PropertyAccessorInterface $propertyAccessor)
    {
        $this->propertyAccessor = $propertyAccessor;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getFilterMap()
    {
        return $this->filterMap;
    }

    public function setFilterMap(array $filterMap)
    {
        $this->filterMap = $filterMap;
        return $this;
    }
}