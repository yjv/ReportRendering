<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type;

use Yjv\ReportRendering\Data\DataEscaperInterface;
use Yjv\ReportRendering\DataTransformer\PropertyPathTransformer;
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
        $dataTransformer = new PropertyPathTransformer(
            $options['path'],
            $options['required'],
            $options['empty_value']
        );

        if ($options['escape_value']) {

            $dataTransformer->turnOnEscaping();
            $dataTransformer->setPathStrategies(array(
                $options['path'] => $options['escape_strategy']
            ));
        }

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
