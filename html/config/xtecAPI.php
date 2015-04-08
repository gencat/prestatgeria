<?php

if (file_exists('../prestatgeria/config/config.php')) {
    // Regular access
    include_once '../prestatgeria/config/config.php';
} else {
    // Access from file manager
    include_once '../../../../prestatgeria/config/config.php';
}

//Connect to data base
function connect($db) {
    global $ZConfig;
    $database = $db;
    $server = mysql_connect($ZConfig['DBInfo']['databases']['default']['host'], $ZConfig['DBInfo']['databases']['default']['user'], $ZConfig['DBInfo']['databases']['default']['password']) or die(mysql_error());
    $connection = mysql_select_db($db, $server);
    return $server;
}

function getSchool($schoolCode) {
    global $ZConfig;
    $connection = connect($ZConfig['DBInfo']['databases']['default']['dbname']);
    $sql = "SELECT schoolId FROM books_schools WHERE schoolCode = '$schoolCode'";
    $rs = mysql_query($sql);
    $schoolId = mysql_result($rs, 0, 0);
    if (!$rs) {
        mysql_close($connection);
        return false;
    }
    mysql_close($connection);
    return $schoolId;
}

function getSchoolInfo($schoolCode) {
    global $ZConfig;
    $connection = connect($ZConfig['DBInfo']['databases']['default']['dbname']);
    $sql = "SELECT schoolType, schoolName FROM books_schools WHERE schoolCode = '$schoolCode'";
    $rs = mysql_query($sql);
    $values = array('schoolType' => mysql_result($rs, 0, 0),
        'schoolName' => mysql_result($rs, 0, 1));
    if (!$rs) {
        mysql_close($connection);
        return false;
    }
    mysql_close($connection);
    return $values;
}

function getBook($bookId) {
    global $ZConfig;
    $connection = connect($ZConfig['DBInfo']['databases']['default']['dbname']);
    $sql = "SELECT bookId, bookState FROM books WHERE bookId = $bookId";
    $rs = mysql_query($sql);
    $bookId = mysql_result($rs, 0, 0);
    $bookState = mysql_result($rs, 0, 1);
    if (!$rs) {
        mysql_close($connection);
        return false;
    }
    mysql_close($connection);
    if ($bookState < 0) {
        echo 'El llibre no est&agrave; activat';
        return false;
    }
    return $bookId;
}

function getBookInfo($bookId) {
    global $ZConfig;
    $connection = connect($ZConfig['DBInfo']['databases']['default']['dbname']);
    $sql = "SELECT bookTitle FROM books WHERE bookId = $bookId";
    $rs = mysql_query($sql);
    $values = array('bookTitle' => mysql_result($rs, 0, 0));
    if (!$rs) {
        mysql_close($connection);
        return false;
    }
    mysql_close($connection);
    if ($bookState < 0) {
        return false;
    }
    return $values;
}

function countVisit($bookId) {
    global $ZConfig;
    $connection = connect($ZConfig['DBInfo']['databases']['default']['dbname']);
    $sql = "UPDATE books SET bookHits = bookHits + 1, bookLastVisit = '" . time() . "' WHERE bookId = $bookId";
    $rs = mysql_query($sql);
    $bookId = mysql_result($rs, 0, 0);
    if (!$rs) {
        mysql_close($connection);
        return false;
    }
    mysql_close($connection);
    return $bookId;
}

/* Sincronize number of pages
 * 
 */

function updateBookPages($prefix, $database) {
    //count the number of aproved pages
    $connection = connect($database);
    //get book pages
    $sql = "SELECT count(*) FROM " . $prefix . "_words WHERE approved='Y'";
    $rs = mysql_query($sql);
    $pages = mysql_result($rs, 0, 0);
    if (!$rs) {
        mysql_close($connection);
        return false;
    }
    mysql_close($connection);
    //set the number obtained
    global $ZConfig;
    $connection = connect($ZConfig['DBInfo']['databases']['default']['dbname']);
    $book = explode('_', $prefix);
    $bookId = $book[1];
    $sql = "UPDATE books SET bookPages = $pages WHERE bookId = $bookId";
    $rs = mysql_query($sql);
    $bookId = mysql_result($rs, 0, 0);
    if (!$rs) {
        mysql_close($connection);
        return false;
    }
    mysql_close($connection);
    return $bookId;
}

function editLastEntryBook($bookId) {
    global $ZConfig;
    $connection = connect($ZConfig['DBInfo']['databases']['default']['dbname']);
    $sql = "UPDATE books SET lastEntry = '" . time() . "' WHERE bookId = '$bookId'";
    $rs = mysql_query($sql);
    if (!$rs) {
        mysql_close($connection);
        return false;
    }
    mysql_close($connection);
    return $bookId;
}

