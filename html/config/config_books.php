<?php

include_once 'env-config.php';

$server = $presta['dbhost'];
$database = $presta['dbname']; // In config file it is calculated the database and it is concatenated here
$datausername = $presta['dbuser'];
$password = $presta['dbpass'];

$fisbn = (isset($_GET['fisbn'])) ? $_GET['fisbn'] : '';

$zikulapath = $dirroot . '/prestatgeria';
$image_folder = $booksBaseURL . '/centres/'; // In config file it is concatenated the school code
$image_folder_uri = '/centres/' . $fisbn;
$image_folder_path = $dirroot . $image_folder_uri;
$images_url_imconfig = '/llibres/centres/';

$user_pmf = 'admin';
$pass_pmf = '6142bfd56a583d891f0b1dcdbb2a9ef8'; // MD5
$images_url_pmf = $booksBaseURL . '/pmf/images';