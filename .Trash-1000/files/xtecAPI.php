<?php

/** Integració **/
include('/dades/presta/html/config/config.php');
define('_SITEDNS', 'http://pwc-int.educacio.intranet/prestatgeria/');

/** Acceptació **/
// include('/dades/presta/html/config/config.php');
// define('_SITEDNS', 'http://pwc-acc.educacio.intranet/prestatgeria/');

/** Producció **/
// include('/dades/presta/html/config/config.php');
// define('_SITEDNS', 'http://apliense.xtec.cat/prestatgeria');

//Connect to data base
function connect($db){
	global $PNConfig;
	$database = $db;
	$server = mysql_connect($PNConfig['DBInfo']['default']['dbhost'], $PNConfig['DBInfo']['default']['dbuname'], $PNConfig['DBInfo']['default']['dbpass']) or die(mysql_error());
	$connection = mysql_select_db($db, $server);
	return $server;
}

function getSchool($schoolCode){
	global $PNConfig;
	$connection = connect($PNConfig['DBInfo']['default']['dbname']);
	$sql = "SELECT schoolId FROM ".$PNConfig['System']['prefix']."_books_schools WHERE schoolCode = '$schoolCode'";
	$rs = mysql_query($sql);
	$schoolId = mysql_result($rs,0,0);	
	if(!$rs){
		mysql_close($connection);
		return false;
	}
	mysql_close($connection);
	return $schoolId;
}

function getSchoolInfo($schoolCode){
	global $PNConfig;
	$connection = connect($PNConfig['DBInfo']['default']['dbname']);
	$sql = "SELECT schoolType, schoolName FROM ".$PNConfig['System']['prefix']."_books_schools WHERE schoolCode = '$schoolCode'";
	$rs = mysql_query($sql);
	$values = array('schoolType' => mysql_result($rs,0,0),
					'schoolName' => mysql_result($rs,0,1));	
	if(!$rs){
		mysql_close($connection);
		return false;
	}
	mysql_close($connection);
	return $values;
}

function getBook($bookId){
	global $PNConfig;
	$connection = connect($PNConfig['DBInfo']['default']['dbname']);
	$sql = "SELECT bookId, bookState FROM " . $PNConfig['System']['prefix']."_books WHERE bookId = $bookId";
	$rs = mysql_query($sql);
	$bookId = mysql_result($rs,0,0);
    $bookState = mysql_result($rs,0,1);
	if(!$rs){
		mysql_close($connection);
		return false;
	}
	mysql_close($connection);
    if($bookState < 0){
        return false;
    }
	return $bookId;
}

function getBookInfo($bookId){
	global $PNConfig;
	$connection = connect($PNConfig['DBInfo']['default']['dbname']);
	$sql = "SELECT bookTitle FROM " . $PNConfig['System']['prefix'] . "_books WHERE bookId = $bookId";
	$rs = mysql_query($sql);
	$values = array('bookTitle' =>mysql_result($rs,0,0));
	if(!$rs){
		mysql_close($connection);
		return false;
	}
	mysql_close($connection);
    if($bookState < 0){
        return false;
    }
	return $values;
}

function countVisit($bookId){
	global $PNConfig;
	$connection = connect($PNConfig['DBInfo']['default']['dbname']);
    $sql = "UPDATE " . $PNConfig['System']['prefix'] . "_books SET bookHits = bookHits + 1, bookLastVisit = '" . time() . "' WHERE bookId = $bookId";
	$rs = mysql_query($sql);
	$bookId = mysql_result($rs,0,0);	
	if(!$rs){
		mysql_close($connection);
		return false;
	}
	mysql_close($connection);
	return $bookId;
}

/* Sincronize number of pages
 * 
 */
function updateBookPages($prefix, $database){
	//count the number of aproved pages
	$connection = connect($database);
	//get book pages
	$sql = "SELECT count(*) FROM ". $prefix . "_words WHERE approved='Y'";
	$rs = mysql_query($sql);
	$pages = mysql_result($rs,0,0);
	if(!$rs){
		mysql_close($connection);
		return false;
	}
	mysql_close($connection);
	//set the number obtained
	global $PNConfig;
	$connection = connect($PNConfig['DBInfo']['default']['dbname']);
	$book = explode('_',$prefix);
	$bookId = $book[1];
	$sql = "UPDATE ".$PNConfig['System']['prefix']."_books SET bookPages = $pages WHERE bookId = $bookId";
	$rs = mysql_query($sql);
	$bookId = mysql_result($rs,0,0);	
	if(!$rs){
		mysql_close($connection);
		return false;
	}
	mysql_close($connection);
	return $bookId;
}

function editLastEntryBook($bookId){
    global $PNConfig;
	$connection = connect($PNConfig['DBInfo']['default']['dbname']);
	$sql = "UPDATE " . $PNConfig['System']['prefix'] . "_books SET lastEntry = '" . time() . "' WHERE bookId = '$bookId'";
	$rs = mysql_query($sql);
	if(!$rs){
		mysql_close($connection);
		return false;
	}
	mysql_close($connection);
	return $bookId;
}

