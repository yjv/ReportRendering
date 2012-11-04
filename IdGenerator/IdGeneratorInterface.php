<?php
namespace Yjv\Bundle\ReportRenderingBundle\IdGenerator;

use Yjv\Bundle\ReportRenderingBundle\Report\Report;

interface IdGeneratorInterface {

	public function getId(Report $report);
}
