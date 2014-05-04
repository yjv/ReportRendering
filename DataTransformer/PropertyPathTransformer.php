<?php
namespace Yjv\ReportRendering\DataTransformer;


use Yjv\ReportRendering\Data\DataEscaperInterface;
use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class PropertyPathTransformer extends AbstractDataTransformer
{
    protected $path;
    protected $required = true;
    protected $emptyValue = '';
    protected $propertyAccessor;

    public function __construct(
        $path,
        $required = true,
        $emptyValue = '',
        PropertyAccessorInterface $propertyAccessor = null
    ) {
        $this->path = $path;
        $this->required = $required;
        $this->emptyValue = $emptyValue;
        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::getPropertyAccessor();
    }

    /**
     * @param mixed $data
     * @param mixed $originalData
     * @return mixed|string
     */
    public function transform($data, $originalData)
    {
        try {

            return $this->escapeValue(
                $this->path,
                $this->propertyAccessor->getValue($data, $this->path)
            );
        } catch (ExceptionInterface $e) {

            return $this->handlePathSearchException($e);
        }
    }

    protected function handlePathSearchException(ExceptionInterface $e)
    {
        if (!$this->required) {

            return $this->emptyValue;
        }

        throw $e;
    }
}
