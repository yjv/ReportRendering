<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yjv\ReportRendering\Renderer\Grid\Column\AbstractColumnType;

class RawColumnType extends AbstractColumnType
{
    public function getName()
    {
        return 'raw_column';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('escape_output' => false,));
    }
}
