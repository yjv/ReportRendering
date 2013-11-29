<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type;

use Yjv\ReportRendering\Data\DataEscaperInterface;

use Symfony\Component\OptionsResolver\Options;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface;
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
            'empty_value' => $options['empty_value'],
            'escape_value' => $options['escape_value'],
            'escape_strategy' => $options['escape_strategy']
        ));
        $builder->appendDataTransformer($dataTransformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $resolver
            ->setRequired(array('path'))
            ->setDefaults(array(
                'required' => true, 
                'empty_value' => '',
                'escape_value' => true,
                'escape_strategy' => DataEscaperInterface::DEFAULT_STRATEGY,
            ))
            ->setAllowedTypes(array(
                'path' => 'string', 
                'required' => 'bool', 
                'empty_value' => 'string',
                'escape_value' => 'bool',
                'escape_strategy' => 'string'
            ))
        ;
    }
}
