<?php
namespace Yjv\ReportRendering\DataTransformer;

use Yjv\ReportRendering\Data\DataEscaperInterface;

use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

use Symfony\Component\PropertyAccess\PropertyAccess;

class PropertyPathTransformer extends AbstractEscapingDataTransformer
{
    protected $propertyAccessor;
    
    public function __construct(
        PropertyAccessorInterface $propertyAccessor = null, 
        DataEscaperInterface $escaper = null
    ) {
        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::getPropertyAccessor();
        parent::__construct($escaper);
    }
        
    /**
     * @param unknown $data
     */
    public function transform($data, $originalData)
    {
        $path = $this->config->get('path');

        try {

            return $this->escapeValue(
                $this->propertyAccessor->getValue($data, $path),
                $this->getEscapeStrategy($path)
            );
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
    
    protected function getEscapeStrategy($path)
    {
        if (!$this->getConfig()->get('escape_value', true)) {
    
            return false;
        }
    
        return $this->getConfig()->get('escape_strategy', DataEscaperInterface::DEFAULT_STRATEGY);
    }
}
