<?php

require_once 'testlib/testlib.php';
require_once 'config/config_books.php';
require_once 'llibre/functions.php';
require_once 'llibre/mysql_options.php';

chdir('prestatgeria');
include 'prestatgeria/lib/bootstrap.php';
$core->init();

$mydatabase = new MySQL_options;
$mydatabase->init();

$mailconf = getEmailParamsFromZikula($mydatabase);
test_mail($mailconf['idApp'], false, $mailconf['environment']);

$env = $mailconf['environment'];
test_ldap(false, $env);

test_session();

// Check main DB
checkMySQL($presta['dbhost'], 3306, $presta['dbname'], $presta['dbuser'], $presta['dbpass'], 'users');

// Check presence of books DB's
$env_db = array (
    'DEV' => 1,
    'INT' => 3,
    'ACC' => 3,
    'PRE' => 3,
    'PRO' => 39,
);

for ($i = 1; $i <= $env_db[$env]; $i++) {
    checkMySQL($presta['dbhost'], 3306, $presta['dbname'] . $i, $presta['dbuser'], $presta['dbpass']);
}

// Check symlinks
echo '<h1>Check symlinks</h1>';
passthru("ls -l $dirroot/centres"); echo '<br />';
passthru("du -skh $dirroot/centres/"); echo '<br /><br />';
passthru("ls -l $dirroot/rss"); echo '<br />';
passthru("du -skh $dirroot/rss/"); echo '<br /><br />';
passthru("ls -l $dirroot/prestatgeria/ztemp"); echo '<br />';
passthru("du -skh $dirroot/prestatgeria/ztemp/"); echo '<br /><br />';
passthru("ls -l $dirroot/pmf/images"); echo '<br />';
passthru("du -skh $dirroot/pmf/images/"); echo '<br /><br />';
passthru("ls -l $dirroot/pmf/templates_c"); echo '<br />';
passthru("du -skh $dirroot/pmf/templates_c/"); echo '<br /><br />';

test_server();
