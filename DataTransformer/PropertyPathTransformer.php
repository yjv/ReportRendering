<?php
namespace Yjv\Bundle\ReportRenderingBundle\DataTransformer;

use Symfony\Component\Form\Exception\FormException;
use Symfony\Component\Form\Exception\PropertyAccessDeniedException;
use Symfony\Component\Form\Exception\InvalidPropertyException;
use Symfony\Component\Form\Util\PropertyPath;

class PropertyPathTransformer extends AbstractDataTransformer
{
    /**
     * @param unknown $data
     */
    public function transform($data, $orginalData)
    {
        $propertyPath = $this->config->get('path');

        if (!is_object($propertyPath)) {

            $propertyPath = new PropertyPath($propertyPath);
        }

        try {

            return $propertyPath->getValue($data);
        } catch (InvalidPropertyException $e) {

            return $this->handlePathSearchException($e);
        } catch (PropertyAccessDeniedException $e) {

            return $this->handlePathSearchException($e);
        }
    }

    protected function handlePathSearchException(FormException $e)
    {
        if (!$this->config->get('required', true)) {

            return $this->getOption('empty_value', '');
        }

        throw $e;
    }
}
