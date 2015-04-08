<?php

include('config/config_books.php');
$fisbn = $_REQUEST['fisbn'];
header('location: ' . $booksBaseURL . '/' . $fisbn . '/llibre');
