<?php

$dbprefix = 'presta';
$dbnum = 50;

require_once 'includes/pnAPI.php';

pnInit(PN_CORE_ALL);

global $PNConfig;

ini_set('max_execution_time', 86400);

$charset = 'utf8';
$collation = 'utf8_general_ci';

$dbtype = $PNConfig['DBInfo']['default']['dbtype'];
$dbchar = $PNConfig['DBInfo']['default']['dbcharset'];
$dbhost = $PNConfig['DBInfo']['default']['dbhost'];
$dbuser = $PNConfig['DBInfo']['default']['dbuname'];
$dbpass = $PNConfig['DBInfo']['default']['dbpass'];

print 'Actualitzant les bases de dades dels llibres.<br/><br/>';
ob_flush();
flush();

// connect to DB
$dbconn = mysql_connect($dbhost, $dbuser, $dbpass);

for ($i=1;$i<=$dbnum;$i++){

	$dbname = $dbprefix.$i;
	$db = mysql_select_db($dbname);
	
	print "&nbsp&nbsp&nbsp&nbspActualitzant la base de dades " . $dbname . '.<br/><br/>';
	ob_flush();
	flush();
	
	doSQL("ALTER DATABASE $dbname DEFAULT CHARACTER SET = $charset", $dbconn, $feedback);
    doSQL("ALTER DATABASE $dbname DEFAULT COLLATE = $collation", $dbconn, $feedback);
    $result = doSQL('SHOW TABLES', $dbconn, $feedback);
    if ($result) {
		while ($row = mysql_fetch_row($result)) {
	        $table = mysql_real_escape_string($row[0]);
	        
        	print "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspActualitzant la taula " . $table . '.<br/>';
			ob_flush();
			flush();
	        
	        doSQL("ANALYZE TABLE $table", $dbconn, $feedback);
            doSQL("REPAIR TABLE $table", $dbconn, $feedback);
            doSQL("OPTIMIZE TABLE $table", $dbconn, $feedback);
            doSQL("ALTER TABLE $table DEFAULT CHARACTER SET $charset COLLATE $collation", $dbconn, $feedback);
	        doSQL("ALTER TABLE $table CONVERT TO CHARACTER SET $charset COLLATE $collation", $dbconn, $feedback);
		}
    }
}

mysql_close($dbconn);

print "<br/>Ja està!</br>";
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