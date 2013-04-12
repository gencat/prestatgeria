<?php
ini_set('max_execution_time', 86400);

// ******* load zikula core *******
define('_PNINSTALLVER', '1.2.6');
define('_PN_MINUPGVER', '1.1.0');

print 'Actualitzaci&oacute; del Zikula a la versi&oacute; 1.2.6. <br /><br />Aquest proc&eacute;s pot trigar alguns minuts...<br /><br />Si us plau, espereu a que finalitzi.';
ob_flush();
flush();

// include config file for retrieving name of temporary directory
// require_once 'install/modify_config.php';
require_once 'includes/pnAPI.php';
$GLOBALS['PNConfig']['System']['multilingual'] = true;
$GLOBALS['PNConfig']['System']['language_bc'] = false;
$_SESSION['_ZikulaUpgrader']['_ZikulaUpgradeFrom110'] = true;

pnInit(PN_CORE_ALL);

print '<br /><br />Transformaci&oacute; de les taules de la base de dades a utf8...';
ob_flush();
flush();

// ******* Convert tables to utf8 *******
// Some vars needed here.
$converted = $error = false;
$charset = 'utf8';
$collation = 'utf8_general_ci';
// Database info
global $PNConfig;
$dbtype = $PNConfig['DBInfo']['default']['dbtype'];
$dbchar = $PNConfig['DBInfo']['default']['dbcharset'];
$dbhost = $PNConfig['DBInfo']['default']['dbhost'];
$dbuser = $PNConfig['DBInfo']['default']['dbuname'];
$dbpass = $PNConfig['DBInfo']['default']['dbpass'];
$dbname = $PNConfig['DBInfo']['default']['dbname'];
$prefix = $PNConfig['System']['prefix'];

// decode if necessary
if ($PNConfig['DBInfo']['default']['encoded']) {
    $dbuser = base64_decode($dbuser);
    $dbpass = base64_decode($dbpass);
}
// connect to DB
$dbconn = mysql_connect($dbhost, $dbuser, $dbpass);
$db = mysql_select_db($dbname);
if ($db) {
    // alter database characterset and collation
    doSQL("ALTER DATABASE $dbname DEFAULT CHARACTER SET = $charset", $dbconn, $feedback);
    doSQL("ALTER DATABASE $dbname DEFAULT COLLATE = $collation", $dbconn, $feedback);
    $result = doSQL('SHOW TABLES', $dbconn, $feedback);
    if ($result) {
        // alter tables
        while ($row = mysql_fetch_row($result)) {
            $table = mysql_real_escape_string($row[0]);
            if (preg_match('/^' . $prefix . '_/', $table)) {
                doSQL("ANALYZE TABLE $table", $dbconn, $feedback);
                doSQL("REPAIR TABLE $table", $dbconn, $feedback);
                doSQL("OPTIMIZE TABLE $table", $dbconn, $feedback);
                doSQL("ALTER TABLE $table DEFAULT CHARACTER SET $charset COLLATE $collation", $dbconn, $feedback);
                if ($table == "{$prefix}_locations_location") {
                    // delete index
                    doSQL("ALTER TABLE {$prefix}_locations_location DROP INDEX locindex", $dbconn, $feedback);
                }
                doSQL("ALTER TABLE $table CONVERT TO CHARACTER SET $charset COLLATE $collation", $dbconn, $feedback);
                if ($table == "{$prefix}_locations_location") {
                    // recreate index
                    doSQL("ALTER TABLE `{$prefix}_locations_location` ADD INDEX `locindex` (`pn_name`(50),`pn_city`(50),`pn_state`(50),`pn_country`(50))", $dbconn, $feedback);
                }
            }
            print ' .';
            ob_flush();
            flush();
        }
        mysql_close($dbconn);
        // commit changes to config
        global $reg_src, $reg_rep;
        add_src_rep('dbcharset', $charset);
    }
}

// clear errors
unset($_SESSION['PNSV_PNErrorMsg']);
unset($_SESSION['PNSV_PNErrorMsgType']);
unset($_SESSION['PNSV_PNStatusMsg']);


print '<br /><br />Modificaci&oacute; de noms de m&ograve;duls en el men&uacute; horitzotal...';
ob_flush();
flush();

