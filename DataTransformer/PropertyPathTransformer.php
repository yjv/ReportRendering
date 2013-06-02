<?php
namespace Yjv\Bundle\ReportRenderingBundle\DataTransformer;

use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

use Symfony\Component\PropertyAccess\PropertyAccess;

class PropertyPathTransformer extends AbstractDataTransformer
{
    protected $propertyAccessor;
    
    public function __construct(PropertyAccessorInterface $propertyAccessor = null)
    {
        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::getPropertyAccessor();
    }
    
    /**
     * @param unknown $data
     */
    public function transform($data, $orginalData)
    {
        $path = $this->config->get('path');

        try {

            return $this->propertyAccessor->getValue($data, $path);
        } catch (ExceptionInterface $e) {

            return $this->handlePathSearchException($e);
        }
    }

    protected function handlePathSearchException(ExceptionInterface $e)
    {
        if (!$this->config->get('required', true)) {

            return $this->config->get('empty_value', '');
        }

        throw $e;
    }
}
