<?php
//-----------------------------------------------------------------
//MyScrapBook online book program by Eric Gerdes (Crafty Syntax . Com )
//-----------------------------------------------------------------
// Feel free to change this code to better fit your website. I am
// open for any suggestions on how to improve the program and 
// you can submit suggestions and/or bugs to:
// http://craftysyntax.com/myscrapbook/updates/
// if you like using this program and feel it is a good program 
// feel free to send a donation by going to:
// http://craftysyntax.com/myscrapbook/abouts.php
//-----------------------------------------------------------------

// error reporting .. you will get lots of errors for undefined 
// vars if you do not have this.
error_reporting(E_ALL & ~E_NOTICE);

$using_magic = ini_get('magic_quotes_gpc');
$using_save_mode = ini_get('safe_mode');

// It is better if you turn on register globals. 
$register_globals = ini_get('register_globals');
if($register_globals == 0){
  extract($HTTP_GET_VARS);
  extract($HTTP_POST_VARS);
  extract($HTTP_COOKIE_VARS);    
  foreach($HTTP_POST_FILES as $key => $value) {
	${$key.'_name'} = $value['name'];
	${$key.'_size'} = $value['size'];
	${$key.'_type'} = $value['type'];
	${$key} = $value['tmp_name'];
    }
}

// if false you will be re-directed to the setup page every time you look at the page
// this is to direct to the setup program.
$installed=false;


if ($installed == true){

// NT/windows have the slashes leaning to the left
// UNIX has the slashes leaning to the right. 
$hosting_is = "INPUT-HOSTING";


// need to know what way the slashes are.
if($hosting == "WINDOWS"){
   $whatway = "\\";
 } else {
   $whatway = "/";
}

// dbtype either is either
// mysql_options.php        - this is for Mysql support
// txt-db-api.php           - txt database support.
$dbtype = "INPUT-DBTYPE";

//database connections for MYSQL 
$server = "INPUT-SERVER";
$database = "INPUT-DATABASE";
$datausername = "INPUT-DATAUSERNAME";
$password = "INPUT-PASSWORD";
$prefix = "INPUT-PREFIX";

// if using txt-db-api need the path to the txt databases directory
$DB_DIR = "INPUT-TXTPATH";
// if using txt-db-api need to have the full path to the txt-db-api
// you must set this property to something like /home/website/myscrapbook/txt-db-api/ 
$API_HOME_DIR = "INPUT-ROOTPATH" . "/txt-db-api/";

$application_root = "INPUT-ROOTPATH";

// if using Microsoft ACCESS
$dbpath = "INPUT-DBPATH";


// You do not need to edit anything below this line. 
//------------------------------------------------------------------------------



$filename = "$dbtype";
if ($dbtype == "mysql_options.php"){
 require "$filename";
 $mydatabase = new MySQL_options;
 $mydatabase->init();	
} 
if($dbtype == "MSaccess.php"){
 require "$filename";
 $mydatabase = new MS_options;
 $mydatabase->init();	
}

if ($dbtype == "txt-db-api.php"){	
 $filename = "txt-db-api/" . $filename;
 require "$filename";
 $mydatabase = new Database("myscrapbook");	
}

$query = "SELECT * FROM ".$prefix."_config";
$data = $mydatabase->select($query);
$data = $data[0];

//config vars.. 
$site_title = $data['site_title'];
$loggedin  = $data['loggedin'];
$logins = $data['logins'];
$version = $data['version'];
$imagemagic = $data['pathtoproccess'];
$Processor = $data['Processor'];
$searchbox = $data['showsearch'];
$lang = $data['lang'];
$image_folder = $data['image_folder'];
$theme = $data['theme'];
if ($loggedin == "N"){
$letters = array ("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
 $index = rand(0,35);
 $random = "$letters[$index]";
 for ($z = 1; $z < 9; $z++){
     $index = rand(0,35);
     $random = "$random" . "$letters[$index]";
 }
  $password_admin = $random;
} else {
	$password_admin = $data[mypass]; 
}
$password_admin_t = $data[mypass]; 
$site_home = $data[site_home];

}
?>
