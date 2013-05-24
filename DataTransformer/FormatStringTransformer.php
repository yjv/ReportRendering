<?php
namespace Yjv\Bundle\ReportRenderingBundle\DataTransformer;

use Symfony\Component\Form\Exception\FormException;
use Symfony\Component\Form\Exception\PropertyAccessDeniedException;
use Symfony\Component\Form\Exception\InvalidPropertyException;
use Symfony\Component\Form\Util\PropertyPath;

class FormatStringTransformer extends AbstractDataTransformer
{
    /**
     * @param unknown $data
     */
    public function transform($data, $orginalData)
    {
        $string = $this->config->get('format_string');

        if (preg_match_all('/\{([^}]*)\}/', $string, $matches)) {

            foreach (array_unique($matches[1]) as $path) {

                $propertyPath = new PropertyPath($path);

                try {

                    $string = str_replace(sprintf('{%s}', $path), $propertyPath->getValue($data), $string);
                } catch (InvalidPropertyException $e) {

                    return $this->handlePathSearchException($e);
                } catch (PropertyAccessDeniedException $e) {

                    return $this->handlePathSearchException($e);
                }
            }
        }

        return $string;
    }

    protected function handlePathSearchException(FormException $e)
    {

        if (!$this->config->get('required', true)) {

            return $this->config->get('empty_value', '');
        }

        throw $e;
    }
}
