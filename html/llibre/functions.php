<?php
//-----------------------------------------------------------------
//MyScrapBook online book program by Eric Gerdes (Crafty Syntax . Com )
//-----------------------------------------------------------------
//Spanish Translation and new features to version 4.0 by Antonio Temprano (antoniotemprano.org)
//----------------------------------------------------------------------------------------------
// Feel free to change this code to better fit your website. I am
// open for any suggestions on how to improve the program and 
// you can submit suggestions and/or bugs to:
// http://craftysyntax.com/myscrapbook/updates/
// if you like using this program and feel it is a good program 
// feel free to send a donation by going to:
// http://craftysyntax.com/myscrapbook/abouts.php
//-----------------------------------------------------------------


function islogedin(){
	global $mydatabase,$myuser,$mypass,$password_admin,$prefix;
   
	if(($myuser == "admin") && (md5($prefix.$password_admin) == $mypass)){
		return true;
	}
	if($myuser != ""){
   		$query = "select * from ".$prefix."_users where recno='$myuser'";
   		$data = $mydatabase->select($query);
        	$data = $data[0];
        	if( (md5($prefix.$data['mypassword']) != $mypass) || ($data['loggedin'] != "Y")){
        		return false;	
        	} else {
			return true;	
		}
	} else {
		return false;
	}
}


// tells if the cookied user has access 
// type = 
// R - read
// A - can click the add button.. 
// m - can add without approval
// F - has all access.
function has_access($type,$section){
	global $myuser,$mypass,$password_admin,$mydatabase,$prefix;
	// if SUPER user
	if(($myuser == "admin") && (md5($prefix.$password_admin) == $mypass)){
		return true;
	}

	// check global permissions first.
	$query = "SELECT * FROM ".$prefix."_contents WHERE recno='$section' ";
	$data_e = $mydatabase->select($query);
	$data_e = $data_e[0];

	if( ($type == "R") && ($data_e['permissions'] != "none")){
		return true;
	}
      
	if( ($type == "A") && ($data_e['permissions'] != "none") && ($data_e['permissions'] != "read")){
		return true;
	}
   
	if( ($type == "m") && ($data_e['permissions'] != "none") && ($data_e['permissions'] != "read") && ($data_e['permissions'] != "approval")){
		return true;
	}

	$query = "SELECT * FROM ".$prefix."_access WHERE userid='$myuser' AND contentsid='$section' ";
	$data_e = $mydatabase->select($query);
   
	for($k=0;$k<count($data_e); $k++){
		$data_f = $data_e[$k];  
		if(($type == "R") && ($data_f['permissions'] != "none")){
			return true;
		}
		if(($type == "A") && ($data_f['myaccess'] != "") && ($data_f['myaccess'] != "R")){
			return true;
		}    
		if(($type == "m") && ($data_f['myaccess'] != "") && ($data_f['myaccess'] != "R") && ($data_f['myaccess'] != "A")){
			return true;
		}
		if(($type == "F") && ($data_f['myaccess'] != "") && ($data_f['myaccess'] != "R") && ($data_f['myaccess'] != "A") && ($data_f['myaccess'] != "m")){
			return true;
		}
	}
	return false;
}

function uniqueimagename(){
	global $ext;
	$string = md5(uniqid(microtime(),1));
	$string = substr($string,0,12);
	$init1  =substr($string,0,1);
	$fullname = $string . $ext;
	return $string;
}

/**
 * Retrieve connection data for email sending service from Zikula tables
 */
function getEmailParamsFromZikula() {

    global $presta;

    $connection = mysql_connect($presta['dbhost'], $presta['dbuser'], $presta['dbpass']);
    
    if (!$connection) {
        echo 'Connection to database server ' . $presta['dbhost'] . ' with user ' . $presta['dbuser'] . ' failed';
    }
    if (!mysql_select_db($presta['dbname'], $connection)) {
        echo 'Connection to database ' . $presta['dbname'] . ' failed';
    }

    $sql = "SELECT name, value FROM module_vars WHERE modname LIKE 'XtecMailer'";
    
    $results = mysql_query($sql, $connection);
    
    $conf = array();
    while ($row = mysql_fetch_array($results)) {
        $conf[$row['name']] = unserialize($row['value']);
    }
    
    mysql_free_result($results);
    mysql_close($connection);
    
    return $conf;
}

