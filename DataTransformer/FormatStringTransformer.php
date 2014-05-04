<?php
namespace Yjv\ReportRendering\DataTransformer;


use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class FormatStringTransformer extends AbstractDataTransformer
{
    protected $formatString;
    protected $required = true;
    protected $emptyValue = '';
    protected $propertyAccessor;

    public function __construct(
        $formatString,
        $required = true,
        $emptyValue = '',
        PropertyAccessorInterface $propertyAccessor = null
    ) {
        $this->formatString = $formatString;
        $this->required = $required;
        $this->emptyValue = $emptyValue;
        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::getPropertyAccessor();
    }

    /**
     * @param $data mixed
     * @param $originalData mixed
     * @return mixed
     */
    public function transform($data, $originalData)
    {
        $string = $this->formatString;

        if (preg_match_all('/\{([^}]*)\}/', $string, $matches)) {

            foreach (array_unique($matches[1]) as $path) {

                try {

                    $string = str_replace(
                        sprintf('{%s}', $path), 
                        $this->escapeValue(
                            $path,
                            $this->propertyAccessor->getValue($data, $path)
                        ), 
                        $string
                    );
                } catch (ExceptionInterface $e) {

                    return $this->handlePathSearchException($e);
                }
            }
        }

        return $string;
    }

    protected function handlePathSearchException(ExceptionInterface $e)
    {
        if (!$this->required) {

            return $this->emptyValue;
        }

        throw $e;
    }
}
