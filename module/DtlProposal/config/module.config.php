<?php

namespace DtlProposal;

return array(
    'controllers' => array(
        'invokables' => array(
            'DtlProposal\Controller\Index' => 'DtlProposal\Factory\Index',
        ),
        'factories' => array(
            'DtlProposal\Controller\Proposal' => 'DtlProposal\Factory\Proposal',
            'DtlProposal\Controller\VehicleProposal' => 'DtlProposal\Factory\VehicleProposal',
            'DtlProposal\Controller\Loan' => 'DtlProposal\Factory\Loan',
            'DtlProposal\Controller\RealtyProposal' => 'DtlProposal\Factory\RealtyProposal',
            'DtlProposal\Controller\RealtyProposalCommission' => 'DtlProposal\Factory\RealtyProposalCommissionFactory',
            'DtlProposal\Controller\CaixaProposal' => 'DtlProposal\Factory\CaixaProposal',
        )
    ),
    'view_helpers' => array(
        'invokables' => array(
            'vehicleProposalForm' => 'DtlProposal\View\Helper\VehicleProposalForm',
            'customerForm' => 'DtlProposal\View\Helper\CustomerForm',
            'customerBankAccountForm' => 'DtlProposal\View\Helper\CustomerBankAccountForm',
            'customerPatrimonyForm' => 'DtlProposal\View\Helper\CustomerPatrimonyForm',
            'customerReferenceForm' => 'DtlProposal\View\Helper\CustomerReferenceForm',
            'customerVehicleForm' => 'DtlProposal\View\Helper\CustomerVehicleForm',
            'proposalForm' => 'DtlProposal\View\Helper\ProposalForm',
            'realtyProposalForm' => 'DtlProposal\View\Helper\RealtyProposalForm',
            'caixaProposalForm' => 'DtlProposal\View\Helper\CaixaProposalForm',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'proposal_session_service' => 'DtlProposal\Service\ProposalSession',
        ),
        'factories' => array(
            'proposal_service' => 'DtlProposal\Factory\ProposalServiceFactory',
            'proposal_search_query' => 'DtlProposal\Factory\ProposalSearchQueryFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlproposal' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/proposal',
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlProposal\Controller',
                                'controller' => 'Index',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'proposal' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/proposal',
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlProposal\Controller',
                                        'controller' => 'Proposal',
                                        'action' => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'listcustomerbankaccount' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/listcustomerbankaccount',
                                            'defaults' => array(
                                                'action' => 'listcustomerbankaccount',
                                            ),
                                        ),
                                    ),
                                    'addcustomerbankaccount' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/addcustomerbankaccount',
                                            'defaults' => array(
                                                'action' => 'addcustomerbankaccount',
                                            ),
                                        ),
                                    ),
                                    'deletecustomerbankaccount' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/deletecustomerbankaccount',
                                            'defaults' => array(
                                                'action' => 'deletecustomerbankaccount',
                                            ),
                                        ),
                                    ),
                                    'listcustomerreference' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/listcustomerreference',
                                            'defaults' => array(
                                                'action' => 'listcustomerreference',
                                            ),
                                        ),
                                    ),
                                    'addcustomerreference' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/addcustomerreference',
                                            'defaults' => array(
                                                'action' => 'addcustomerreference',
                                            ),
                                        ),
                                    ),
                                    'deletecustomerreference' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/deletecustomerreference',
                                            'defaults' => array(
                                                'action' => 'deletecustomerreference',
                                            ),
                                        ),
                                    ),
                                    'listcustomerpatrimony' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/listcustomerpatrimony',
                                            'defaults' => array(
                                                'action' => 'listcustomerpatrimony',
                                            ),
                                        ),
                                    ),
                                    'addcustomerpatrimony' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/addcustomerpatrimony',
                                            'defaults' => array(
                                                'action' => 'addcustomerpatrimony',
                                            ),
                                        ),
                                    ),
                                    'deletecustomerpatrimony' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/deletecustomerpatrimony',
                                            'defaults' => array(
                                                'action' => 'deletecustomerpatrimony',
                                            ),
                                        ),
                                    ),
                                    'listcustomervehicle' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/listcustomervehicle',
                                            'defaults' => array(
                                                'action' => 'listcustomervehicle',
                                            ),
                                        ),
                                    ),
                                    'addcustomervehicle' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/addcustomervehicle',
                                            'defaults' => array(
                                                'action' => 'addcustomervehicle',
                                            ),
                                        ),
                                    ),
                                    'deletecustomervehicle' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/deletecustomervehicle',
                                            'defaults' => array(
                                                'action' => 'deletecustomervehicle',
                                            ),
                                        ),
                                    ),
                                    'calculate' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/calculate',
                                            'defaults' => array(
                                                'action' => 'calculate',
                                            ),
                                        ),
                                    ),
                                    'printHistory' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/printHistory/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*'
                                            ),
                                            'defaults' => array(
                                                'action' => 'printHistory',
                                            ),
                                        ),
                                    ),
                                    'upload' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/upload',
                                            'defaults' => array(
                                                'action' => 'upload',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'vehicle-proposal' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/vehicle-proposal[/:page]',
                                    'constraints' => array(
                                        'page' => '[0-9]*'
                                    ),
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlProposal\Controller',
                                        'controller' => 'VehicleProposal',
                                        'action' => 'index',
                                        'page' => 1
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'pre' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/pre',
                                            'defaults' => array(
                                                'action' => 'pre',
                                            ),
                                        ),
                                    ),
                                    'add' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/add',
                                            'defaults' => array(
                                                'action' => 'add',
                                            ),
                                        ),
                                    ),
                                    'save' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/save',
                                            'defaults' => array(
                                                'action' => 'save',
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'delete',
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'view',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'edit',
                                            ),
                                        ),
                                    ),
                                    'print' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/print/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'print',
                                            ),
                                        ),
                                    ),
                                    'history' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/history/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'history',
                                            ),
                                        ),
                                    ),
                                    'status' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/status/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'status',
                                            ),
                                        ),
                                    ),
                                    'bank' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/bank/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'bank',
                                            ),
                                        ),
                                    ),
                                    'listvehicles' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/listvehicles',
                                            'defaults' => array(
                                                'action' => 'listvehicles',
                                            ),
                                        ),
                                    ),
                                    'addvehicle' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/addvehicle',
                                            'defaults' => array(
                                                'action' => 'addvehicle',
                                            ),
                                        ),
                                    ),
                                    'deletevehicle' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/deletevehicle',
                                            'defaults' => array(
                                                'action' => 'deletevehicle',
                                            ),
                                        ),
                                    ),
                                    'search' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/search',
                                            'defaults' => array(
                                                'action' => 'search',
                                            ),
                                        ),
                                    ),
                                    'calculateValue' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/calculateValue',
                                            'defaults' => array(
                                                'action' => 'calculateValue',
                                            ),
                                        ),
                                    ),
                                    'exportCsv' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/exportCsv',
                                            'defaults' => array(
                                                'action' => 'exportCsv',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'loan' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/loan[/:page]',
                                    'constraints' => array(
                                        'page' => '[0-9]*'
                                    ),
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlProposal\Controller',
                                        'controller' => 'Loan',
                                        'action' => 'index',
                                        'page' => 1
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'pre' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/pre',
                                            'defaults' => array(
                                                'action' => 'pre',
                                            ),
                                        ),
                                    ),
                                    'add' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/add',
                                            'defaults' => array(
                                                'action' => 'add',
                                            ),
                                        ),
                                    ),
                                    'save' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/save',
                                            'defaults' => array(
                                                'action' => 'save',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'edit',
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'delete',
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'view',
                                            ),
                                        ),
                                    ),
                                    'print' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/print/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'print',
                                            ),
                                        ),
                                    ),
                                    'history' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/history/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'history',
                                            ),
                                        ),
                                    ),
                                    'status' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/status/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'status',
                                            ),
                                        ),
                                    ),
                                    'bank' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/bank/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'bank',
                                            ),
                                        ),
                                    ),
                                    'search' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/search',
                                            'defaults' => array(
                                                'action' => 'search',
                                            ),
                                        ),
                                    ),
                                    'exportPdf' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/exportPdf',
                                            'defaults' => array(
                                                'action' => 'exportPdf',
                                            ),
                                        ),
                                    ),
                                    'exportCsv' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/exportCsv',
                                            'defaults' => array(
                                                'action' => 'exportCsv',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'realty-proposal' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/realty-proposal[/:page]',
                                    'constraints' => array(
                                        'page' => '[0-9]*'
                                    ),
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlProposal\Controller',
                                        'controller' => 'RealtyProposal',
                                        'action' => 'index',
                                        'page' => 1
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'pre' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/pre',
                                            'defaults' => array(
                                                'action' => 'pre',
                                            ),
                                        ),
                                    ),
                                    'add' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/add',
                                            'defaults' => array(
                                                'action' => 'add',
                                            ),
                                        ),
                                    ),
                                    'save' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/save',
                                            'defaults' => array(
                                                'action' => 'save',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'edit',
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'delete',
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'view',
                                            ),
                                        ),
                                    ),
                                    'print' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/print/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'print',
                                            ),
                                        ),
                                    ),
                                    'history' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/history/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'history',
                                            ),
                                        ),
                                    ),
                                    'status' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/status/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'status',
                                            ),
                                        ),
                                    ),
                                    'bank' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/bank/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'bank',
                                            ),
                                        ),
                                    ),
                                    'evaluation' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/evaluation/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'evaluation',
                                            ),
                                        ),
                                    ),
                                    'evaluationEdit' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/evaluationEdit/:id/:evalId',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                                'evalId' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'evaluationEdit',
                                            ),
                                        ),
                                    ),
                                    'search' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/search',
                                            'defaults' => array(
                                                'action' => 'search',
                                            ),
                                        ),
                                    ),
                                    'exportCsv' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/exportCsv',
                                            'defaults' => array(
                                                'action' => 'exportCsv',
                                            ),
                                        ),
                                    ),
                                    'calculate' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/calculate',
                                            'defaults' => array(
                                                'action' => 'calculate',
                                            ),
                                        ),
                                    ),
                                    'upload' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/upload',
                                            'defaults' => array(
                                                'action' => 'upload',
                                            ),
                                        ),
                                    ),
                                    'deleteFile' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/deleteFile/:id/:proposalId',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                                'proposalId' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'deleteFile',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'caixa-proposal' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/caixa-proposal[/:page]',
                                    'constraints' => array(
                                        'page' => '[0-9]*'
                                    ),
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlProposal\Controller',
                                        'controller' => 'CaixaProposal',
                                        'action' => 'index',
                                        'page' => 1
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'pre' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/pre',
                                            'defaults' => array(
                                                'action' => 'pre',
                                            ),
                                        ),
                                    ),
                                    'add' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/add',
                                            'defaults' => array(
                                                'action' => 'add',
                                            ),
                                        ),
                                    ),
                                    'save' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/save',
                                            'defaults' => array(
                                                'action' => 'save',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'edit',
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'delete',
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'view',
                                            ),
                                        ),
                                    ),
                                    'print' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/print/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'print',
                                            ),
                                        ),
                                    ),
                                    'history' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/history/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'history',
                                            ),
                                        ),
                                    ),
                                    'status' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/status/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'status',
                                            ),
                                        ),
                                    ),
                                    'listproducts' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/listproducts',
                                            'defaults' => array(
                                                'action' => 'listproducts',
                                            ),
                                        ),
                                    ),
                                    'addproduct' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/addproduct',
                                            'defaults' => array(
                                                'action' => 'addproduct',
                                            ),
                                        ),
                                    ),
                                    'deleteproduct' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/deleteproduct',
                                            'defaults' => array(
                                                'action' => 'deleteproduct',
                                            ),
                                        ),
                                    ),
                                    'search' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/search',
                                            'defaults' => array(
                                                'action' => 'search',
                                            ),
                                        ),
                                    ),
                                    'exportCsv' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/exportCsv',
                                            'defaults' => array(
                                                'action' => 'exportCsv',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'realty-proposal-commission' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/realty-proposal-commission[/:page]',
                                    'constraints' => array(
                                        'page' => '[0-9]*'
                                    ),
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlProposal\Controller',
                                        'controller' => 'RealtyProposalCommission',
                                        'action' => 'index',
                                        'page' => 1
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'add' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/add',
                                            'defaults' => array(
                                                'action' => 'add',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'edit',
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'delete',
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'view',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'DtlProposal' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtlproposal' => array(
                        'label' => 'Propostas',
                        'route' => 'dtladmin/dtlproposal',
                        'pages' => array(
                            'vehicle-proposal' => array(
                                'label' => 'Propostas de Veículos',
                                'route' => 'dtladmin/dtlproposal/vehicle-proposal',
                                'pages' => array(
                                    'pre' => array(
                                        'label' => 'Adicionar Nova Proposta',
                                        'route' => 'dtladmin/dtlproposal/vehicle-proposal/pre',
                                    ),
                                    'add' => array(
                                        'label' => 'Adicionar Nova Proposta',
                                        'route' => 'dtladmin/dtlproposal/vehicle-proposal/add',
                                    ),
                                    'edit' => array(
                                        'label' => 'Editar Proposta',
                                        'route' => 'dtladmin/dtlproposal/vehicle-proposal/edit',
                                    ),
                                    'delete' => array(
                                        'label' => 'Apagar Proposta',
                                        'route' => 'dtladmin/dtlproposal/vehicle-proposal/delete',
                                    ),
                                    'view' => array(
                                        'label' => 'Detalhes da Proposta',
                                        'route' => 'dtladmin/dtlproposal/vehicle-proposal/view',
                                    ),
                                ),
                            ),
                            'loan' => array(
                                'label' => 'Propostas de Empréstimo Consignado',
                                'route' => 'dtladmin/dtlproposal/loan',
                                'pages' => array(
                                    'pre' => array(
                                        'label' => 'Adicionar Nova Proposta',
                                        'route' => 'dtladmin/dtlproposal/loan/pre',
                                    ),
                                    'add' => array(
                                        'label' => 'Adicionar Nova Proposta',
                                        'route' => 'dtladmin/dtlproposal/loan/add',
                                    ),
                                    'edit' => array(
                                        'label' => 'Editar Proposta',
                                        'route' => 'dtladmin/dtlproposal/loan/edit',
                                    ),
                                    'delete' => array(
                                        'label' => 'Apagar Proposta',
                                        'route' => 'dtladmin/dtlproposal/loan/delete',
                                    ),
                                    'view' => array(
                                        'label' => 'Detalhes da Proposta',
                                        'route' => 'dtladmin/dtlproposal/loan/view',
                                    ),
                                ),
                            ),
                            'realty-proposal' => array(
                                'label' => 'Propostas de Venda de Imóveis',
                                'route' => 'dtladmin/dtlproposal/realty-proposal',
                                'pages' => array(
                                    'pre' => array(
                                        'label' => 'Adicionar Nova Proposta',
                                        'route' => 'dtladmin/dtlproposal/realty-proposal/pre',
                                    ),
                                    'add' => array(
                                        'label' => 'Adicionar Nova Proposta',
                                        'route' => 'dtladmin/dtlproposal/realty-proposal/add',
                                    ),
                                    'edit' => array(
                                        'label' => 'Editar Proposta',
                                        'route' => 'dtladmin/dtlproposal/realty-proposal/edit',
                                    ),
                                    'delete' => array(
                                        'label' => 'Apagar Proposta',
                                        'route' => 'dtladmin/dtlproposal/realty-proposal/delete',
                                    ),
                                    'view' => array(
                                        'label' => 'Detalhes da Proposta',
                                        'route' => 'dtladmin/dtlproposal/realty-proposal/view',
                                    ),
                                ),
                            ),
                            'caixa-proposal' => array(
                                'label' => 'Propostas de Produtos Caixa',
                                'route' => 'dtladmin/dtlproposal/caixa-proposal',
                                'pages' => array(
                                    'pre' => array(
                                        'label' => 'Adicionar Nova Proposta',
                                        'route' => 'dtladmin/dtlproposal/caixa-proposal/pre',
                                    ),
                                    'add' => array(
                                        'label' => 'Adicionar Nova Proposta',
                                        'route' => 'dtladmin/dtlproposal/caixa-proposal/add',
                                    ),
                                    'edit' => array(
                                        'label' => 'Editar Proposta',
                                        'route' => 'dtladmin/dtlproposal/caixa-proposal/edit',
                                    ),
                                    'delete' => array(
                                        'label' => 'Apagar Proposta',
                                        'route' => 'dtladmin/dtlproposal/caixa-proposal/delete',
                                    ),
                                    'view' => array(
                                        'label' => 'Detalhes da Proposta',
                                        'route' => 'dtladmin/dtlproposal/caixa-proposal/view',
                                    ),
                                ),
                            ),
                            'realty-proposal-commission' => array(
                                'label' => 'Comissões Valoriza Imóveis',
                                'route' => 'dtladmin/dtlproposal/realty-proposal-commission',
                                'pages' => array(
                                    'add' => array(
                                        'label' => 'Adicionar Comissão',
                                        'route' => 'dtladmin/dtlproposal/realty-proposal-commission/add',
                                    ),
                                    'edit' => array(
                                        'label' => 'Editar Comissão',
                                        'route' => 'dtladmin/dtlproposal/realty-proposal-commission/edit',
                                    ),
                                    'delete' => array(
                                        'label' => 'Apagar Comissão',
                                        'route' => 'dtladmin/dtlproposal/realty-proposal-commission/delete',
                                    ),
                                    'delete' => array(
                                        'label' => 'Editar Avaliação do Imóvel',
                                        'route' => 'dtladmin/dtlproposal/realty-proposal/evaluationEdit',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    )
);
