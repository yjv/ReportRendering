<?php
namespace Yjv\ReportRendering\DataTransformer;

class MappedDataTransformer extends AbstractDataTransformer
{
    protected $map;
    protected $required = true;
    protected $emptyValue = '';

    public function __construct(
        array $map,
        $required = true,
        $emptyValue = ''
    ) {
        $this->map = $map;
        $this->required = $required;
        $this->emptyValue = $emptyValue;
    }

    /**
     * @param mixed $data
     * @param mixed $originalData
     * @throws \InvalidArgumentException
     * @return string
     */
    public function transform($data, $originalData)
    {
        if (isset($this->map[$data]) || array_key_exists($data, $this->map)) {

            return $this->map[$data];
        }

        if ($this->required) {

            throw new \InvalidArgumentException(sprintf('map does not contain a value for %s', $data));
        }

        return $this->emptyValue;
    }
}
