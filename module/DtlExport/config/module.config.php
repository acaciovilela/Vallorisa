<?php

namespace DtlExport;

return array(
    'controller_plugins' => array(
        'aliases' => array(
            'CsvExport' => 'DtlExport:CsvExport',
        ),
        'invokables' => array(
            'DtlExport:CsvExport' => 'DtlExport\Controller\Plugin\CsvExport',
        ),
        'shared' => array(
            'DtlExport:CsvExport' => false,
        ),
    ),
);
