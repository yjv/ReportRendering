Report Rendering [![Build Status](https://travis-ci.org/yjv/ReportRendering.png?branch=master)](https://travis-ci.org/yjv/ReportRendering)
==============================

[![Total Downloads](https://poser.pugx.org/yjv/report-rendering/downloads.png)](https://packagist.org/packages/yjv/report-rendering)
[![Latest Stable Version](https://poser.pugx.org/yjv/report-rendering/v/stable.png)](https://packagist.org/packages/yjv/report-rendering)

Purpose
-------
Report Rendering is meant to be used to render any tabulatable data from just about any source into just about any format.
This is done by using datasource classes that feed the report and allowing the report to hold multiple renderers
for rendering this data

 Usage
-----

```php
<?php

use Yjv\ReportRendering\ReportRendering;

// create a new report factory
$reportFactory = ReportRendering::createReportFactory();
$reportBuilder = $reportFactory->createBuilder('report');
$reportBuilder->setDatasource('array', array('data' => array(
	array('key1' => 'value1', 'key2' => 'value2'),
	array('key1' => 'value3', 'key2' => 'value4'),
));
$reportBuilder->addRenderer('csv', array(
	'columns' => array(
	
		array('property_path', array('name' => 'column1', 'path' => '[key1]'),
		array('format_string', array('name' => 'column2', 'format_string' => 'key2 = {[key2]}'),
	)
));
$report = $reportBuilder->getReport();
$report->getRenderer('csv')->render();
```
this would output something like this

```csv
column1, column2
value1, key2 = value2
value3, key2 = value4
```

Core Concepts
-------------

A report is a class that holds a datasource, filter collection and as many renderers as you want.
all datasources must follow the `Yjv\ReportRendering\Datasource\DatasourceInterface` this interface defines general methods for a class that takes filters and returns tabular data.
all filter collections must follow the `Yjv\ReportRendering\Filter\FilterColletctionInterface` this interface defines methods for a class that takes and returns filter values.
all renderers must follow the `Yjv\ReportRendering\Renderer\RendererInterface` this interface defines general methods for renderers that take tabular data and convert it into some reprot format.
when you want to render a report in a certain way you call the report's getRenderer method with the name.
if no name is passed it defaults to that report's default renderer.


Events
------

the report will fire events during the loading of data and allow you to change things both befroe and after the data is loaded.

`report.pre_load_data`

this event is good to use if you want to make some changes before the data is loaded for example change some some filter values or something like that. Note: changes to data are ignored.

`report.post_load_data`

this event is good to use for editing data returned form the data source before it's given to the renderer. Calling setData on the event will replace the data it has with the data you've supplied.


Factories
---------

even though you could technically set up the report on your own, configurable factories make this alot easier by allowing some simple config
changes to make a big difference. Also it supplies reasonable defaults for alot of things allowing you to only change what you 
need and use the rest as is.

there are 4 factories in report rendering
ReportFactory
RendererFactory
ColumnFactory
DatasourceFactory

If you know how the symfony2 form factory works this will seem very familiar.

### Types



### Type Extensions

### Extensions



Utilities
---------



About
=====

Requirements
------------

- Any flavor of PHP 5.3 or above should do
- [optional] PHPUnit 3.5+ to execute the test suite (phpunit --version)

Submitting bugs and feature requests
------------------------------------

Bugs and feature request are tracked on [GitHub](https://github.com/yjv/ReportRendering/issues)

Frameworks Integration
----------------------

- [Symfony2](http://symfony.com) pull the [ReportRenderingBundle](https://github.com/yjv/ReportRenderingBundle).

Author
------

Yosef Deray - <joseph.deray@giftcards.com><br />

License
-------

ReportRendering is licensed under the MIT License - see the `LICENSE` file for details