//Gets the last entries from a book
function bookEntries($args){
	extract($args);
	$table = $args['schoolCode'] . '_' . $args['bookId'] . '_words';
	$table1 = $args['schoolCode'] . '_' . $args['bookId'] . '_contents';
	$schoolId = getSchool($args['schoolCode']);
	$num = floor($schoolId/50)+1;
	global $PNConfig;
	$database = $PNConfig['DBInfo']['default']['dbname'] . $num;
	$connection = connect($database);
	$sql="SELECT * FROM $table, $table1
			WHERE `approved`='Y'
			AND $table.contentsid=$table1.recno
			AND $table1.permissions<>'none'
			ORDER BY updated desc limit 0,$args[number];";
	$rs=mysql_query($sql);		
	if(!$rs){		
		mysql_close($connection);
		return false;
	}
	$values=array();
	while ($row = mysql_fetch_array($rs)) {
		$values[]=array('title'=>$row['title'],'updated'=>$row['updated'],'comment'=>$row['comment'],'id'=>$row['id'],'contentsid'=>$row['contentsid']);   
	}
	mysql_close($connection);
	return $values;
}
	
function generateRss($prefix){
	global $PNConfig;
	$book = explode('_',$prefix);
	//Gets the last entries for the book
	$bookEntries = bookEntries(array('schoolCode' => $book[0],
										'bookId' => $book[1],
										'number' => 15));
	$schoolInfo = getSchoolInfo($book[0]);
	$bookInfo = getBookInfo($book[1]);
    $siteURL = _SITEDNS;
	//Calc the actual date in RFC2820 format
	$date = date("r",time());
	$file = '../rss/' . $prefix . '.xml';
	$f = fopen($file,'w');
	fwrite($f,"<?xml version = \"1.0\" encoding=\"iso-8859-1\"?>\r\n");
	fwrite($f,"<rss version=\"2.0\">\r\n");
	fwrite($f,"<channel>\r\n");
	fwrite($f,"<title>" . $bookInfo['bookTitle'] . "</title>\r\n");
	fwrite($f,"<link>" . $siteURL . "</link>\r\n");
	fwrite($f,"<description>" . $schoolInfo['schoolType'] . ' ' . $schoolInfo['schoolName'] . " - La Prestatgeria de la XTEC</description>\r\n");
	fwrite($f,"<language>ca</language>\r\n");
	fwrite($f,"<copyright>Departament d'Ensenyament</copyright>\r\n");
	fwrite($f,"<pubDate>");
	fwrite($f,$date);
	fwrite($f,"</pubDate>\r\n");
	fwrite($f,"<lastBuildDate>");
	fwrite($f,$date);
	fwrite($f,"</lastBuildDate>\r\n");
	fwrite($f,"<image>\r\n");
	fwrite($f,"<title>Logo Prestatgeria</title>\r\n");
	fwrite($f,"<url>" . $siteURL . "images/logopres.gifs</url>\r\n");
	fwrite($f,"<link>" . $siteURL . "</link>\r\n");
	fwrite($f,"<description>Logo de la prestatgeria digital</description>\r\n");
	fwrite($f,"</image>\r\n");		
	foreach($bookEntries as $bookEntry){
		fwrite($f,"<item>\r\n");
		fwrite($f,"<title>");
		fwrite($f,$bookEntry['title']);
		fwrite($f,"</title>\r\n");
		fwrite($f,"<link>");
		fwrite($f,$siteURL . $prefix . '/llibre/index.php?section=' . $bookEntry['contentsid'] . '&amp;page=-1');
		fwrite($f,"</link>\r\n");
		fwrite($f,"<description><![CDATA[");
		fwrite($f,$bookEntry['comment']);
		fwrite($f,"]]></description>\r\n");
		fwrite($f,"<pubDate>");
		fwrite($f,$bookEntry['updated']);
		fwrite($f,"</pubDate>\r\n");
		fwrite($f,"</item>\r\n");			
	}
	fwrite($f,"</channel>\r\n");
	fwrite($f,"</rss>\r\n");
	fclose($f);
}

function checkSession(){
    // get session information
    global $PNConfig;
    $sessid = $_COOKIE['zkllibres']; // if the book aplication would be a zikula module it could be solved with the global _PNSession
	$connection = connect($PNConfig['DBInfo']['default']['dbname']);
    // get user identity from session
	$sql = "SELECT pn_uid FROM " . $PNConfig['System']['prefix']."_session_info WHERE pn_sessid = '$sessid'";
	$rs = mysql_query($sql);
	$uid = mysql_result($rs,0,0);
    if(!$rs){
		mysql_close($connection);
		return false;
	}
    // get username from user id
	$sql = "SELECT pn_uname FROM " . $PNConfig['System']['prefix']."_users WHERE pn_uid = $uid";
	$rs = mysql_query($sql);
	$uname = mysql_result($rs,0,0);
    if(!$rs){
		mysql_close($connection);
		return false;
	}
	mysql_close($connection);
	return $uname;
}

function editBook($bookId, $bookTitle, $bookLang){
    global $PNConfig;
	$connection = connect($PNConfig['DBInfo']['default']['dbname']);
	$sql = "UPDATE " . $PNConfig['System']['prefix'] . "_books SET bookTitle = '$bookTitle', bookLang = '$bookLang' WHERE bookId = $bookId";
	$rs = mysql_query($sql);
	if(!$rs){
		mysql_close($connection);
		return false;
	}
	mysql_close($connection);
	return $bookId;
}
?>
