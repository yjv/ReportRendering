<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 3/23/14
 * Time: 12:57 AM
 */

namespace Yjv\ReportRendering\Twig;

/**
 * Class ReportRenderingExtension
 * @package Yjv\ReportRendering\Twig
 *
 * use this class with your twig setup if you are using the form component and you dont want to setup
 * the Symfony\Bridge\Twig\ExtensionTranslationExtension class
 */
class ReportRenderingExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array('trans' => new \Twig_Filter_Method($this, 'trans'));
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'report_rendering';
    }

    public function trans($value)
    {
        return $value;
    }
}