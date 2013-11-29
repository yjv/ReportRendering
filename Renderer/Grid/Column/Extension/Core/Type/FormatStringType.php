<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type;

use Yjv\ReportRendering\Data\DataEscaperInterface;

use Symfony\Component\OptionsResolver\Options;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yjv\ReportRendering\Renderer\Grid\Column\AbstractColumnType;

class FormatStringType extends AbstractColumnType
{
    public function getName()
    {
        return 'format_string';
    }

    public function buildColumn(ColumnBuilderInterface $builder, array $options)
    {
        $dataTransformer = $builder->getFactory()->getDataTransformerRegistry()->get('format_string');
        $dataTransformer->setConfig(array(
            'format_string' => $options['format_string'],
            'required' => $options['required'],
            'empty_value' => $options['empty_value'],
            'escape_values' => $options['escape_values'],
            'escape_strategies' => $options['escape_strategies']
        ));
        $builder->appendDataTransformer($dataTransformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $resolver
            ->setRequired(array('format_string'))
            ->setDefaults(array(
                'required' => true, 
                'empty_value' => '',
                'escape_values' => true,
                'escape_strategies' => array()
            ))
            ->setAllowedTypes(array(
                'format_string' => 'string', 
                'required' => 'bool', 
                'empty_value' => 'string',
                'escape_values' => 'bool',
                'escape_strategies' => 'array'
            ))
        ;
    }
}
