<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Html;
use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\GridInterface;

use Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface;

use Yjv\Bundle\ReportRenderingBundle\ReportData\ImmutableDataInterface;

use Symfony\Component\Form\FormInterface;

use Yjv\Bundle\ReportRenderingBundle\Widget\WidgetRenderer;

use Yjv\Bundle\ReportRenderingBundle\Renderer\FilterAwareRendererInterface;

use Yjv\Bundle\ReportRenderingBundle\Widget\WidgetInterface;

class HtmlRenderer implements FilterAwareRendererInterface, WidgetInterface {

	protected $filters;
	protected $renderer;
	protected $template;
	protected $attributes = array();
	protected $filterForm;
	protected $grid;

	public function __construct(WidgetRenderer $renderer, GridInterface $grid, $template) {
		
		$this->renderer = $renderer;
		$this->template = $template;
		$this->grid = $grid;
		parent::__construct();
	}
	
	public function setData(ImmutableDataInterface $data) {

		$this->data = $data;
		$this->grid->setData($data);
		return $this;
	}
	
	public function getForceReload() {

		return true;
	}

	public function render(array $options = array()) {

		return $this->renderer->render($this, $options);
	}
	
	public function getRows() {
		
		return $this->grid->render();
	}

	public function getUnfilteredCount() {
		
		return $this->data->getUnfilteredCount();
	}
	
	public function getCount(){
		
		return $this->data->getCount();
	}

	public function setAttribute($name, $value) {

		$this->attributes[$name] = $value;
		return $this;
	}

	public function getAttributes() {

		return $this->attributes;
	}

	public function getAttribute($name, $default = null) {

		if (array_key_exists($name, $this->attributes)) {
			
			return $default;
		}
		
		return $this->attributes[$name];
	}

	public function setFilters(FilterCollectionInterface $filters) {

		$this->filters = $filters;
		return $this;
	}
	
	public function setFilterForm(FormInterface $form) {
		
		$this->filterForm = $form;
		return $this;
	}
	
	public function getFilterForm() {
		
		return $this->filterForm->bind($this->filters->all());
	}
	
	public function getTemplate() {

		return $this->template;
	}
}
