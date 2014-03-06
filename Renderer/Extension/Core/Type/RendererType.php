<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Type;

use Yjv\ReportRendering\Renderer\AbstractRendererType;

class RendererType extends AbstractRendererType
{
    /**
     *
     */
    public function getName()
    {
        return 'renderer';
    }

    /**
     * @return boolean
     */
    public function getParent()
    {
        return false;
    }
}