// ******* execute extra sql sentences *******
//update module vhmenu
pnModLoad('iw_vhmenu', 'admin');
$where = "iw_url LIKE '%Tauler%'";
$rows = DBUtil::selectObjectArray('iw_vhmenu', $where, '', '-1', '-1', 'mid');
foreach ($rows as $row) {
    $upgrade = str_replace("Tauler d'administració", 'Admin', $row['url']);
    $where = "iw_mid=" . $row['mid'];
    $items = array('url' => $upgrade);
    DBUtil::updateObject($items, 'iw_vhmenu', $where, 'mid');
}

$where = "iw_url LIKE '%EDcies%'";
$rows = DBUtil::selectObjectArray('iw_vhmenu', $where, '', '-1', '-1', 'mid');
foreach ($rows as $row) {
    $upgrade = str_replace('Not%EDcies', 'News', $row['url']);
    $where = "iw_mid=" . $row['mid'];
    $items = array('url' => $upgrade);
    DBUtil::updateObject($items, 'iw_vhmenu', $where, 'mid');
}

$where = "iw_url LIKE '%module=Intraweb&type=admin&func=filesList%'";
$rows = DBUtil::selectObjectArray('iw_vhmenu', $where, '', '-1', '-1', 'mid');
foreach ($rows as $row) {
    $upgrade = str_replace('module=Intraweb&type=admin&func=filesList', 'module=Files', $row['url']);
    $where = "iw_mid=" . $row['mid'];
    $items = array('url' => $upgrade);
    DBUtil::updateObject($items, 'iw_vhmenu', $where, 'mid');
}

$where = "iw_url LIKE '%VHMen%'";
$rows = DBUtil::selectObjectArray('iw_vhmenu', $where, '', '-1', '-1', 'mid');
foreach ($rows as $row) {
    $upgrade = str_replace('VHMen%FA', 'iw_vhmenu', $row['url']);
    $where = "iw_mid=" . $row['mid'];
    $items = array('url' => $upgrade);
    DBUtil::updateObject($items, 'iw_vhmenu', $where, 'mid');
}

$where = "iw_url LIKE '%iw_agendes%'";
$rows = DBUtil::selectObjectArray('iw_vhmenu', $where, '', '-1', '-1', 'mid');
foreach ($rows as $row) {
    $upgrade = str_replace('iw_agendes', 'iw_messages', $row['url']);
    $where = "iw_mid=" . $row['mid'];
    $items = array('url' => $upgrade);
    DBUtil::updateObject($items, 'iw_vhmenu', $where, 'mid');
}

$where = "iw_url LIKE '%Configuraci%'";
$rows = DBUtil::selectObjectArray('iw_vhmenu', $where, '', '-1', '-1', 'mid');
foreach ($rows as $row) {
    $upgrade = str_replace('Configuraci%F3', 'Settings', $row['url']);
    $where = "iw_mid=" . $row['mid'];
    $items = array('url' => $upgrade);
    DBUtil::updateObject($items, 'iw_vhmenu', $where, 'mid');
}

$where = "iw_url LIKE '%F2duls%'";
$rows = DBUtil::selectObjectArray('iw_vhmenu', $where, '', '-1', '-1', 'mid');
foreach ($rows as $row) {
    $upgrade = str_replace('M%F2duls', 'Modules', $row['url']);
    $where = "iw_mid=" . $row['mid'];
    $items = array('url' => $upgrade);
    DBUtil::updateObject($items, 'iw_vhmenu', $where, 'mid');
}

$where = "iw_url LIKE '%P%E0gines%'";
$rows = DBUtil::selectObjectArray('iw_vhmenu', $where, '', '-1', '-1', 'mid');
foreach ($rows as $row) {
    $upgrade = str_replace('P%E0gines', 'Pages', $row['url']);
    $where = "iw_mid=" . $row['mid'];
    $items = array('url' => $upgrade);
    DBUtil::updateObject($items, 'iw_vhmenu', $where, 'mid');
}
$where = "iw_url LIKE '%Blocs%'";
$rows = DBUtil::selectObjectArray('iw_vhmenu', $where, '', '-1', '-1', 'mid');
foreach ($rows as $row) {
    $upgrade = str_replace('Blocs', 'Blocks', $row['url']);
    $where = "iw_mid=" . $row['mid'];
    $items = array('url' => $upgrade);
    DBUtil::updateObject($items, 'iw_vhmenu', $where, 'mid');
}

$where = "iw_url LIKE '%IWForums%'";
$rows = DBUtil::selectObjectArray('iw_vhmenu', $where, '', '-1', '-1', 'mid');
foreach ($rows as $row) {
    $upgrade = str_replace('IWForums', 'iw_forums', $row['url']);
    $where = "iw_mid=" . $row['mid'];
    $items = array('url' => $upgrade);
    DBUtil::updateObject($items, 'iw_vhmenu', $where, 'mid');
}

