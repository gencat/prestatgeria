<?php

include_once dirname(dirname(__FILE__)) . '/prestatgeria/config/config.php';
include_once dirname(dirname(__FILE__)) . '/config/xtecAPI.php';
include_once dirname(dirname(__FILE__)) . '/config/config_books.php';

//get book fisn
$prefix = filter_var(isset($_GET['fisbn']) ? $_GET['fisbn'] : '', FILTER_SANITIZE_STRING);

//Separem el prefix de la identita del llibre
$book = explode('_', $prefix);
$schoolCode = (isset($book[0])) ? $book[0] : '';
$bookId = (isset($book[1])) ? $book[1] : '';

//get schoolId
$school = getSchool($schoolCode);

//get book to check if it exists
$bookId = getBook($bookId);

if ($school == '' || !$bookId) {
    header('location:bookNotFound.html');
    exit;
}

//Calc the database from school identity
$num = floor($school / 50) + 1;

$database .= $num;
$image_folder .= $prefix;

//if the cookie doen't exists create it and proceed to count visit otherwise don't count visit
if (!isset($_COOKIE['bookFisbn']) || $_COOKIE['bookFisbn'] != $prefix) {
    countVisit($bookId);
    updateBookPages($prefix, $database);
    setcookie('bookFisbn', $prefix, 0, '/');
}

// It is better if you turn on register globals. 
$register_globals = ini_get('register_globals');
if ($register_globals == 0) {
    extract($_GET);
    extract($_POST);
    extract($_COOKIE);
    foreach ($_FILES as $key => $value) {
        ${$key . '_name'} = $value['name'];
        ${$key . '_size'} = $value['size'];
        ${$key . '_type'} = $value['type'];
        ${$key} = $value['tmp_name'];
    }
}

$section = filter_var($section, FILTER_SANITIZE_NUMBER_INT);

$installed = true;

require 'mysql_options.php';
$mydatabase = new MySQL_options;
$mydatabase->init();

$query = "SELECT * FROM " . $prefix . "_config";
$data = $mydatabase->select($query);
$data = $data[0];

//config vars.. 
$site_title = $data['site_title'];
$loggedin = $data['loggedin'];
$logins = $data['logins'];
$version = $data['version'];
$imagemagic = $data['pathtoproccess'];
$Processor = $data['Processor'];
$searchbox = $data['showsearch'];
$lang = $data['lang']; //S'ha incorporat a la base de dades
$html_editor = $data['html_editor']; //S'ha incorporat a la base de dades
$myname = $data['myname']; //S'ha incorporat a la base de dades
$theme = $data['theme'];

if ($loggedin == "N") {
    $letters = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    $index = rand(0, 35);
    $random = $letters[$index];
    for ($z = 1; $z < 9; $z++) {
        $index = rand(0, 35);
        $random = "$random" . "$letters[$index]";
    }
    $password_admin = $random;
} else {
    $password_admin = $data['mypass'];
}
$password_admin_t = $data['mypass'];
$site_home = $data['site_home'];