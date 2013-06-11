<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface;
use Yjv\ReportRendering\DataTransformer\PropertyPathTransformer;
use Yjv\ReportRendering\Renderer\Grid\Column\ColumnInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yjv\ReportRendering\Renderer\Grid\Column\AbstractColumnType;

class PropertyPathType extends AbstractColumnType
{
    public function getName()
    {
        return 'property_path';
    }

    public function buildColumn(ColumnBuilderInterface $builder, array $options)
    {
        $dataTransformer = $builder->getFactory()->getDataTransformerRegistry()->get('property_path');
        $dataTransformer->setConfig(array(
            'path' => $options['path'],
            'required' => $options['required'],
            'empty_value' => $options['empty_value']
        ));
        $builder->appendDataTransformer($dataTransformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $resolver
            ->setDefaults(array('path' => null, 'required' => true, 'empty_value' => ''))
            ->setAllowedTypes(array('path' => 'string', 'required' => 'bool', 'empty_value' => 'string'))
        ;
    }
}
