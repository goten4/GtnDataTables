  Zend Framework 2 Module for jQuery DataTables
=================================================
[![Build Status](https://secure.travis-ci.org/goten4/GtnDataTables.png?branch=master)](http://travis-ci.org/goten4/GtnDataTables)
[![Coverage Status](https://coveralls.io/repos/goten4/GtnDataTables/badge.png?branch=master)](https://coveralls.io/r/goten4/GtnDataTables)

## Introduction

**GtnDataTables** is a Zend Framework 2 module providing basics support for server side [jQuery DataTables](http://datatables.net/).

## Requirements

* Zend Framework 2

## Installation

* Add the following line in the require section of your composer.json

    "goten4/gtn-datatables": "dev-master"

* Then run the following command

    php composer.phar update

* Or simply clone this project into your `./vendor/` directory.

* Enable the module in your `./config/application.config.php` file.

## Usage

A good example is worth a thousand words ;)

### Configuration

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
            'classes' => ['table', 'bootstrap-datatable'],

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
            'columns' => [
                [
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
                ]
            ]
        )
    )

### Collector

    class ServersCollector implements CollectorInterface
    {
        /**
         * @param array $params
         * @return Collection
         */
        public function findAll(array $params = null)
        {
            // Get the $servers, $total and $filteredCount from database (or any other data source)
            
            return Collection::factory($servers, $total, $filteredCount);
        }
    }

### Column Decorator

    class ServerNameDecorator extends AbstractDecorator
    {
        /**
         * @return string
         */
        public function decorateTitle()
        {
            return $this->getViewHelperManager()->get('translator')->translate('Server');
        }

        /**
         * @param Server $object
         * @return string
         */
        public function decorateValue($object)
        {
            return '<strong>' . $object->getName() . '</strong>';
        }
    }


### In the controller

    public function indexAction()
    {
        $model = new JsonModel();
        $datatable = $this->getServiceLocator()->get('servers_datatable');
        $result = $datatable->getResult($this->params()->fromQuery());
        $model->setVariable('draw', $result->getDraw());
        $model->setVariable('recordsTotal', $result->getRecordsTotal());
        $model->setVariable('recordsFiltered', $result->getRecordsFiltered());
        $model->setVariable('data', $result->getData());
        return $model;
    }


### In the view

    <?php echo $this->dataTable('servers_datatable')->renderHtml(); ?>
