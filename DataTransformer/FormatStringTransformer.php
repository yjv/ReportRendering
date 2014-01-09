<?php
namespace Yjv\ReportRendering\DataTransformer;

use Yjv\ReportRendering\Data\DataEscaper;

use Yjv\ReportRendering\Data\DataEscaperInterface;

use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;

use Symfony\Component\PropertyAccess\PropertyAccess;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class FormatStringTransformer extends AbstractEscapingDataTransformer
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
    public function transform($data, $orginalData)
    {
        $string = $this->config->get('format_string');

        if (preg_match_all('/\{([^}]*)\}/', $string, $matches)) {

            foreach (array_unique($matches[1]) as $path) {

                try {

                    $string = str_replace(
                        sprintf('{%s}', $path), 
                        $this->escapeValue(
                            $this->propertyAccessor->getValue($data, $path),
                            $this->getEscapeStrategy($path)
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

        if (!$this->config->get('required', true)) {

            return $this->config->get('empty_value', '');
        }

        throw $e;
    }
}
