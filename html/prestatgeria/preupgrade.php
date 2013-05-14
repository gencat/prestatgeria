<?php

/**
 * Open a connection to the administration database
 *
 * @return Connection handler
 */
// global $ZConfig;
$preupgradeError = false;

function connectdb() {
    require_once('config/config.php');
    global $ZConfig;

// print $ZConfig['DBInfo']['databases']['default']['host'] . ':' . '80' . ' - ' . $ZConfig['DBInfo']['databases']['default']['user'] . ' - ' . $ZConfig['DBInfo']['databases']['default']['password'] . '<br />';

    if (!$con = mysql_connect($ZConfig['DBInfo']['databases']['default']['host'], $ZConfig['DBInfo']['databases']['default']['user'], $ZConfig['DBInfo']['databases']['default']['password']))
        return false;
    if (!mysql_select_db($ZConfig['DBInfo']['databases']['default']['dbname'], $con))
        return false;
    return $con;
}

if (!$con = connectdb())
    die('connection failed' . "\n");

$commands = array();
$prefix = 'zk';

// eliminem el prefix de totes les taules i substituim les cadenes iw_ per IW
$sql = "show tables";

if (!$result = mysql_query($sql, $con))
    die('SQL: ' . substr($sql, 0, 70) . ' - ERROR: ' . mysql_error() . "\n\n");


while ($fila = mysql_fetch_array($result, MYSQL_NUM)) {
    $newname = str_replace($prefix . '_', '', $fila[0]);
    if ($newname != $fila[0]) {
        $commands[] = "RENAME TABLE " . $fila[0] . " TO " . $newname;
    }
}

// rename theme name from iw_shelf to Shelf in module_vars table
$commands[] = "UPDATE module_vars SET pn_value = 's:5:\"Shelf\";' WHERE pn_name='Default_Theme' and pn_modname='/PNConfig';";
$commands[] = "UPDATE themes SET pn_name = 'Shelf',pn_directory = 'Shelf' WHERE pn_name='iw_shelf';";

// rename module name in modules table
$commands[] = "UPDATE modules SET pn_name = 'Books', pn_directory = 'Books', pn_url = 'Books' WHERE pn_name='books';";
$commands[] = "UPDATE modules SET pn_name = 'IWwebbox', pn_directory = 'IWwebbox', pn_url = 'IWwebbox' WHERE pn_name='iw_webbox';";
$commands[] = "UPDATE modules SET pn_name = 'AuthLDAP', pn_directory = 'AuthLDAP', pn_url = 'AuthLDAP', pn_displayname ='AuthLDAP' WHERE pn_name='iw_AuthLDAP';";
$commands[] = "UPDATE modules SET pn_name = 'XtecMailer', pn_directory = 'XtecMailer', pn_url = 'XtecMailer' WHERE pn_name='advMailer';";

// add module AuthLDAP events and variables in module_vars table
$commands[] = "INSERT INTO module_vars (`pn_modname`, `pn_name`, `pn_value`) VALUES
('AuthLDAP', 'authldap_serveradr', 's:25:\"xoidpro.educacio.intranet\";'),
('AuthLDAP', 'authldap_basedn', 's:23:\"cn=users,dc=xtec,dc=cat\";'),
('AuthLDAP', 'authldap_bindas', 's:0:\"\";'),
('AuthLDAP', 'authldap_bindpass', 's:0:\"\";'),
('AuthLDAP', 'authldap_searchdn', 's:23:\"cn=users,dc=xtec,dc=cat\";'),
('AuthLDAP', 'authldap_searchattr', 's:2:\"cn\";'),
('AuthLDAP', 'authldap_protocol', 's:1:\"3\";'),
('AuthLDAP', 'authldap_pnldap', 'N;'),
('AuthLDAP', 'authldap_hash_method', 's:4:\"none\";'),
('/EventHandlers', 'AuthLDAP', 'a:1:{i:0;a:3:{s:9:\"eventname\";s:28:\"module.users.ui.login.failed\";s:8:\"callable\";a:2:{i:0;s:18:\"AuthLDAP_Listeners\";i:1;s:19:\"tryAuthLDAPListener\";}s:6:\"weight\";i:10;}}'),
('XtecMailer', 'enabled', 's:1:\"1\";'),
('XtecMailer', 'idApp', 's:9:\"PRESTATGE\";'),
('XtecMailer', 'replyAddress', 's:29:\"prestatgeria-noreply@xtec.cat\";'),
('XtecMailer', 'sender', 's:8:\"educacio\";'),
('XtecMailer', 'environment', 's:3:\"PRO\";'),
('XtecMailer', 'contenttype', 's:1:\"2\";'),
('XtecMailer', 'log', 's:0:\"\";'),
('XtecMailer', 'debug', 's:0:\"\";'),
('XtecMailer', 'logpath', 's:0:\"\";'),
('/EventHandlers', 'XtecMailer', 'a:1:{i:0;a:3:{s:9:\"eventname\";s:29:\"module.mailer.api.sendmessage\";s:8:\"callable\";a:2:{i:0;s:20:\"XtecMailer_Listeners\";i:1;s:8:\"sendMail\";}s:6:\"weight\";i:10;}}');";

// remove unnecessary module_vars records
$commands[] = "DELETE FROM module_vars where pn_modname='advMailer'";
$commands[] = "DELETE FROM module_vars where pn_modname='iw_AuthLDAP'";
$commands[] = "DELETE FROM module_vars where pn_modname='pnRender'";

// change iw_webbox table name
$commands[] = "RENAME TABLE iw_webbox TO IWwebbox";

// rename module_vars where necessary
$commands[] = "UPDATE module_vars SET pn_modname = 'Books' WHERE pn_modname = 'books';";
$commands[] = "UPDATE module_vars SET pn_modname = 'IWwebbox' WHERE pn_modname = 'iw_webbox';";

// rename blocks names in blocks table
$blocksName = array('lastEntries',
    'mostPages',
    'mostReaded',
    'cloud',
    'newBooks',
    'activationNotify',
    'myBooks',
    'mainmenu',
    'myPrefered');

foreach ($blocksName as $bname) {
    $commands[] = "UPDATE blocks SET pn_bkey = '" . ucfirst($bname) . "' WHERE pn_bkey='" . $bname . "'";
}

foreach ($commands as $sql) {
    if (!$result = mysql_query($sql, $con))
        die('SQL: ' . substr($sql, 0, 70) . ' - ERROR: ' . mysql_error() . "\n\n");
}

// launch zikula upgrader
header('location:upgrade.php');
