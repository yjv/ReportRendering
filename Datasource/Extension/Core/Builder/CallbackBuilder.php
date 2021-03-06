<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 3/5/14
 * Time: 11:37 PM
 */

namespace Yjv\ReportRendering\Datasource\Extension\Core\Builder;


use Yjv\ReportRendering\Datasource\CallbackDatasource;
use Yjv\ReportRendering\Datasource\DatasourceBuilderInterface;
use Yjv\TypeFactory\AbstractBuilder;

class CallbackBuilder extends AbstractBuilder implements DatasourceBuilderInterface
{
    protected $callback;
    protected $params = array();

    /**
     * @param callable $callback
     * @return $this
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @return callable
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }
    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    public function build()
    {
        if (!is_callable($this->getCallback())) {

            throw new \RuntimeException('The callable callback is required to build the callback datasource');
        }

        return new CallbackDatasource(
            $this->getCallback(),
            $this->getParams()
        );
    }
}