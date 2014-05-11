<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\ReportRendering\ReportData\ReportData;
use Yjv\ReportRendering\ReportData\DataInterface;
use Yjv\ReportRendering\Filter\NullFilterCollection;
use Yjv\ReportRendering\Filter\FilterCollectionInterface;

class CallbackDatasource implements DatasourceInterface
{
    protected $callback;
    protected $callbackObject;
    protected $params;

    public function __construct($callback, array $params = array())
    {
        if (is_callable($callback)) {

            if (is_array($callback)) {

                $this->callbackObject = is_object($callback[0]) ? $callback[0] : null;
                $callback = new \ReflectionMethod($callback[0], $callback[1]);
            } else {

                $callback = new \ReflectionFunction($callback);
            }

        }

        if (!$callback instanceof \ReflectionFunctionAbstract) {

            throw new \InvalidArgumentException('$callback must be callable or an instance of ReflectionFunction');
        }

        $this->callback = $callback;
        $this->params = $params;
    }

    public function getData(array $filters)
    {
        $params = array_replace($this->params, $filters);
        $params['params'] = $params;

        $args = array();

        foreach ($this->callback->getParameters() as $parameter) {

            if (array_key_exists($parameter->getName(), $params)) {

                $args[] = $params[$parameter->getName()];
            } elseif ($parameter->isDefaultValueAvailable()) {

                $args[] = $parameter->getDefaultValue();
            } elseif ($parameter->allowsNull()) {

                $args[] = null;
            } else {

                throw new \InvalidArgumentException(sprintf(
                    'the parameter $%s was not defined in the filters or the default params',
                    $parameter->getName()
                ));
            }
        }

        if ($this->callback instanceof \ReflectionMethod) {

            $data = $this->callback->invokeArgs($this->callbackObject, $args);
        } else {
            $data = $this->callback->invokeArgs($args);
        }

        if (!$data instanceof DataInterface) {

            $unpaginatedCount = is_array($data) || $data instanceof \Countable ? count($data) : 0;
            $data = new ReportData($data, $unpaginatedCount);
        }

        return $data;
    }
}
