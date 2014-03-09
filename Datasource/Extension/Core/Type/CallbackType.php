<?php
namespace Yjv\ReportRendering\Datasource\Extension\Core\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yjv\ReportRendering\Datasource\DatasourceBuilderInterface;
use Yjv\ReportRendering\Datasource\AbstractDatasourceType;
use Yjv\ReportRendering\Datasource\Extension\Core\Builder\CallbackBuilder;
use Yjv\TypeFactory\TypeFactoryInterface;

class CallbackType extends AbstractDatasourceType
{
    /**
     * @param DatasourceBuilderInterface|CallbackBuilder $builder
     * @param array $options
     */
    public function buildDatasource(DatasourceBuilderInterface $builder, array $options)
    {
        $builder->setCallback($options['callback']);
        $builder->setParams($options['params']);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array('callback'))
            ->setDefaults(array(
                'params' => array()
            ))
            ->setAllowedTypes(array(
                'callback' => 'callable',
                'params' => 'array'
            ))
        ;
    }

    public function getName()
    {
        return 'callback';
    }

    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
        return new CallbackBuilder($factory, $options);
    }

}
