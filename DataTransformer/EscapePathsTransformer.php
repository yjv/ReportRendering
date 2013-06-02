<?php
namespace Yjv\Bundle\ReportRenderingBundle\DataTransformer;

use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;

use Symfony\Component\PropertyAccess\PropertyAccess;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

use Symfony\Component\PropertyAccess\PropertyPath;

use Yjv\Bundle\ReportRenderingBundle\Data\DataEscaperInterface;
use Yjv\Bundle\ReportRenderingBundle\Data\DataEscaper;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EscapePathsTransformer extends AbstractDataTransformer
{
    protected $propertyPaths = array();
    protected $pathOptionsResolver;
    protected $escaper;
    protected $propertyAccessor;

    public function __construct(
        DataEscaperInterface $escaper, 
        PropertyAccessorInterface $propertyAccessor = null
    )
    {
        $this->escaper = $escaper;
        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::getPropertyAccessor();
    }

    /**
     * @param unknown $data
     */
    public function transform($data, $orginalData)
    {
        if ($this->config->get('copy_before_escape', false)) {

            $data = $this->copyData($data);
        }

        foreach ($this->config->get('paths', array()) as $path => $options) {

            $options = $this->getPathOptionsResolver()->resolve($options);

            try {

                $this->propertyAccessor->setValue(
                    $data, 
                    $path, 
                    $this->escapeValue(
                        $this->propertyAccessor->getValue($data, $path), 
                        $options
                    )
                );
            } catch (ExceptionInterface $e) {}
        }

        return $data;
    }

    protected function getPathOptionsResolver()
    {
        if (empty($this->pathOptionsResolver)) {

            $this->pathOptionsResolver = new OptionsResolver();
            $this->pathOptionsResolver
                ->setDefaults(array('escape_strategy' => 'html'))
                ->setAllowedTypes(array('escape_strategy' => 'string'))
                ->setAllowedValues(array('escape_strategy' => $this->escaper->getSupportedStrategies()))
            ;
        }

        return $this->pathOptionsResolver;
    }

    protected function escapeValue($value, array $options)
    {
        return $this->escaper->escape($options['escape_strategy'], $value);
    }

    protected function copyData($data)
    {
        if (is_object($data)) {

            $data = clone $data;
        }

        return $data;
    }
}
