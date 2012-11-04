<?php
namespace Yjv\BundleReportRenderingBundle\DataTransformer;

interface DataTransformerInterface {

	public function transform($data, $originalData);
	public function setOptions(array $options);
}
