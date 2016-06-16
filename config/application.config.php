<?php
/**
 * Configuration file generated by ZFTool
 * The previous configuration file is stored in application.config.old
 *
 * @see https://github.com/zendframework/ZFTool
 */
return array(
    'modules' => array(
//        'ZF2NetteDebug',
        'RdnCsv',
        'DoctrineModule',
        'DoctrineORMModule',
        'ZfcBase',
        'ZfcUser',
        'ZfcUserDoctrineORM',
        'ZfcRbac',
        'ZfcAdmin',
        'Application',
        'DtlBase',
        'DtlAdmin',
        'DtlPerson',
        'DtlOffice',
        'DtlUser',
        'DtlProposal',
        'DtlPretender',
        'DtlCustomer',
        'DtlEmployee',
        'DtlEmployeeStatus',
        'DtlShopman',
        'DtlRealtor',
        'DtlSupplier',
        'DtlFinancial',
        'DtlReport',
        'DtlCompany',
        'DtlProduct',
        'DtlBusiness',
        'DtlBank',
        'DtlBankAccount',
        'DtlCurrency',
        'DtlCurrentAccount',
        'DtlDealer',
        'DtlDepartment',
        'DtlDocumentType',
        'DtlPaymentType',
        'DtlAccountingItem',
        'DtlOccupation',
        'DtlRealty',
        'DtlReference',
        'DtlPatrimony',
        'DtlSeller',
        'DtlVehicle',
        'DtlLocation',
        'DtlFile',
        'DtlExport',
        'DtlError'
        ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor'
            ),
        'config_glob_paths' => array('config/autoload/{{,*.}global,{,*.}local}.php')
        )
    );
