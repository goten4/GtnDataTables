  Zend Framework 2 Module for jQuery DataTables
=================================================
[![Build Status](https://secure.travis-ci.org/goten4/GtnDataTables.png?branch=master)](http://travis-ci.org/goten4/GtnDataTables)
[![Coverage Status](https://coveralls.io/repos/goten4/GtnDataTables/badge.png?branch=master)](https://coveralls.io/r/goten4/GtnDataTables)

## Introduction

**GtnDataTables** is a Zend Framework 2 module providing basics support for server side [jQuery DataTables](http://datatables.net/).

## Requirements

* Zend Framework 2

## Installation

* Simply clone this project into your `./vendor/` directory or add the following line in the require section of your composer.json :
 "goten4/gtn-datatables": "dev-master"

* Enable it in your `./config/application.config.php` file.

* Configure your datatables. Configuration example:
 
     'datatables' => array(
         'servers_datatable' => array(
             /**
              * Id attribute of the table HTML element.
              * Optional: if not provided the key of the datatable config is used (servers_datatable here).
              */
             'id' => 'servers',

             /**
              * Class attribute of the table HTML element.
              * Optional.
              */
             'classes' => array('table', 'bootstrap-datatable'),

             /**
              * Must implements Zend\ServiceManager\FactoryInterface.
              * createService method must return GtnDataTables\CollectorInterface.
              * Mandatory.
              */
             'collectorFactory' => 'MyProject\Service\MyCollectorFactory',

             /**
              * List of the columns of the datatable.
              * Mandatory.
              */
             'columns' => array(
                 array(
                     /**
                      * Must extend GtnDataTables\View\AbstractDecorator.
                      * Mandatory.
                      */
                     'decorator' => 'MyProject\View\MyDecorator',

                     /**
                      * Used to identify the column for ordering.
                      * Optionnal (if the column is not orderable).
                      */
                     'key' => 'name',
                 )
             )
         )
     )
