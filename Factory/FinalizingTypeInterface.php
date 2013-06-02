<?php
namespace Yjv\ReportRendering\Factory;

interface FinalizingTypeInterface extends TypeInterface
{
    /**
     * 
     * @param mixed $object the finished object after it has been returned form the builder
     * @param array $options
     */
    public function finalize($object, array $options);
}