$where = "iw_url LIKE '%Agendes%'";
$rows = DBUtil::selectObjectArray('iw_vhmenu', $where, '', '-1', '-1', 'mid');
foreach ($rows as $row) {
    $upgrade = str_replace('Agendes', 'iw_agendas', $row['url']);
    $where = "iw_mid=" . $row['mid'];
    $items = array('url' => $upgrade);
    DBUtil::updateObject($items, 'iw_vhmenu', $where, 'mid');
}

$where = "iw_url LIKE '%Permisos%'";
$rows = DBUtil::selectObjectArray('iw_vhmenu', $where, '', '-1', '-1', 'mid');
foreach ($rows as $row) {
    $upgrade = str_replace('Permisos', 'permissions', $row['url']);
    $where = "iw_mid=" . $row['mid'];
    $items = array('url' => $upgrade);
    DBUtil::updateObject($items, 'iw_vhmenu', $where, 'mid');
}

print '<br /><br />Actualitzaci&oacute; del m&ograve;dul Downloads...';
ob_flush();
flush();

// upgrade module Downloads
$where = "pn_name  = 'Downloads'";
$items = array('version' => '2.4',
			   'state' => 3);
DBUtil::updateObject($items, 'modules', $where, 'id');

// Reset active plugin in xinha
pnModSetVar('scribite', 'xinha_activeplugins', 'N;');

print '<br /><br />Actualitzaci&oacute; de tots el m&ograve;duls instal&middot;lats...';
ob_flush();
flush();

/******* Upgrade all the installed modules *******/
// force load the modules admin API
pnModAPILoad('Modules', 'admin', true);
// regenerate modules list
$filemodules = pnModAPIFunc('Modules', 'admin', 'getfilemodules');
pnModAPIFunc('Modules', 'admin', 'regenerate', array('filemodules' => $filemodules));
$modinfo = pnModGetInfo(pnModGetIDFromName('ObjectData'));
if ($modinfo['state'] == PNMODULE_STATE_UPGRADED) {
    pnModAPIFunc('Modules', 'admin', 'upgrade', array('id' => pnModGetIDFromName('ObjectData')));
}
if (pnModDBInfoLoad('Profile') && !DBUtil::changeTable('user_property')) {
    return false;
}
$filemodules = pnModAPIFunc('Modules', 'admin', 'getfilemodules');
pnModAPIFunc('Modules', 'admin', 'regenerate', array('filemodules' => $filemodules));
// get a list of modules needing upgrading
$newmods = pnModAPIFunc('Modules', 'admin', 'list', array('state' => PNMODULE_STATE_UPGRADED, 'type' => 3));

// Crazy sort to make sure the User's module is upgraded first
$users_flag = false;
$newmodsArray = array();
foreach ($newmods as $mod) {
    if ($mod['name'] == 'Users') {
        $usersModule[] = $mod;
        $users_flag = true;
    } else {
        $newmodsArray[] = $mod;
    }
    print ' .';
    ob_flush();
    flush();
}
if ($users_flag) {
    $newmods = $usersModule;
    foreach ($newmodsArray as $mod) {
        $newmods[] = $mod;
    }
}
$newmods = array_merge($newmods, pnModAPIFunc('Modules', 'admin', 'list', array('state' => PNMODULE_STATE_UPGRADED, 'type' => 2)));
$newmods = array_merge($newmods, pnModAPIFunc('Modules', 'admin', 'list', array('state' => PNMODULE_STATE_UPGRADED, 'type' => 1)));
if (is_array($newmods) && !empty($newmods)) {
    foreach ($newmods as $newmod) {
        ZLanguage::bindModuleDomain($newmod['name']);
        pnModAPIFunc('Modules', 'admin', 'upgrade', array('id' => $newmod['id']));
        print ' .';
        ob_flush();
        flush();
   }
}

// regenerate the modules list to pick up any final changes
// suppress warnings because we did some upgrade black magic which will harmless generate an E_NOTICE
@pnModAPIFunc('Modules', 'admin', 'regenerate');

// regenerate the themes list
pnModAPIFunc('Theme', 'admin', 'regenerate');

