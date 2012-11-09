<?php
namespace Yjv\Bundle\ReportRenderingBundle\DataTransformer;

interface DataTransformerInterface {

	public function transform($data, $originalData);
	public function setOptions(array $options);
}
