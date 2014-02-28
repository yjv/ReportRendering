<?php
namespace Yjv\ReportRendering\DataTransformer;

class MappedDataTransformer extends AbstractDataTransformer
{
    /**
     * @param unknown $data
     */
    public function transform($data, $originalData)
    {
        $map = $this->config->get('map');

        if (isset($map[$data]) || array_key_exists($data, $map)) {

            $value = $map[$data];
        } else {

            if ($this->config->get('required', true)) {

                throw new \InvalidArgumentException(sprintf('map does not contain a value for %s', $data));
            } else {

                $value = $this->config->get('empty_value', '');
            }
        }

        return $value;
    }
}
