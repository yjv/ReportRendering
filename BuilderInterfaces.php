<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/6/14
 * Time: 11:03 PM
 */

namespace Yjv\ReportRendering;


class BuilderInterfaces 
{
    const DATASOURCE = 'Yjv\ReportRendering\Datasource\DatasourceBuilderInterface';
    const REPORT = 'Yjv\ReportRendering\Report\ReportBuilderInterface';
    const RENDERER = 'Yjv\ReportRendering\Renderer\RendererBuilderInterface';
    const COLUMN = 'Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface';
}