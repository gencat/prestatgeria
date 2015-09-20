<?php

require_once 'testlib/testlib.php';
require_once 'config/config_books.php';
require_once 'llibre/functions.php';
require_once 'llibre/mysql_options.php';

$mydatabase = new MySQL_options;
$mydatabase->init();

$mailconf = getEmailParamsFromZikula($mydatabase);
test_mail($mailconf['idApp'], false, $mailconf['environment']);

test_ldap(false, $mailconf['environment']);

test_session();

checkMySQL($presta['dbhost'], 3306, $presta['dbname'], $presta['dbuser'], $presta['dbpass'], 'users');

test_server();
