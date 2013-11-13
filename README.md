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

$data = //data of some sort

// create a new report factory
$reportFactory = ReportRendering::createReportFactory();
$reportBuilder = $reportFactory->createBuilder('report');
$reportBuilder->setDatasource('array', array('data' => $data));
$reportBuilder->addRenderer('csv');
$report = $reportBuilder->getReport();
```

Core Concepts
-------------





Types
-----



Type Extensions
---------------

Extensions
----------



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