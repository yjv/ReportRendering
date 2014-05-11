<?php
namespace Yjv\ReportRendering\Report;

class ReportEvents
{
    const PRE_INITIALIZE_RENDERER = 'report.pre_initialize_renderer';
    const INITIALIZE_RENDERER = 'report.initialize_renderer';
    const POST_INITIALIZE_RENDERER = 'report.post_initialize_renderer';
    const PRE_LOAD_DATA = 'report.pre_load_data';
    const POST_LOAD_DATA = 'report.post_load_data';
}
