<?php

	//Others
	$image_folder_uri = '/centres/' . $_GET['fisbn'];

	/** Integració **/
	$booksConfig['shelf']['booksBaseURL'] = 'http://pwc-int.educacio.intranet/prestatgeria';	
	$server = "pdb-int";
	$database = 'presta'; //in config file it is calculated the database and it is concatenated here
	$datausername = "presta";
	$password = "presta";
	$zikulapath= '/dades/presta/html/prestatgeria';
	$image_folder_path = '/dades/presta/html' . $image_folder_uri;
	$image_folder = 'http://pwc-int.educacio.intranet/prestatgeria/centres/'; //in config file it is concatenated the school code
	$images_url_imconfig = "/prestatgeria/centres/";
	$ENVIRONMENT = 'INT';
	
	/** Acceptació **/
	// $booksConfig['shelf']['booksBaseURL'] = 'http://pwc-acc.educacio.intranet/prestatgeria';
	// $server = "pdb-acc";
	// $database = 'presta'; //in config file it is calculated the database and it is concatenated here
	// $datausername = "presta";
	// $password = "*****";
	// $zikulapath= '/dades/presta/html/prestatgeria';
	// $image_folder_path = '/dades/presta/html' . $image_folder_uri;
	// $image_folder = 'http://pwc-acc.educacio.intranet/prestatgeria/centres/'; //in config file it is concatenated the school code
	// $images_url_imconfig = "/prestatgeria/centres/";
	// $ENVIRONMENT = 'ACC';
	
	/** Producció **/
	// $booksConfig['shelf']['booksBaseURL'] = 'http://apliense.xtec.cat/prestatgeria';
	// $server = "mykonos1";
	// $database = 'presta'; //in config file it is calculated the database and it is concatenated here
	// $datausername = "presta";
	// $password = "*****";
	// $zikulapath= '/dades/presta/html/prestatgeria';
	// $image_folder_path = '/dades/presta/html' . $image_folder_uri;
	// $image_folder = 'http://apliense.xtec.cat/prestatgeria/centres/'; //in config file it is concatenated the school code
	// $images_url_imconfig = "/prestatgeria/centres/";
	// $ENVIRONMENT = 'PRO';
	
	//send mail configuration
    $IDAPP = 'PRESTATGE';
    $REPLYADDRESS = 'prestatgeria-noreply@xtec.cat'; 
    $SENDER = 'educacio';
    $CONTENTTYPE = 'text/html';
    $LOG = false;
    $LOGDEBUG = false;
    $LOGPATH = '/dades/presta/html/prestatgeria/pnTemp/error_logs/mailsender.log';