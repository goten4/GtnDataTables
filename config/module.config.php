<?php
return array(
    'service_manager' => array(
        'abstract_factories' => array(
            'GtnDataTables\Service\DataTableAbstractFactory',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'datatable' => 'GtnDataTables\View\Helper\DataTable',
        ),
    ),
);