// store the recent version in a config var for later usage. This enables us to determine the version we are upgrading from
pnConfigSetVar('Version_Num', PN_VERSION_NUM);
//pnConfigSetVar('language_i18n', ZLanguage::getLanguageCode());
pnConfigSetVar('language_i18n', 'ca');
pnConfigSetVar('language_bc', 0);

// Relogin the admin user to give a proper admin link
SessionUtil::requireSession();


print '<br /><br />Transformaci&oacute; dels camps de la base de dades serialitzats...';
ob_flush();
flush();

// decode if necessary
if ($PNConfig['DBInfo']['default']['encoded']) {
    $dbuser = base64_decode($dbuser);
    $dbpass = base64_decode($dbpass);
}
// connect to DB
$dbconn = mysql_connect($dbhost, $dbuser, $dbpass);
$db = mysql_select_db($dbname);

if ($db) {
	$sql = "SELECT `pn_bid`,`pn_content` FROM `{$prefix}_blocks` WHERE `pn_bkey`='menu';";

	if (!$resul = mysql_query($sql)) die('Error fent SQL:' . $sql);

	while ($arr_resul = mysql_fetch_array($resul)) {
	    $arr_resul[1] = str_replace('P%E0gines', 'Pages', $arr_resul[1]);
            $arr_resul[1] = str_replace('Contingut', 'content', $arr_resul[1]);
            $arr_resul[1] = str_ireplace('Webbox', 'iw_webbox', $arr_resul[1]);
            // comprova si el bloc està malament i en aquest cas el repara
            if (unserialize($arr_resul[1]) === false) {
		// Busca el contigut propiament dit
		$lastpos = strpos($arr_resul[1], 's:7:"content";s:');
		$laststr = mb_substr($arr_resul[1], $lastpos);

		// Salva la primera part de la cadena
		$firststr = substr($arr_resul[1], 0, $lastpos).'s:7:"content";';
		// Elimina s:7:"content";
		$pieces = explode(';', $laststr);
		$pieces = explode(':', $pieces[1]);

		// Elimina s:631:
		array_shift($pieces);
		array_shift($pieces);

		// Reconstrueix la cadena
		$newstr = mb_substr(implode(':', $pieces), 1, -1); // Elimina " i "
		//$newstr = $firststr.'s:'.mb_strlen($newstr).':"'.$newstr.'";}';
		$newstr = $firststr . 's:' . strlen($newstr) . ':"' . $newstr . '";}';
		// Afegeix el bloc a la llista
		$blocs[] = array('id' => $arr_resul[0], 'content' => $newstr);
            }
	}

	foreach ($blocs as $clau => $valor) {
		if (unserialize($valor['content'])) {
			$sql = "update `{$prefix}_blocks` set `pn_content`='" . mysql_real_escape_string($valor['content']) . "' where `pn_bid`='" . $valor['id'] . "';";
			//echo $sql;
			if (!$resul = mysql_query($sql)) die('Error fent SQL:' . $sql);
	   }
	}

	// Extended menu
	// Exemple de text a revisar: s:14:"displaymodules";

	// Localitzar s:
	$sql = "SELECT `pn_bid`,`pn_content` FROM `{$prefix}_blocks` WHERE `pn_bkey`='extmenu';";

	if (!$resul = mysql_query($sql)) die('Error fent SQL:' . $sql);

	// Una iteració per bloc
        while ($arr_resul = mysql_fetch_row($resul)) {
            // Valors inicials
            $pos = 0;
            $prevpos = 0;
            $newtotstr = '';
            $arr_resul[1] = str_replace('P%E0gines', 'Pages', $arr_resul[1]);
            $arr_resul[1] = str_replace('Contingut', 'content', $arr_resul[1]);
            $arr_resul[1] = str_replace('Webbox', 'iw_webbox', $arr_resul[1]);
            if (unserialize($arr_resul[1]) === false) {
                // Cada menu, una iteracio
                while ($pos = mb_strpos($arr_resul[1], 's:', $pos)) {
                    // Conservar la part de la cadena que no es modifica
                    $newtotstr .= mb_substr($arr_resul[1], $prevpos, $pos - $prevpos);

                    // Localitzar la posició del següent :"
                    $posbeg = mb_strpos($arr_resul[1], ':"', $pos) + 2;

                    // Localitzar la posició del següent ";
                    $posend = mb_strpos($arr_resul[1], '";', $posbeg);

                    // Obtenir la subcadena
                    $parlen = $posend - $posbeg;
                    $str = mb_substr($arr_resul[1], $posbeg, $parlen);

                    // Construir la nova subcadena
                    $parlen = strlen($str);
                    $newstr = 's:' . $parlen . ':"' .  $str . '";';

                    // Acumula la nova cadena
                    $newtotstr .= $newstr;

                    // Prepara la nova iteracio
                    $prevpos = $posend + 2;
                    $pos++;
                }
	        // Afegir la part final de la cadena que no es modifica
	        $newtotstr .= mb_substr($arr_resul[1], $prevpos);
	        if (unserialize($newtotstr)) {
		        // Actualitzar BBDD
		        $sql = "update `{$prefix}_blocks` set `pn_content`='" . mysql_real_escape_string($newtotstr) . "' where `pn_bid`='" . $arr_resul[0] . "';";
		        DBUtil::ExecuteSQL ($sql);
	        }
            }
        }

        $modid = pnModGetIDFromName('content');
        $modinfo = pnModGetInfo($modid);
        if($modinfo['state'] == 3){
            // Module content dins del camp con_data
            // Localitzar s:
            $sql = "SELECT `con_id`,`con_data` FROM `{$prefix}_content_content`;";

            if (!$resul = mysql_query($sql)) die('Error fent SQL:' . $sql);
            // Una iteració per bloc
            while ($arr_resul = mysql_fetch_row($resul)) {
                $pos = 0;
                $prevpos = 0;
                $newtotstr = '';
                if (unserialize($arr_resul[1]) === false) {
                    while ($pos = mb_strpos($arr_resul[1], 's:', $pos)) {
            	        if (is_numeric(mb_substr($arr_resul[1], $pos + 2, 1))) {
	                    // Conservar la part de la cadena que no es modifica
                            $newtotstr .= mb_substr($arr_resul[1], $prevpos, $pos - $prevpos);

                            // Localitzar la posició del següent :"
                            $posbeg = mb_strpos($arr_resul[1], ':"', $pos) + 2;

                            // Localitzar la posició del següent ";
                            $posend = mb_strpos($arr_resul[1], '";', $posbeg);

                            // Obtenir la subcadena
                            $parlen = $posend - $posbeg;
                            $str = mb_substr($arr_resul[1], $posbeg, $parlen);

                            // Construir la nova subcadena
                            $parlen = strlen($str);
                            $newstr = 's:' . $parlen . ':"' .  $str . '";';

                            // Acumula la nova cadena
                            $newtotstr .= $newstr;

                            // Prepara la nova iteracio
                            $prevpos = $posend + 2;
                        }
            	        $pos++;
                    }
                    // Afegir la part final de la cadena que no es modifica
                    $newtotstr .= mb_substr($arr_resul[1], $prevpos);
                    if (unserialize($newtotstr)) {
                        // Actualitzar BBDD
                        $sql = "update `{$prefix}_content_content` set `con_data`='".mysql_real_escape_string($newtotstr)."' where `con_id`='".$arr_resul[0]."';";
                        DBUtil::ExecuteSQL ($sql);
                    }
                }
            }
        }
	// module vars
	$sql = "SELECT `pn_id`,`pn_value` FROM `{$prefix}_module_vars` WHERE `pn_value` LIKE '%s%'
		AND 
		(`pn_value` LIKE '%a%'
		OR `pn_value` LIKE '%e%'
		OR `pn_value` LIKE '%i%'
		OR `pn_value` LIKE '%o%'
		OR `pn_value` LIKE '%u%'
		) 
		and `pn_name` <> 'fullcontent'
		and `pn_name` <> 'summarycontent';";


	if (!$resul = mysql_query($sql)) die('Error fent SQL:' . $sql);

	// Una iteració per registre
	while ($arr_resul = mysql_fetch_row($resul)) {
            // Valors inicials
            $pos = 0;
            $prevpos = 0;
            $newtotstr = '';

            // Cada cadena, una iteracio
            while (($pos = mb_strpos($arr_resul[1], 's:', $pos)) !== false) {

                // Conservar la part de la cadena que no es modifica
                $newtotstr .= mb_substr($arr_resul[1], $prevpos, $pos - $prevpos);

                // Localitzar la posició del següent :"
                $posbeg = mb_strpos($arr_resul[1], ':"', $pos) + 2;

                // Localitzar la posició del següent ";
                $posend = mb_strpos($arr_resul[1], '";', $posbeg);
 
                // Obtenir la subcadena
                $parlen = $posend - $posbeg;
                $str = mb_substr($arr_resul[1], $posbeg, $parlen);

                // Construir la nova subcadena
                $parlen = strlen($str);
                $newstr = 's:' . $parlen . ':"' .  $str . '";';

		// Acumula la nova cadena
		$newtotstr .= $newstr;

		// Prepara la nova iteracio
		$prevpos = $posend + 2;
		$pos++;
            }
            // Afegir la part final de la cadena que no es modifica
            $newtotstr .= mb_substr($arr_resul[1], $prevpos);

            if ($newtotstr != $arr_resul[1]) {
                // Actualitzar BBDD
                $sql = "update `{$prefix}_module_vars` set `pn_value`='".mysql_real_escape_string($newtotstr)."' where `pn_id`='".$arr_resul[0]."';";
                DBUtil::ExecuteSQL ($sql);
            }
	}

	// Altres consultes i modificacions
	pnModLoad('iw_vhmenu', 'admin');
	$where = "iw_url LIKE '%Perfil%'";
	$rows = DBUtil::selectObjectArray('iw_vhmenu', $where, '', '-1', '-1', 'mid');
	foreach ($rows as $row) {
	    $upgrade = str_replace('Perfil', 'Profile', $row['url']);
	    $where = "iw_mid=" . $row['mid'];
	    $items = array('url' => $upgrade);
	    DBUtil::updateObject($items, 'iw_vhmenu', $where, 'mid');
	}
	$sql = "update `{$prefix}_module_vars` set pn_value = '" . 's:55:"a:1:{i:0;a:2:{s:3:"gid";s:1:"2";s:5:"quota";s:2:"-1";}}";' . "' where pn_modname='Files' AND pn_name='groupsQuota'";
	DBUtil::ExecuteSQL ($sql);
	$sql = "update `{$prefix}_module_vars` set pn_value = '" . 's:161:"À,Á,Â,Ã,Å,à,á,â,ã,å,Ò,Ó,Ô,Õ,Ø,ò,ó,ô,õ,ø,È,É,Ê,Ë,è,é,ê,ë,Ç,ç,Ì,Í,Î,Ï,ì,í,î,ï,Ù,Ú,Û,ù,ú,û,ÿ,Ñ,ñ,ß,ä,Ä,ö,Ö,ü,Ü";' . "' where pn_modname='/PNConfig' AND pn_name='permasearch'";
	DBUtil::ExecuteSQL ($sql);

	// module url
	$sql = "update `{$prefix}_modules` set pn_url=pn_name;";
	DBUtil::ExecuteSQL ($sql);
}



