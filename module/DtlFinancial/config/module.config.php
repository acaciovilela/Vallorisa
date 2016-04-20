<?php

namespace DtlFinancial;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlFinancial\Controller\Index' => 'DtlFinancial\Factory\IndexFactory',
            'DtlFinancial\Controller\Receivable' => 'DtlFinancial\Factory\ReceivableFactory',
            'DtlFinancial\Controller\Payable' => 'DtlFinancial\Factory\PayableFactory',
            'DtlFinancial\Controller\Revenue' => 'DtlFinancial\Factory\RevenueFactory',
            'DtlFinancial\Controller\Expense' => 'DtlFinancial\Factory\ExpenseFactory',
            'DtlFinancial\Controller\Cash' => 'DtlFinancial\Factory\CashFactory',
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'launch' => 'DtlFinancial\Factory\LaunchViewHelperFactory',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'dtlfinancial_expense_service' => 'DtlFinancial\Factory\ExpenseServiceFactory',
            'dtlfinancial_revenue_service' => 'DtlFinancial\Factory\RevenueServiceFactory',
            'dtlfinancial_cash_service' => 'DtlFinancial\Factory\CashServiceFactory',
            'dtlfinancial_create_receivable' => 'DtlFinancial\Factory\CreateReceivableFactory',
            'dtlfinancial_create_payable' => 'DtlFinancial\Factory\CreatePayableFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlfinancial' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/financial',
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlFinancial\Controller',
                                'controller' => 'Index',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'cash' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/cash',
                                    'defaults' => array(
                                        'controller' => 'DtlFinancial\Controller\Cash',
                                        'action' => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'monthlycashresume' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/monthlycashresume',
                                            'defaults' => array(
                                                'action' => 'monthlycashresume',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'receivable' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/receivable[/:page]',
                                    'constraints' => array(
                                        'page' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'DtlFinancial\Controller\Receivable',
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
                                    'discharge' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/discharge',
                                            'defaults' => array(
                                                'action' => 'discharge',
                                            ),
                                        ),
                                    ),
                                )
                            ),
                            'payable' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/payable[/:page]',
                                    'constraints' => array(
                                        'page' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'DtlFinancial\Controller\Payable',
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
                                    'discharge' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/discharge',
                                            'defaults' => array(
                                                'action' => 'discharge',
                                            ),
                                        ),
                                    ),
                                )
                            ),
                            'expense' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/expense[/:page]',
                                    'defaults' => array(
                                        'controller' => 'DtlFinancial\Controller\Expense',
                                        'constraints' => array(
                                            'page' => '[0-9]*'
                                        ),
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
                                )
                            ),
                            'revenue' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/revenue[/:page]',
                                    'defaults' => array(
                                        'controller' => 'DtlFinancial\Controller\Revenue',
                                        'constraints' => array(
                                            'page' => '[0-9]*'
                                        ),
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
                                )
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'dtlfinancial' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtlfinancial' => array(
                        'label' => 'Financeiro',
                        'route' => 'dtladmin/dtlfinancial',
                        'pages' => array(
                            'receivable' => array(
                                'label' => 'Contas a Receber',
                                'route' => 'dtladmin/dtlfinancial/receivable',
                                'pages' => array(
                                    'add' => array(
                                        'label' => 'Adicionar Conta a Receber',
                                        'route' => 'dtladmin/dtlfinancial/receivable/add',
                                    ),
                                    'edit' => array(
                                        'label' => 'Editar Conta a Receber',
                                        'route' => 'dtladmin/dtlfinancial/receivable/edit',
                                    ),
                                    'delete' => array(
                                        'label' => 'Apagar Conta a Receber',
                                        'route' => 'dtladmin/dtlfinancial/receivable/delete',
                                    ),
                                    'view' => array(
                                        'label' => 'Detalhes da Conta a Receber',
                                        'route' => 'dtladmin/dtlfinancial/receivable/view',
                                    ),
                                    'discharge' => array(
                                        'label' => 'Baixa de Conta',
                                        'route' => 'dtladmin/dtlfinancial/receivable/discharge',
                                    ),
                                ),
                            ),
                            'payable' => array(
                                'label' => 'Contas a Pagar',
                                'route' => 'dtladmin/dtlfinancial/payable',
                                'pages' => array(
                                    'add' => array(
                                        'label' => 'Adicionar Conta a Pagar',
                                        'route' => 'dtladmin/dtlfinancial/payable/add',
                                    ),
                                    'edit' => array(
                                        'label' => 'Editar Conta a Pagar',
                                        'route' => 'dtladmin/dtlfinancial/payable/edit',
                                    ),
                                    'delete' => array(
                                        'label' => 'Apagar Conta a Pagar',
                                        'route' => 'dtladmin/dtlfinancial/payable/delete',
                                    ),
                                    'view' => array(
                                        'label' => 'Detalhes da Conta a Pagar',
                                        'route' => 'dtladmin/dtlfinancial/payable/view',
                                    ),
                                ),
                            ),
                            'revenue' => array(
                                'label' => 'Receitas',
                                'route' => 'dtladmin/dtlfinancial/revenue',
                                'pages' => array(
                                    'add' => array(
                                        'label' => 'Adicionar Receita',
                                        'route' => 'dtladmin/dtlfinancial/revenue/add',
                                    ),
                                    'edit' => array(
                                        'label' => 'Editar Receita',
                                        'route' => 'dtladmin/dtlfinancial/revenue/edit',
                                    ),
                                    'delete' => array(
                                        'label' => 'Apagar Receita',
                                        'route' => 'dtladmin/dtlfinancial/revenue/delete',
                                    ),
                                    'view' => array(
                                        'label' => 'Detalhes da Receita',
                                        'route' => 'dtladmin/dtlfinancial/revenue/view',
                                    ),
                                ),
                            ),
                            'expense' => array(
                                'label' => 'Despesas',
                                'route' => 'dtladmin/dtlfinancial/expense',
                                'pages' => array(
                                    'add' => array(
                                        'label' => 'Adicionar Despesa',
                                        'route' => 'dtladmin/dtlfinancial/expense/add',
                                    ),
                                    'edit' => array(
                                        'label' => 'Editar Despesa',
                                        'route' => 'dtladmin/dtlfinancial/expense/edit',
                                    ),
                                    'delete' => array(
                                        'label' => 'Apagar Despesa',
                                        'route' => 'dtladmin/dtlfinancial/expense/delete',
                                    ),
                                    'view' => array(
                                        'label' => 'Detalhes da Despesa',
                                        'route' => 'dtladmin/dtlfinancial/expense/view',
                                    ),
                                ),
                            ),
                            'cash' => array(
                                'label' => 'Caixa',
                                'route' => 'dtladmin/dtlfinancial/cash',
                                'pages' => array(
                                    'monthlycashresume' => array(
                                        'label' => 'Resumo Detalhado do Mês',
                                        'route' => 'dtladmin/dtlfinancial/cash/monthlycashresume'
                                    )
                                )
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
    ),
    'zfc_rbac' => array(
        'guards' => array(
            'ZfcRbac\Guard\RouteGuard' => array(
                'dtlfinancial*' => ['admin'],
            ),
        ),
    ),
);
