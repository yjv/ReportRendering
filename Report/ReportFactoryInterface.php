<?php
namespace Yjv\Bundle\ReportRenderingBundle\Report;
interface ReportFactoryInterface {

	public function create($type, array $options);
	public function createBuilder($type, array $options);
}
