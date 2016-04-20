<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . '/module'), $isDevMode, null, null, false);

$dbparams = array(
    'hostname' => 'mysql.vallorisa.com.br',
//    'hostname' => 'localhost',
    'port' => '3306',
    'username' => 'vallorisa',
//    'username' => 'root',
    'password' => 'r2d2x3po',
//    'database' => 'vallorisa1',
    'database' => 'vallorisa',
    'options' => array('buffer_results' => true),
);

$conn = array(
    'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
    'host' => $dbparams['hostname'],
    'port' => $dbparams['port'],
    'user' => $dbparams['username'],
    'password' => $dbparams['password'],
    'dbname' => $dbparams['database'],
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
