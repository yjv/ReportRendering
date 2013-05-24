<?php
namespace Yjv\Bundle\ReportRenderingBundle\DataTransformer;

use Yjv\Bundle\ReportRenderingBundle\Data\DataEscaperInterface;
use Yjv\Bundle\ReportRenderingBundle\Data\DataEscaper;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Exception\FormException;
use Symfony\Component\Form\Exception\PropertyAccessDeniedException;
use Symfony\Component\Form\Exception\InvalidPropertyException;
use Symfony\Component\Form\Util\PropertyPath;

class EscapePathsTransformer extends AbstractDataTransformer
{
    protected $propertyPaths = array();
    protected $pathOptionsResolver;
    protected $escaper;

    public function __construct(DataEscaperInterface $escaper)
    {
        $this->escaper = $escaper;
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
            $propertyPath = $this->getPropertyPath($path);

            try {

                $propertyPath->setValue($data, $this->escapeValue($propertyPath->getValue($data), $options));
            } catch (InvalidPropertyException $e) {}
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

    protected function getPropertyPath($path)
    {
        if (!isset($this->propertyPaths[$path])) {

            $this->propertyPaths[$path] = new PropertyPath($path);
        }

        return $this->propertyPaths[$path];
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
