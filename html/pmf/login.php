<?php

require_once dirname(dirname(__FILE__)) . '/config/config_books.php';

//Posem les funcions de consulta de la base de dades
include_once('inc/sessio.inc');

if (!isset($_REQUEST['submit'])) {
    //INICIALITZEM LA PLANTILLA SMARTY
    include_once $Smarty_path;
    $smarty = new Smarty;
    $smarty->compile_check = true;
    $smarty->debugging = false;

    $smarty->display('login.htm');
} else {
    if ($user_pmf == $_REQUEST['user'] && md5($_REQUEST['password']) == $pass_pmf) {
        $_SESSION['validat'] = 1;
    }
    header('location:index.php');
}
