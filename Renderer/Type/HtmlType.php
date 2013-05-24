<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Type;

use Yjv\Bundle\ReportRenderingBundle\Renderer\AbstractRendererType;

class HtmlType extends AbstractRendererType
{
    public function getName()
    {
        return 'html';
    }
}