print '<div style="color:green;"><br /><br /><br />El proc&eacute;s ha finalitzat correctament.</div>';
print '<div style="color:green;"><a href="index.php">V&eacute;s a la intranet</a></div>';
ob_flush();
flush();
			  
function doSQL($sql, $resource, &$feedback)
{
    $result = mysql_query($sql, $resource);
    if (!$result) {
        $feedback .= '<li class="failed">' . $sql . "</li>\n";
        $feedback .= '<li class="failed">' . mysql_error($resource) . "</li>\n";
    } else {
        $feedback .= '<li class="passed">' . $sql . "</li>\n";
    }
    return $result;
}

function upgrade_clear_caches()
{
    pnModAPIFunc('pnRender', 'user', 'clear_compiled');
    pnModAPIFunc('pnRender', 'user', 'clear_cache');
    pnModAPIFunc('Theme', 'user', 'clear_compiled');
    pnModAPIFunc('Theme', 'user', 'clear_cache');
}

// Setup various searches and replaces
// Scott Kirkwood
function add_src_rep($key, $rep)
{
    global $reg_src, $reg_rep;
    // Note: /x is to permit spaces in regular expressions
    // Great for making the reg expressions easier to read
    // Ex: $PNConfig['foo'] = stripslashes("bar");
    $reg_src[] = "/ \['$key'\] \s* = \s* stripslashes\( (\' | \") (.*) \\1 \); /x";
    $reg_rep[] = "['$key'] = stripslashes(\\1$rep\\1);";
    // Ex. $PNConfig['System']['tabletype']   = 'myisam';
    $reg_src[] = "/ \['$key'\] \s* = \s* (\' | \") (.*) \\1 ; /x";
    $reg_rep[] = "['$key'] = '$rep';";
    // Ex. $PNConfig['System']['development'] = 1;
    $reg_src[] = "/ \['$key'\] \s* = \s* (\d*\.?\d*) ; /x";
    $reg_rep[] = "['$key'] = $rep;";
}
