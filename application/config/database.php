<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
$active_group = 'default';
$query_builder  = TRUE;
define('ASK2_CHARSET', 'UTF-8');
define('ASK2_VERSION', '3.7');
define('ASK2_RELEASE', '20180402');
$db['default'] =array (
  'dsn' => '',
  'hostname' => '127.0.0.1',
  'username' => 'root',
  'password' => 'root',
  'database' => 'whatsns',
  'dbdriver' => 'mysqli',
  'dbprefix' => 'whatsns_',
  'pconnect' => false,
  'db_debug' => false,
  'cache_on' => true,
  'cachedir' => '',
  'char_set' => 'utf8',
  'dbcollat' => 'utf8_general_ci',
  'swap_pre' => '',
  'encrypt' => false,
  'compress' => false,
  'stricton' => false,
  'failover' => 
  array (
  ),
  'save_queries' => true,
);
?>