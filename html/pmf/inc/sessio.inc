<?php

require_once dirname(dirname(dirname(__FILE__))) . '/config/config_books.php';

$days_modified = 10;
$days_created = 10;
$lang = 'ca';
$showhits = 1;
$admet_comentaris = 1;
$Smarty_path = 'libs/Smarty.class.php';

session_start();

if (!isset($_SESSION['validat']) ) {
    $_SESSION['validat'] = 0;
}

// @aginard: Fixes PHP E_STRICT error when uploading images in PMF application
error_reporting(0);