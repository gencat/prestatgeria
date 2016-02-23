<?php

require_once 'config/env-config.php';

$dbhost = $presta['dbhost'];
$dbuname = $presta['dbuser'];
$dbpass = $presta['dbpass'];
$dbname = $presta['dbname'];
$state = '';

$dbc = new mysqli($dbhost, $dbuname, $dbpass, $dbname);

if ($dbc->connect_errno > 0) {
    $state .= 'Error ' . $dbc->connect_errno . ': ' . $dbc->connect_error;
} else {
    // Charset is not really required, but it's fair setting it
    $dbc->set_charset('utf8');

    $sql = 'SELECT uname FROM users LIMIT 1';

    if (!$result = $dbc->query($sql)) {
        $state .= 'Error ' . $dbc->connect_errno . ': ' . $dbc->connect_error;
    } else {
        $row = $result->fetch_assoc();
        if (!empty($row['uname'])) {
            // If this point is reached, everything is Ok!
            $state .= 'Aplicacio:OK';
        } else {
            $state .= 'No s\'ha trobat cap registre a la taula d\'usuaris';
        }
    }

    $dbc->close();
}

// Check one of the data directories
$dirToCheck = $dirroot . '/centres/';

if (!is_writable($dirToCheck)) {
    $state = ($state == 'Aplicacio:OK') ? '' : $state;
	$state .= "<br />No s'ha pogut accedir al sistema de fitxers muntat via NFS. Reviseu el punt de muntatge: $dirToCheck";
}

echo $state;
