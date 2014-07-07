<?php
return array(
    'service_manager' => array(
        'abstract_factories' => array(
            'GtnDataTables\Service\DataTableAbstractFactory',
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'datatable' => 'GtnDataTables\View\Helper\DataTableFactory',
        ),
    ),
);