//Gets the last entries from a book
function bookEntries($args) {
    extract($args);
    $table = $args['schoolCode'] . '_' . $args['bookId'] . '_words';
    $table1 = $args['schoolCode'] . '_' . $args['bookId'] . '_contents';
    $schoolId = getSchool($args['schoolCode']);
    $num = floor($schoolId / 50) + 1;
    global $ZConfig;
    $database = $ZConfig['DBInfo']['databases']['default']['dbname'] . $num;
    $connection = connect($database);
    $sql = "SELECT * FROM $table, $table1
			WHERE `approved`='Y'
			AND $table.contentsid=$table1.recno
			AND $table1.permissions<>'none'
			ORDER BY updated desc limit 0,$args[number];";
    $rs = mysql_query($sql);
    if (!$rs) {
        mysql_close($connection);
        return false;
    }
    $values = array();
    while ($row = mysql_fetch_array($rs)) {
        $values[] = array('title' => $row['title'], 'updated' => $row['updated'], 'comment' => $row['comment'], 'id' => $row['id'], 'contentsid' => $row['contentsid']);
    }
    mysql_close($connection);
    return $values;
}

function generateRss($prefix) {
    global $ZConfig;
    $book = explode('_', $prefix);
    //Gets the last entries for the book
    $bookEntries = bookEntries(array('schoolCode' => $book[0],
        'bookId' => $book[1],
        'number' => 15));
    $schoolInfo = getSchoolInfo($book[0]);
    $bookInfo = getBookInfo($book[1]);
    $siteURL = $booksBaseURL;
    //Calc the actual date in RFC2820 format
    $date = date("r", time());
    $file = '../rss/' . $prefix . '.xml';
    $f = fopen($file, 'w');
    fwrite($f, "<?xml version = \"1.0\" encoding=\"iso-8859-1\"?>\r\n");
    fwrite($f, "<rss version=\"2.0\">\r\n");
    fwrite($f, "<channel>\r\n");
    fwrite($f, "<title>" . $bookInfo['bookTitle'] . "</title>\r\n");
    fwrite($f, "<link>" . $siteURL . "</link>\r\n");
    fwrite($f, "<description>" . $schoolInfo['schoolType'] . ' ' . $schoolInfo['schoolName'] . " - La Prestatgeria de la XTEC</description>\r\n");
    fwrite($f, "<language>ca</language>\r\n");
    fwrite($f, "<copyright>Departament d'Ensenyaments</copyright>\r\n");
    fwrite($f, "<pubDate>");
    fwrite($f, $date);
    fwrite($f, "</pubDate>\r\n");
    fwrite($f, "<lastBuildDate>");
    fwrite($f, $date);
    fwrite($f, "</lastBuildDate>\r\n");
    fwrite($f, "<image>\r\n");
    fwrite($f, "<title>Logo Prestatgeria</title>\r\n");
    fwrite($f, "<url>" . $siteURL . "images/logopres.gifs</url>\r\n");
    fwrite($f, "<link>" . $siteURL . "</link>\r\n");
    fwrite($f, "<description>Logo de la prestatgeria digital</description>\r\n");
    fwrite($f, "</image>\r\n");
    foreach ($bookEntries as $bookEntry) {
        fwrite($f, "<item>\r\n");
        fwrite($f, "<title>");
        fwrite($f, $bookEntry['title']);
        fwrite($f, "</title>\r\n");
        fwrite($f, "<link>");
        fwrite($f, $siteURL . $prefix . '/llibre/index.php?section=' . $bookEntry['contentsid'] . '&amp;page=-1');
        fwrite($f, "</link>\r\n");
        fwrite($f, "<description><![CDATA[");
        fwrite($f, $bookEntry['comment']);
        fwrite($f, "]]></description>\r\n");
        fwrite($f, "<pubDate>");
        fwrite($f, $bookEntry['updated']);
        fwrite($f, "</pubDate>\r\n");
        fwrite($f, "</item>\r\n");
    }
    fwrite($f, "</channel>\r\n");
    fwrite($f, "</rss>\r\n");
    fclose($f);
}

function checkSession() {
    // get session information
    global $ZConfig;
    $sessid = $_COOKIE['zkllibres']; // if the book aplication would be a zikula module it could be solved with the global _PNSession
    $connection = connect($ZConfig['DBInfo']['databases']['default']['dbname']);
    // get user identity from session
    $sql = "SELECT uid FROM session_info WHERE sessid = '$sessid'";
    $rs = mysql_query($sql);
    $uid = mysql_result($rs, 0, 0);

    if (!$rs) {
        mysql_close($connection);
        return false;
    }
    // get username from user id
    $sql = "SELECT uname FROM users WHERE uid = $uid";
    $rs = mysql_query($sql);
    $uname = mysql_result($rs, 0, 0);
    if (!$rs) {
        mysql_close($connection);
        return false;
    }
    mysql_close($connection);
    return $uname;
}

function editBook($bookId, $bookTitle, $bookLang) {
    global $ZConfig;
    $connection = connect($ZConfig['DBInfo']['databases']['default']['dbname']);
    $sql = "UPDATE books SET bookTitle = '" . mysql_real_escape_string($bookTitle, $connection) . "', bookLang = '$bookLang' WHERE bookId = $bookId";
    $rs = mysql_query($sql);
    if (!$rs) {
        mysql_close($connection);
        return false;
    }
    mysql_close($connection);
    return $bookId;
}
