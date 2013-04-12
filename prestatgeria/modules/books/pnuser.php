<?php
/**
 * show the list of books created according to given order and criteria
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:    order and criteria parameters
 * @return:	The list of available books
*/
function books_user_catalogue($args)
{
	$dom = ZLanguage::getThemeDomain('Books');
	
	$order = FormUtil::getPassedValue('order', isset($args['order']) ? $args['order'] : 'lastEntry', 'POST');
	$init = FormUtil::getPassedValue('init', isset($args['init']) ? $args['init'] : '1', 'POST');
	$history = FormUtil::getPassedValue('history', isset($args['history']) ? $args['history'] : null, 'POST');
	$filter = FormUtil::getPassedValue('filter', isset($args['filter']) ? $args['filter'] : null, 'POST');
	$filterValue = FormUtil::getPassedValue('filterValue', isset($args['filterValue']) ? $args['filterValue'] : null, 'POST');
	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	if($history == 1 || $history == 4){
		if($history == 4){
			$historyValues = pnModAPIFunc('books', 'user', 'getUserHistory');
			$index = $GLOBALS['_PNSession']['obj']['sessid'];
			$order = $historyValues[$index]['booksOrder'];
		}
		if($order == ''){$order = 'lastEntry';}
		pnModAPIFunc('books', 'user', 'saveUserHistory', array('item' => array('init' => $init,
																'booksOrder' => $order,
																'filter' => $filter,
																'filterValue' => $filterValue,
																'sessid' => $GLOBALS['_PNSession']['obj']['sessid'])));
	}
	if($history == 2){
		$historyValues = pnModAPIFunc('books', 'user', 'getUserHistory');
		$index = $GLOBALS['_PNSession']['obj']['sessid'];
		$init = $historyValues[$index]['init'];
		$order = $historyValues[$index]['booksOrder'];
		$filter = $historyValues[$index]['filter'];
		$filterValue = $historyValues[$index]['filterValue'];
		if($order == ''){$order = 'lastEntry';}
	}
	$books = pnModAPIFunc('books','user','getAllBooks', array('init' => $init-1,
																'filter' => $filter,
																'filterValue' => $filterValue,
																'ipp' => 15,
																'order' => $order));
	$total = pnModAPIFunc('books','user','getAllBooks', array('onlyNumber' => 1,
																'filter' => $filter,
																'filterValue' => $filterValue));
	$pager = pnModFunc('books', 'user', 'pager', array('init' => $init,
														'ipp' => 15,
														'total' => $total,
														'urltemplate' => "javascript:catalogue('$order','$filter',%%,'$filterValue',1)"));
	$filterValueSearch = $filterValue;
	if($filter == 'collection'){
		$collection = pnModAPIFunc('books','user','getCollection', array('collectionId' => $filterValue));
		$filterValue = $collection['collectionName'];
	}
	if($filter == 'lang'){
		switch($filterValue){
			case 'ca':
				$filterValue = __('català',$dom);
				break;
			case 'es':
				$filterValue = __('castellà',$dom);
				break;
			case 'en':
				$filterValue = __('anglès',$dom);
				break;
			case 'fr':
				$filterValue = __('francès',$dom);
				break;
		}
	}
	if($filter == 'name' || $filter == 'schoolCode'){
		$school = ($filter == 'name') ? pnModAPIFunc('books','user','getSchool', array('schoolId' => $filterValue)) : pnModAPIFunc('books','user','getSchool', array('schoolCode' => $filterValue));
		$filterValue = ($filter == 'name') ? $school['schoolType'].' '.$school['schoolName'] : $school[0]['schoolType'].' '.$school[0]['schoolName'];
		$filterValueSearch = $filterValue;
	}
	if($filter == 'city'){
		$filterValueSearch = $filterValue;
	}
	$search = pnModFunc('Books', 'user', 'search', array('filter' => $filter,
                        									'order' => $order,
                        									'filterValue' => $filterValueSearch));
	// Create output object
	$pnRender = pnRender::getInstance('books',false);
	$pnRender->assign('books',$books);
	$pnRender->assign('pager',$pager);
	$pnRender->assign('search',$search);
	$pnRender->assign('filter',$filter);
	$pnRender->assign('filterValue',$filterValue);
	$pnRender->assign('order',$order);
	$pnRender->assign('userName',pnUserGetVar('uname'));
	$pnRender->assign('bookSoftwareUrl', pnModGetVar('books','bookSoftwareUrl'));
	if (SecurityUtil::checkPermission('books::', "::", ACCESS_COMMENT)) {
		$pnRender->assign('canComment', true);
	}
	if (pnModApiFunc('books', 'user', 'canExport',array('bookId' => $bookId))){
		$pnRender->assign('canExport',true);
	}
	if($filter == 'schoolCode'){
		$pnRender->assign('school',$school[0]);
		return $pnRender->fetch('books_user_schoolCatalogue.htm');
	}else{
		return $pnRender->fetch('books_user_catalogue.htm');
	}
}

/**
 * check if a user can create new books
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param: userName
 * @return:	The school code that is going to create a book or false otherwise
*/
function books_user_canCreate($args)
{
	$userName = FormUtil::getPassedValue('userName', isset($args['userName']) ? $args['userName'] : null, 'POST');
	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	if(!pnUserloggedin()){
		return false;
	}
	//check if it is the school who is creating a book
	$school = pnModAPIFunc('books','user','getSchool', array('schoolCode' => $userName));
	if($school){
		return $school[0]['schoolCode'];
	}
    if(!pnModGetVar('books', 'canCreateToOthers')) {
        return false;
    }
	//check if the user is allowed to create a book for a school
	$schoolCode = pnModAPIFunc('books', 'user', 'getCreator');
	if($schoolCode){
		return $schoolCode[0]['schoolCode'];
	}
	return false;
}

/**
 * Displays the information sheet of a book.
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param: the book identity
 * @return:	The book information sheet
*/
function books_user_getBookData($args){
	
	$dom = ZLanguage::getThemeDomain('Books');
	
	$bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'GETPOST');
	$history = FormUtil::getPassedValue('history', isset($args['history']) ? $args['history'] : null, 'POST');
	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$book = pnModAPIFunc('books','user','getBook', array('bookId' => $bookId));
    if(!$book) {
        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("No s'ha trobat el llibre sol·licitat",$dom),
                                                             'title' => __("Resultat de la càrrega d'un llibre",$dom),
                                                             'result' => 0));
    }
	$book['bookDayInit'] = date('d/m/Y',$book['bookDateInit']);
	$book['bookDayLastVisit'] = date('d/m/Y',$book['bookLastVisit']);
	$book['bookTimeLastVisit'] = date('H.i',$book['bookLastVisit']);
	if($book['collectionId'] > 0){
		$collection = pnModAPIFunc('books','user','getCollection', array('collectionId' => $book['collectionId']));
	}
	$book['bookCollectionName'] = $collection['collectionName'];
	$comments = pnModAPIFunc('books','user','getAllComments', array('bookId' => $bookId));
	foreach($comments as $comment){
		$commentsArray[] = array('userName' => $comment['userName'],
								    'text' => $comment['text'],
									'dateDay' => date('d/m/Y',$comment['date']),
									'dateTime' => date('H.i',$comment['date']));

	}
    // get book main settings
    $bookSettings = pnModAPIFunc('books', 'user', 'getBookMainSettings', array('bookId' => $bookId));
    if(!$bookSettings) {
        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("Nos s'ha trobat el llibre sol·licitat",$dom),
                                                                 'title' => __("Resultat de la càrrega d'un llibre",$dom),
                                                                 'result' => 0));
    }
    $book['opentext'] = $bookSettings['opentext'];
	// Create output object
	$pnRender = pnRender::getInstance('books',false);
	$pnRender->assign('bookInfoBook',$book);
	$pnRender->assign('userName',pnUserGetVar('uname'));
	$pnRender->assign('history',$history);
	$pnRender->assign('comments',$comments);
	if (SecurityUtil::checkPermission('books::', "::", ACCESS_COMMENT)) {
		$pnRender->assign('canComment', true);
	}
	if (pnModApiFunc('books', 'user', 'canExport',array('bookId' => $bookId))){
		$pnRender->assign('canExport',true);
	}
	$pnRender->assign('bookSoftwareUrl', pnModGetVar('books','bookSoftwareUrl'));
	return $pnRender->fetch('books_user_bookData.htm');
}

/**
 * Generate a pager of books
 * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	the information needed for the pager
 * @return:	A pager navigator
*/
function books_user_pager($args){
	$ipp = FormUtil::getPassedValue('ipp', isset($args['ipp']) ? $args['ipp'] : null, 'POST');
	$init = FormUtil::getPassedValue('init', isset($args['init']) ? $args['init'] : null, 'POST');
	$total = FormUtil::getPassedValue('total', isset($args['total']) ? $args['total'] : null, 'POST');
	$urltemplate = FormUtil::getPassedValue('urltemplate', isset($args['urltemplate']) ? $args['urltemplate'] : null, 'POST');
	// Security check
	if (!SecurityUtil::checkPermission( 'books::', '::', ACCESS_READ)) {
		return LogUtil::registerPermissionError();
	}
	// Create output object
	$pnRender = pnRender::getInstance('books',false);
	// Quick check to ensure that we have work to do
	if($total <= $ipp){
		//return;
	}
	if(!isset($init) || empty($init)){
		$init = 1;
	}
	if(!isset($ipp) || empty($ipp)){
		$ipp = 10;
	}
	// Show startnum link
	if($init != 1){
		$url = preg_replace('/%%/', 1, $urltemplate);
		$text = '<a href="'.$url.'"><<</a> | ';
	}else{
		$text = '<< | ';
	}
	$items[] = array('text' => $text);
	// Show following items
	$pagenum = 1;
	for($curnum = 1; $curnum <= $total; $curnum += $ipp){
		if(($init < $curnum) || ($init > ($curnum + $ipp - 1))) {
			//mod by marsu - use sliding window for pagelinks
			if ((($pagenum % 10) == 0) // link if page is multiple of 10
					|| ($pagenum == 1) // link first page
					|| (($curnum >($init - 4 * $ipp)) //link -3 and +3 pages
					&&($curnum <($init + 4 * $ipp)))
			) {
				// Not on this page - show link
				$url = preg_replace('/%%/', $curnum, $urltemplate);
				$text = '<a href="' . $url.'">' . $pagenum . '</a> | ';
				$items[] = array('text' => $text);
			}
			//end mod by marsu
		}else{
			// On this page - show text
			$text = $pagenum.' | ';
			$items[] = array('text' => $text);
		}
		$pagenum++;
	}
	if(($curnum >= $ipp + 1) && ($init < $curnum - $ipp)){
		$url = preg_replace('/%%/', $curnum - $ipp, $urltemplate);
		$text = '<a href="'.$url.'">>></a>';
	}else{
		$text = '>>';
	}
	$items[] = array('text' => $text);
	$pnRender->assign('items', $items);
	$pnRender->assign('total', $total);
	return $pnRender->fetch('books_user_pager.htm');
}

/**
 * Displays the form needed to create a new comment for a book
 * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	the book identity
 * @return:	The form fields
*/
function books_user_addComment($args){
	$bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
	$history = FormUtil::getPassedValue('history', isset($args['history']) ? $args['history'] : null, 'POST');
	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_COMMENT)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$book = pnModAPIFunc('books','user','getBook', array('bookId' => $bookId));
	// Create output object
	$pnRender = pnRender::getInstance('books',false);
	$pnRender->assign('bookInfo',$book);
	$pnRender->assign('history',$history);
	return $pnRender->fetch('books_user_addComment.htm');
}

/**
 * Displays the available collections
 * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
 * @return:	The list of collections
*/
function books_user_collections()
{
	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$collections = pnModAPIFunc('books', 'user', 'getAllCollection');
	foreach($collections as $collection){
		$booksInCollection = pnModAPIFunc('books', 'user', 'getBooksInCollection', array('collectionId' => $collection['collectionId']));
		$collectionsArray[] = array('collectionName' => $collection['collectionName'],
									'collectionState' => $collection['collectionState'],
									'collectionId' => $collection['collectionId'],
									'collectionAutoOut' => $collection['collectionAutoOut'],
									'booksInCollection' => $booksInCollection);
	}
	// Create output object
	$pnRender = pnRender::getInstance('books',false);
	$pnRender->assign('collections', $collectionsArray);
	return $pnRender->fetch('books_user_collections.htm');
}

/**
 * Displays the form needed to create a new book
 * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
 * @return:	The form fields
*/
function books_user_new()
{
	$pnRender = pnRender::getInstance('books',false);

	$create = pnModFunc('books', 'user', 'canCreate', array('userName' => pnUserGetVar('uname')));
	// Security check
	if (!$create) {
		return $pnRender->fetch('books_user_cantcreatenew.htm');
	}
	$collections = pnModAPIFunc('books', 'user', 'getAllCollection', array('state' => 1));
	$pnRender->assign('collections',$collections);
	$pnRender->assign('canCreateToOthers',pnModGetVar('books', 'canCreateToOthers'));
	$pnRender->assign('schoolCode',$create);
	$pnRender->assign('userName', pnUserGetVar('uname'));
    	$pnRender->assign('helpTexts', pnModFunc('books', 'user', 'getHelpTexts'));
	return $pnRender->fetch('books_user_new.htm');
}

/**
 * Checks if a created user is a school and in this case create the school in the table of schools. It allows to associate users previously created as schools
 * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
 * @return:	Redirect user to main page
*/
function books_user_inscribe()
{
    // Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	//******* Prestatgeria adaption *******
	//check if the user is a school, CRP or something like this
	$uname = str_replace('a','0',pnUserGetVar('uname'));
	$uname = str_replace('b','1',$uname);
	$uname = str_replace('c','2',$uname);
	$uname = str_replace('e','4',$uname);
	$schoolInfo = pnModAPIFunc('books','user','getSchoolInfo', array('schoolCode' => $uname));
	//if school is an school insert record in schools table
	if($schoolInfo){
		$items = array('schoolCode' => pnUserGetVar('uname'),
						'schoolName' => $schoolInfo['schoolName'],
						'schoolType' => $schoolInfo['schoolType'],
						'schoolDateIns' => time(),
						'schoolCity' => $schoolInfo['schoolCity'],
						'schoolZipCode' => $schoolInfo['schoolZipCode'],
						'schoolRegion' => $schoolInfo['schoolRegion']);
		$created = pnModAPIFunc('books','user','createSchool', array('items' => $items));
	}
	return pnRedirect();
}

/**
 * Checks the information given for a new book and create it if the information received is correct
 * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:    The book main parameters
 * @return:	Redirect to a informative page if success or to the creation page oterwise
*/
function books_user_updateBook($args)
{   
	$dom = ZLanguage::getThemeDomain('Books');
	
	$ccentre = FormUtil::getPassedValue('ccentre', isset($args['ccentre']) ? $args['ccentre'] : null, 'POST');
	$tllibre = FormUtil::getPassedValue('tllibre', isset($args['tllibre']) ? $args['tllibre'] : null, 'POST');
	$illibre = FormUtil::getPassedValue('illibre', isset($args['illibre']) ? $args['illibre'] : null, 'POST');
	$descllibre = FormUtil::getPassedValue('descllibre', isset($args['descllibre']) ? $args['descllibre'] : null, 'POST');
	$ellibre = FormUtil::getPassedValue('ellibre', isset($args['ellibre']) ? $args['ellibre'] : null, 'POST');
	$bookCollection = FormUtil::getPassedValue('bookCollection', isset($args['bookCollection']) ? $args['bookCollection'] : null, 'POST');
	$dllibre = FormUtil::getPassedValue('dllibre', isset($args['dllibre']) ? $args['dllibre'] : null, 'POST');
	$mailxtec = FormUtil::getPassedValue('mailxtec', isset($args['mailxtec']) ? $args['mailxtec'] : null, 'POST');
	$confirm = FormUtil::getPassedValue('confirm', isset($args['confirm']) ? $args['confirm'] : null, 'POST');
	$importBook = FormUtil::getPassedValue('importBook', isset($args['importBook']) ? $args['importBook'] : null, 'POST');
	// Security check
	if (!$creator = pnModFunc('books', 'user', 'canCreate', array('userName' => pnUserGetVar('uname')))) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	// Confirm authorisation code
	if (!SecurityUtil::confirmAuthKey()) {
	    LogUtil::registerAuthidError();
        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("S'ha produït un error en la creació del llibre. Torna-ho a provar més endavant",$dom),
                                                                 'title' => __('Resultat en la creació del llibre',$dom),
                                                                 'result' => 0));
	}

	if($confirm != 1){
        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("No has acceptat les condicions d'ús. El llibre no s'ha pogut crear",$dom),
                                                                 'title' => __('Resultat en la creació del llibre',$dom),
                                                                 'result' => 0));
        
	}
	$canCreateToOthers = pnModGetVar('books', 'canCreateToOthers');
	if($ccentre != pnUserGetVar('uname') && $ccentre != $creator){
		// Check if the user can create books here
		if(!$allowedUser = pnModAPIFunc('books', 'user', 'allowedUser', array('ccentre' => $ccentre)) || !$canCreateToOthers){
            return pnModFunc('books', 'user', 'displayMsg', array('msg' => __('No pots crear llibres en nom del centre',$dom),
                                                                 'title' => __('Resultat en la creació del llibre',$dom),
                                                                 'result' => 0));
		}
	}
	if($importBook == 1){
		//import a book from a file
		//Upload file
		//gets the attached file array
		$fileName = $_FILES['importFile']['name'];
		if($fileName == '') {
            return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("No s'ha trobat el fitxer d'importació",$dom),
                                                                 'title' => __('Resultat en la creació del llibre',$dom),
                                                                 'result' => 0));
		}
		$file_extension = strtolower(substr(strrchr($fileName,"."),1));
		if($file_extension != 'zip'){
            return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("El fitxer d'importació no és correcte",$dom),
                                                                 'title' => __('Resultat en la creació del llibre',$dom),
                                                                 'result' => 0));
		}
		//Update the file
		global $PNConfig;
		$path = $PNConfig['System']['temp'] . '/books/import/'.$fileName;
		if (!move_uploaded_file($_FILES['importFile']['tmp_name'],$path)) {
            return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("S'ha produït un error en carregar el fitxer d'importació",$dom),
                                                                 'title' => __('Resultat en la creació del llibre',$dom),
                                                                 'result' => 0));
		}
		if(!pnModFunc('books', 'user', 'importBook', array('path' => $path,
															'schoolCode' => $ccentre,
															'username' => $mailxtec,
															'bookCollection' => $bookCollection))){
            return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("S'ha produït un error en la importació del llibre. Torna-ho a provar més endavant",$dom),
                                                                 'title' => __('Resultat en la creació del llibre',$dom),
                                                                 'result' => 0));
		} else {
	        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("El llibre s'ha editat correctament.",$dom),
                                                             'title' => __('Resultat en la creació del llibre',$dom),
                                                             'result' => 1));
		}
	}else{
		//Create book
		if(!$bookId = pnModAPIFunc('books', 'user', 'createBook', array('ccentre' => $ccentre,
																		'tllibre' => $tllibre,
																		'illibre' => $illibre,
																		'descllibre' => $descllibre,
																		'ellibre' => $ellibre,
																		'bookCollection' => $bookCollection,
																		'dllibre' => $dllibre,
																		'mailxtec' => $mailxtec))){
			// remove book images folder
            rmdir($path);
            return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("S'ha produït un error en la creació del llibre. Torna-ho a provar més endavant",$dom),
                                                                 'title' => __('Resultat en la creació del llibre',$dom),
                                                                 'result' => 0));
		}
		
// XTEC *********** AFEGIT -> Manage descriptors when save / edit books
// 2012.02.24 @mmartinez
		$descriptorsArray = explode(',', $dllibre);
                
		$bookDescriptString = '#';
		foreach($descriptorsArray as $descriptor) {
			if($descriptor != ''){
				$descriptor = trim(mb_strtolower($descriptor));
				//$descriptor = preg_replace('/\s*/m', '', $descriptor);
				$bookDescriptString .= '#' . $descriptor . '#';
			}
		}

		if(!pnModAPIFunc('books', 'user', 'updateDescriptors', array('oldValue' => '',
																	'newValue' => $bookDescriptString))) {
				return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("S'ha produït un error en editar els descriptors del llibre.",$dom),
						'title' => __('Edita el llibre',$dom),
						'result' => 0));
		}
// *********** FI
	}
    // create the book folder where the book images have to be stored
    $path = pnModGetVar('books','serverImageFolder') . '/' . $ccentre .'_' . $bookId;
    if(!mkdir($path, 0777)){
        // change book state to -1 to make possible to delete it
        pnModAPIFunc('books', 'user', 'editBook', array('bookId' => $bookId,
			    									    'items' => array('bookState' => -1)));
        // delete book entry
        pnModAPIFunc('books', 'user', 'activateBook', array('bookId' => $bookId,
																'action' => 'delete'));
        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("S'ha produït un error en la creació del llibre. Torna-ho a provar més endavant",$dom),
                                                                 'title' => __('Resultat en la creació del llibre',$dom),
                                                                 'result' => 0));
    }
	//if the user is the same as the administrator it is not necessari validate the book. Otherwise validation is needed
	if($mailxtec != $ccentre && $mailxtec != pnUserGetVar('uname')) {
		LogUtil::registerStatus (__("El llibre no estarà disponible fins que la persona a qui se n'ha assignat l'administració confimi que el vol activar. Ho pot fer des de la mateixa Prestatgeria. Quan s'hi identifiqui rebrà un avís d'activació.",$dom));
		//send mail to user
		//Check if module Mailer is active
		$modid = pnModGetIDFromName('Mailer');
		$modinfo = pnModGetInfo($modid);
		//if it is active
		if($modinfo['state'] == 3){
			$pnRender = pnRender::getInstance('books',false);
			$school = pnModAPIFunc('books','user','getSchool', array('schoolCode' => $ccentre));
			$book = array('bookTitle' => $tllibre,
							'schoolType' => $school[0]['schoolType'],
							'schoolName' => $school[0]['schoolName'],
							'schoolCode' => $school[0]['schoolCode'],
							'bookId' => $bookId);
			$pnRender->assign('book', $book);
			$pnRender->assign('bookSoftwareUrl', pnModGetVar('books', 'bookSoftwareUrl'));
			$sendResult = pnModAPIFunc('Mailer', 'user', 'sendmessage', array('toname' => $mailxtec,
																				'toaddress' => $mailxtec.pnModGetVar('books','mailDomServer'),
																				'subject' => __("Tens un llibre pendent d'activació",$dom),
																				'body' => $pnRender->fetch('books_user_newBookMail.htm'),
																				'html' => 1));
		}
	}
    return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("El llibre s'ha creat correctament.",$dom),
                                                                 'title' => __('Resultat en la creació del llibre',$dom),
                                                                 'result' => 1));
}

/**
 * Displays the search form in the books cataloge
 * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:    The default form fields
 * @return:	The search form fields
*/
function books_user_search($args)
{	
	$filter = FormUtil::getPassedValue('filter', isset($args['filter']) ? $args['filter'] : null, 'POST');
	$order = FormUtil::getPassedValue('order', isset($args['order']) ? $args['order'] : null, 'POST');
	$filterValue = FormUtil::getPassedValue('filterValue', isset($args['filterValue']) ? $args['filterValue'] : null, 'POST');
	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$collections = pnModAPIFunc('books', 'user', 'getAllCollection');
	// Create output object
	$pnRender = pnRender::getInstance('books',false);
	$pnRender->assign('filter',$filter);
	$pnRender->assign('order',$order);
	$pnRender->assign('filterValue',$filterValue);
	$pnRender->assign('collections',$collections);
	return $pnRender->fetch('books_user_search.htm');
}

/**
 * Update the activation results of a book following the user wishes
 * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:    The book identity and the user's activation wishes
 * @return:	Redirect user to the main page
*/
function books_user_submitActivationNotify($args){
	
	$dom = ZLanguage::getThemeDomain('Books');
	
	$submit = FormUtil::getPassedValue('submit', isset($args['submit']) ? $args['submit'] : null, 'POST');
	$bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
	$book = pnModAPIFunc('books','user','getBook', array('bookId' => $bookId));
	if($book['bookState'] == 1 && $book['newBookAdminName'] != pnUserGetVar('uname')){
        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __('Aquest llibre ja està activat',$dom),
                                                                 'title' => __("Resultat de l'acceptació d'un llibre",$dom),
                                                                 'result' => 0,
                                                                 'returnURL' => 'index.php'));
	}
	if($book['bookAdminName'] != pnUserGetVar('uname') && $book['bookAdminName'] != '' && $book['newBookAdminName'] != pnUserGetVar('uname')){
        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __('No tens autorització per acceptar aquest llibre.',$dom),
                                                                 'title' => __("Resultat de l'acceptació d'un llibre",$dom),
                                                                 'result' => 0,
                                                                 'returnURL' => 'index.php'));
	}
	if($submit == __("Accepto l'assignació",$dom)) {
		if(pnModAPIFunc('books', 'user', 'activateBook', array('bookId' => $bookId,
																'action' => 'activate'))){
			$msg = __("El llibre s'ha activat correctament. L'hauries de veure a l'apartat dels teus llibres.",$dom);
		} else {
            return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("S'ha produït un error i no s'ha pogut portar a terme l'acció sol·licitada.",$dom),
                                                                     'title' => __("Resultat de l'acceptació d'un llibre",$dom),
                                                                     'result' => 0,
                                                                     'returnURL' => 'index.php'));		    
		}
	}else{
		if(pnModAPIFunc('books', 'user', 'activateBook', array('bookId' => $bookId,
																'action' => 'delete'))){
			$msg = __("No s'ha acceptat l'administració del llibre i l'assignació ha estat esborrada.",$dom);
		} else {
            return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("S'ha produït un error i no s'ha pogut portar a terme l'acció sol·licitada.",$dom),
                                                                     'title' => __("Resultat de l'acceptació d'un llibre",$dom),
                                                                     'result' => 0,
                                                                     'returnURL' => 'index.php'));		    
		}
	}
    return pnModFunc('books', 'user', 'displayMsg', array('msg' => $msg,
                                                             'title' => __("Resultat de l'acceptació d'un llibre",$dom),
                                                             'result' => 1,
                                                             'returnURL' => 'index.php'));
}

/**
 * Displays the managment page for books
 * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
 * @return:	The managment books information
*/
function books_user_manage()
{
    $userName = pnUserGetVar('uname');
	// Security check
    // get school
    $school = pnModAPIFunc('books','user','getSchool', array('schoolCode' => $userName));
	if (!$school) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$books = pnModAPIFunc('books','user','getAllBooks', array('init' => '-1',
																'ipp' => '-1',
																'order' => 'bookHits',
																'filter' => 'schoolCode',
																'filterValue' => $userName,
																'bookState' => 'all',
																'notJoin' => 1));
	foreach($books as $book){
		$booksArray[] = array('bookTitle' => $book['bookTitle'],
								'bookId' => $book['bookId'],
								'schoolCode' => $book['schoolCode'],
								'bookState' => $book['bookState'],
								'bookAdminName' => $book['bookAdminName'],
                                'newBookAdminName' => $book['newBookAdminName'],
								'bookPages' => $book['bookPages'],
								'bookHits' => $book['bookHits'],
								'bookDayInit' => date('d/m/y',$book['bookDateInit']),
								'bookDateLastVisit' => date('d/m/y',$book['bookLastVisit']));

	}
	$allowed = pnModApiFunc('books', 'user', 'getAllCreators');
	$pnRender = pnRender::getInstance('books',false);
	$pnRender->assign('books', $booksArray);
	$pnRender->assign('allowed',$allowed);
    $pnRender->assign('canCreateToOthers',pnModGetVar('books', 'canCreateToOthers'));
	$pnRender->assign('bookSoftwareUrl', pnModGetVar('books','bookSoftwareUrl'));
	$pnRender->assign('schoolCode', $userName);
	return $pnRender->fetch('books_user_manage.htm');
}

/**
 * Get and display the list of users that can create books for a given school
 * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
 * @return:	The list of users that can create books for a given school
*/
function books_user_getCreators()
{
	// Security check
	if (!pnModFunc('books', 'user', 'canCreate', array('userName' => pnUserGetVar('uname')))) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$allowed = pnModApiFunc('books', 'user', 'getAllCreators');
	$pnRender = pnRender::getInstance('books',false);
	$pnRender->assign('allowed',$allowed);
	return $pnRender->fetch('books_user_manageCreators.htm');
}

/**
 * Display the list of descriptors for all the books
 * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
 * @return:	The list of descriptors
*/
function books_user_descriptors()
{
	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$max_font_size = 30;
	$min_font_size= 12;
	$maximum_count = 0;
	$minimum_count = 10000;
    // get all descriptors
	$tags = pnModAPIFunc('books', 'user', 'getAllDescriptors', array('order' => 'descriptor'));
	$cloudArray = array(); // create an array to hold tag code
	if(count($tags)>0){
		foreach($tags as $tag){
			if($tag['number'] > $maximum_count){
				$maximum_count = $tag['number'];
			}
			if($tag['number'] < $minimum_count){
				$minimum_count = $tag['number'];
			}
		}
		$spread = $maximum_count - $minimum_count;
		if($spread == 0) {
			$spread = 1;
		}
		//Finally we start the HTML building process to display our tags. For this demo the tag simply searches Google using the provided tag.
		foreach ($tags as $tag) {
			$size = $min_font_size + ($tag['number'] - $minimum_count) * ($max_font_size - $min_font_size) / $spread;
			$cloudArray[] = array('tag' => htmlspecialchars(stripslashes($tag['descriptor'])),
        							'size' => floor($size),
        							'count' => $tag['number']);
		}
	}
	// Create output object
	$pnRender = pnRender::getInstance('books',true);
	$pnRender->assign('cloud', $cloudArray);
	return $pnRender->fetch('books_user_descriptors.htm');
}

/**
 * Delete a book
 * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:    The book identity and the confirmation flag
 * @return:	Redirect user to the managment page
*/
function books_user_removeBook($args)
{
	$dom = ZLanguage::getThemeDomain('Books');
	
	$bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'REQUEST');
	$confirmation = FormUtil::getPassedValue('confirmation', isset($args['confirmation']) ? $args['confirmation'] : null, 'POST');
    $submit = FormUtil::getPassedValue('submit', isset($args['submit']) ? $args['submit'] : null, 'POST');
	// security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	// gets book information
	$book = pnModAPIFunc('books','user','getBook', array('bookId' => $bookId));
	if(!$book){
        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("No s'ha trobat el llibre sol·licitat.",$dom),
                                                                 'title' => __("Resultat de la càrrega d'un llibre",$dom),
                                                                 'result' => 0));
	}
	// check if user is the owner of the book
	if($book['schoolCode'] != pnUserGetVar('uname')){
        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __('No pots esborrar aquest llibre.',$dom),
                                                                 'title' => __("Resultat de la càrrega d'un llibre",$dom),
                                                                 'result' => 0));
	}
	if($confirmation == null){
		$pnRender = pnRender::getInstance('books',false);
		$pnRender->assign('book', $book);
		return $pnRender->fetch('books_user_removeBook.htm');
	}
    if($submit == _CANCEL){
        return pnRedirect(pnModURL('books', 'user', 'manage'));
    }  
// XTEC *********** AFEGIT -> Manage descriptors when save / edit books
// 2012.02.24 @mmartinez
    if(!pnModAPIFunc('books', 'user', 'updateDescriptors', array('oldValue' => $book['bookDescript'],
    															'newValue' => ''))) {
    		return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("S'ha produït un error en editar els descriptors del llibre.",$dom),
    				'title' => __('Edita el llibre',$dom),
    				'result' => 0));
    }
// *********** FI
	// remove the book. If book state is -1 remove it completelly and set state to -2 otherwise and book is invible to users
    switch($book['bookState']){
        case -1:
            // the book is removed completely
            if(!pnModAPIFunc('books', 'user', 'activateBook', array('bookId' => $book['bookId'],
			    													'action' => 'delete'))){
			    LogUtil::registerError (__("S'ha produït un error en l'esborrament del llibre",$dom));
			    return pnRedirect(pnModURL('books', 'user', 'manage'));
		    }
            break;
        case 0:
            // TODO: A site administrator is deleting the book
            break;
        case 1:
            // the book state is set to -2
            if(!pnModAPIFunc('books', 'user', 'editBook', array('bookId' => $book['bookId'],
			    											    'items' => array('bookState' => -2)))){
			    LogUtil::registerError (__("S'ha produït un error en l'esborrament del llibre",$dom));
			    return pnRedirect(pnModURL('books', 'user', 'manage'));
		    }
            break;
    }
    LogUtil::registerStatus (__('El llibre ha estat esborrat',$dom));
	return pnRedirect(pnModURL('books', 'user', 'manage'));
}

/**
 * Allow to create publicity of the book which is displaied in the main page
 * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:    The book identity
 * @return:	???
*/
function books_user_newPublic()
{
	$msg = 'Aquesta funci&oacute; de moment no est&agrave; operativa, per&ograve; ho estar&agrave; en breu.';
	$title = 'Publicita el llibre';
    return pnModFunc('books', 'user', 'displayMsg', array('msg' => $msg,
                                                                 'title' => $title,
                                                                 'result' => 0));
}

/**
 * Allow to the administrators and owners of a book to change the main properties
 * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:    The book identity
 * @return:	???
*/
function books_user_editBook()
{   
	$dom = ZLanguage::getThemeDomain('Books');
	
    $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'GET');
	// security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	// get book information
	$book = pnModAPIFunc('books','user','getBook', array('bookId' => $bookId));
	if(!$book){
        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("No s'ha trobat el llibre sol·licitat.",$dom),
                                                                 'title' => __("Resultat de la càrrega d'un llibre",$dom),
                                                                 'result' => 0));
	}
    $isOwner = false;
    $isAdministrator = false;
	// check if user is the owner of the book
	if($book['schoolCode'] == pnUserGetVar('uname')){
        $isOwner = true;
	}
	// check if user is the administrator of the book
	if($book['bookAdminName'] == pnUserGetVar('uname')){
        $isAdministrator = true;
	}
    if(!$isAdministrator && !$isOwner) {
        return pnRedirect();
    }
    // get book main settings
    $bookSettings = pnModAPIFunc('books', 'user', 'getBookMainSettings', array('bookId' => $bookId));
    if(!$bookSettings) {
        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("No s'ha trobat el llibre sol·licitat.",$dom),
                                                                 'title' => __("Resultat de la càrrega d'un llibre",$dom),
                                                                 'result' => 0));
    }
    $bookDescriptors = str_replace('##', ',', substr($book['bookDescript'], 2 ,-1));

    $book['bookDescript'] = $bookDescriptors;
    
	$collections = pnModAPIFunc('books', 'user', 'getAllCollection', array('state' => 1));

	// Create output object
	$pnRender = pnRender::getInstance('books',false);
	$pnRender->assign('isOwner', $isOwner);
    $pnRender->assign('bookSettings', $bookSettings);
    $pnRender->assign('book', $book);
    $pnRender->assign('helpTexts', pnModFunc('books', 'user', 'getHelpTexts'));
    $pnRender->assign('collections',$collections);
    $pnRender->assign('canCreateToOthers', pnModGetVar('books', 'canCreateToOthers'));
    $pnRender->assign('userName', pnUserGetVar('uname'));
	return $pnRender->fetch('books_user_editBook.htm');
}

function books_user_getHelpTexts($args)
{
	$dom = ZLanguage::getThemeDomain('Books');
	
    $helpTexts = array('_BOOKSIMPORTEXPORTEDBOOK' => __("Si voleu podeu importar un llibre des d'un fitxer d'importació",$dom),
                        '_BOOKSTITLETOSHOW' => __('Aquest serà el text amb el qual es reconeixerà el llibre.',$dom) . '<br />' . __("Des de l'interior del llibre, si n'ets l'administrador, el pots modificar.",$dom),
                        '_BOOKSLANGUAGETOSHOW' => __("Des de l'interior del llibre, si n'ets l'administrador, el pots modificar.",$dom) . '<br />' . __("Des de l'interior del llibre, si n'ets l'administrador, el pots modificar.",$dom),
                        '_BOOKSINTRODUCTIONTOSHOW' => __("Es tracta d'un text informatiu que hi ha a la contraportada del llibre.",$dom) . '<br />' . __("Des de l'interior del llibre, si n'ets l'administrador, el pots modificar.",$dom),
                        '_BOOKSSTYLETOSHOW' => __("L'aspecte del llibre depèn de l'opció que triada en aquest apartat.",$dom) . '<br />' . __("Des de l'interior del llibre, si n'ets l'administrador, el pots modificar.",$dom),
                        '_BOOKSDESCRIPTORSTOSHOW' => __("Permet posar uns descriptors de cerca.<br />Els descriptors permetran fer una classificació del llibre.<br />Els descriptors s'han d'entrar separats per comes i han de ser paràules amb minúscula i sense espais. Un parell d'exemples de descriptors vàlids són: <strong>tecnologia,mecànica,eso</strong> o bé <strong>català,poesia</strong><br />Un descriptor de l'estil <strong>llengua catalana,poesia</strong> no és vàlid.<br />Aquests descriptors els podrà modificar l'administrador/a del llibre cada vegada que ho cregui oportú des de l'edició del llibre.",$dom),
                        '_BOOKSADMINTOSHOW' => __("Cal que sigui un usuari/ària de la XTEC vàlid. Altrament, no es podrà crear el llibre.<br />Per accedir a l'administració del llibre, s'haurà de fer servir el nom d'usuari/ària i la contrasenya de la XTEC.",$dom),
                        '_BOOKSACCEPTTOSHOW' => __("Cal acceptar les condicions d'ús dels llibres per poder-los crear. Aquestes condicions s'han de tenir presents en el moment d'editar els continguts del llibre.",$dom),
                        '_BOOKSCOLLECTIONSTOSHOW' => __('Si hi ha col·leccions disponibles, podeu associar el llibre a una de les col·leccions proposades.<br />Això farà possible llistar els llibres per col·leccions.',$dom));
    return $helpTexts;  
}

/**
 * Checks the information given for a edit book and update it if the information received is correct
 * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:    The book main parameters
 * @return:	Redirect to a informative page if success or to the creation page oterwise
*/
function books_user_updateEditBook($args)
{   
	$dom = ZLanguage::getThemeDomain('Books');
	
    $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
	$bookTitle = FormUtil::getPassedValue('bookTitle', isset($args['bookTitle']) ? $args['bookTitle'] : null, 'POST');
    $bookLang = FormUtil::getPassedValue('bookLang', isset($args['bookLang']) ? $args['bookLang'] : null, 'POST');
    $opentext = FormUtil::getPassedValue('opentext', isset($args['opentext']) ? $args['opentext'] : null, 'POST');
    $theme = FormUtil::getPassedValue('theme', isset($args['theme']) ? $args['theme'] : null, 'POST');
    $bookDescript = FormUtil::getPassedValue('bookDescript', isset($args['bookDescript']) ? $args['bookDescript'] : null, 'POST');
    $bookCollection = FormUtil::getPassedValue('bookCollection', isset($args['bookCollection']) ? $args['bookCollection'] : null, 'POST');
    $bookAdminName = FormUtil::getPassedValue('bookAdminName', isset($args['bookAdminName']) ? $args['bookAdminName'] : null, 'POST');
    
	// Confirm authorisation code
	if (!SecurityUtil::confirmAuthKey()) {
	    LogUtil::registerAuthidError();
        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("S'ha produït un error en editar el llibre.",$dom),
                                                                 'title' => __('Edita el llibre',$dom),
                                                                 'result' => 0));
	}
	// get book information
	$book = pnModAPIFunc('books','user','getBook', array('bookId' => $bookId));
	if(!$book){
        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("No s'ha trobat el llibre sol·licitat.",$dom),
                                                                 'title' => __("Resultat de la càrrega d'un llibre",$dom),
                                                                 'result' => 0));
        
	}
    // get book main settings
    $bookSettings = pnModAPIFunc('books', 'user', 'getBookMainSettings', array('bookId' => $bookId));
    if(!$bookSettings) {
        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("No s'ha trobat el llibre sol·licitat.",$dom),
                                                                 'title' => __("Resultat de la càrrega d'un llibre",$dom),
                                                                 'result' => 0));
    }
    
    $userName = pnUserGetVar('uname');
    $isOwner = false;
	// check if user is the owner of the book
	if($book['schoolCode'] == $userName){
        $isOwner = true;
        $returnURL = pnModURL('books', 'user', 'manage');
	} else {
	    $returnURL = pnModURL('books', 'user', 'getBookData', array('bookId' => $bookId));
	}
    if(!$isOwner && $book['bookAdminName'] != $userName) {
        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __('No tens permís per editar aquest llibre',$dom),
                                                                 'title' => __('Edita el llibre',$dom),
                                                                 'result' => 0));
    }
    $newBookAdminName = '';
    $sendConfirmationMsg = false;
    if($bookAdminName == $book['bookAdminName']) {
        // the book administrator doesn't change. The confirmation is not required
        $myname = $bookSettings['myname'];
        $mypass = $bookSettings['mypass'];
    } else if($bookAdminName == $userName) {
        // the administrator change but it is the same as the owner. The confirmation is not required
        $myname = $userName;
        $mypass = pnUserGetVar('pass');
    } else {
        // the administrator change and the confirmation is required
        $oBookAdminName = $bookAdminName;
        if($book['bookState'] == '-1') {
            $myname = $bookAdminName;
            $mypass = $bookSettings['mypass'];
        } else {
            // for security reasons check if the user is the owner. Avoid that user changes the administrator ilegaly 
            if ($isOwner) {
                $newBookAdminName = $bookAdminName;
                $bookAdminName = '';
                $myname = '';
                $mypass = '';
                $sendConfirmationMsg = true;
            } else {
                $bookAdminName = $userName;
                $myname = $userName;
                $mypass = $bookSettings['mypass'];
            }
        }
    }
    // edit the book properties
    if ($book['collectionId'] > 0) $bookCollection = $book['collectionId'];
    $descriptorsArray = explode(',',$bookDescript);
    
	$bookDescriptString = '#';
	foreach($descriptorsArray as $descriptor) {
		if($descriptor != ''){
                        $descriptor = trim(mb_strtolower($descriptor));
                        //$descriptor = preg_replace('/\s*/m', '', $descriptor);
			$bookDescriptString .= '#' . $descriptor . '#';
		}
	}
               
    if(!pnModAPIFunc('books', 'user', 'editBook', array('bookId' => $book['bookId'],
	    											    'items' => array('newBookAdminName' => $newBookAdminName,
                                                                         'bookAdminName' => $bookAdminName,
                                                                         'bookTitle' => $bookTitle,
                                                                         'bookLang' => $bookLang,
                                                                         'theme' => $theme,
                                                                         'bookDescript' => $bookDescriptString,
                                                                         'collectionId' => $bookCollection)))) {
        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("S'ha produït un error en editar el llibre.",$dom),
                                                                 'title' => __('Edita el llibre',$dom),
                                                                 'result' => 0));
    }

// XTEC *********** AFEGIT -> Manage descriptors when save / edit books
// 2012.02.24 @mmartinez
   
	if(!pnModAPIFunc('books', 'user', 'updateDescriptors', array('oldValue' => $book['bookDescript'],
																'newValue' => $bookDescriptString))) {
        return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("S'ha produït un error en editar els descriptors del llibre.",$dom),
                                                                 'title' => __('Edita el llibre',$dom),
                                                                 'result' => 0));
    }
// *********** FI

    // edit the book settings
    if(!pnModAPIFunc('books', 'user', 'editBookSettings', array('bookId' => $book['bookId'],
                                                                'site_title' => $bookTitle,
                                                                'opentext' => $opentext,
                                                                'lang' => $bookLang,
                                                                'theme' => $theme,
                                                                'myname' => $myname,
                                                                'mypass' => $mypass))) {
        LogUtil::registerError (__("S'ha produït un error en editar les característiques del llibre.",$dom));
    }
    // if the book administrator changes the new administrator must accept the book administration. Meanwhile the book has not administrator so it is not accessible
    if($sendConfirmationMsg) {
        LogUtil::registerStatus (__("L'edició del llibre no estarà disponible fins que la persona a qui se n'ha assignat l'administració confimi que vol ser-ne l'administrador/a. Ho pot fer des de la mateixa Prestatgeria. Quan s'hi identifiqui rebrà un avís d'assignació.",$dom));
		//send mail to user
		//Check if module Mailer is active
		$modid = pnModGetIDFromName('Mailer');
		$modinfo = pnModGetInfo($modid);
		//if it is active
		if($modinfo['state'] == 3) {
			$pnRender = pnRender::getInstance('books',false);
			$school = pnModAPIFunc('books','user','getSchool', array('schoolCode' => $book['schoolCode']));
			$book = array('bookTitle' => $bookTitle,
							'schoolType' => $school[0]['schoolType'],
							'schoolName' => $school[0]['schoolName'],
							'schoolCode' => $school[0]['schoolCode'],
							'bookId' => $bookId);
			$pnRender->assign('book',$book);
			$pnRender->assign('bookSoftwareUrl', pnModGetVar('books', 'bookSoftwareUrl'));
			$sendResult = pnModAPIFunc('Mailer', 'user', 'sendmessage', array('toname' => $oBookAdminName,
																				'toaddress' => $oBookAdminName . pnModGetVar('books','mailDomServer'),
																				'subject' => __("Se t'ha l'administració d'un llibre que has d'acceptar",$dom),
																				'body' => $pnRender->fetch('books_user_newEditBookMail.htm'),
																				'html' => 1));
		}
    }
    // the book has been edited successfuly
    // return user to previous page
    return pnModFunc('books', 'user', 'displayMsg', array('msg' => __("El llibre s'ha editat correctament.",$dom),
                                                         'title' => __('Edita el llibre',$dom),
                                                         'result' => 1,
                                                         'returnURL' => $returnURL));
}

/**
 * exports a book as zip file with html structure and offers to the user the opportunity to download it
 * @author:	Francesc Bassas i Bullich
 * @param:	$args	array with the bookId
 * @return:	output	force download
*/
function books_user_getHtmlBook($args)
{
	$dom = ZLanguage::getThemeDomain('Books');
	
	// bookId
	$bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'GET');

	// argument check
	if ($bookId == null || !is_numeric($bookId)) {
		return LogUtil::registerError (_MODARGSERROR);
	}

	// security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerPermissionError();
	}

	// checks if the user can export the book
	if (!pnModAPIFunc('books','user','canExport',array('bookId' => $bookId))) {
		return LogUtil::registerPermissionError();
	}

	Loader::RequireOnce("modules/books/pnincludes/Book.php");

	$book = pnModAPIFunc('books','user','getBookById', array('bookId' => $bookId));

	if (!$book) return LogUtil::registerError(__("No s'ha pogut exportar el llibre",$dom));

	$bookSoftwareUri = pnModGetVar('books','bookSoftwareUri');

	$book->replaceImageFolder($bookSoftwareUri . '/centres/' . $book->getSchoolCode() . '_' . $book->getBookId() . '/','book_images/');

	// save the book as html structure
	global $PNConfig;
	$html_dir = $PNConfig['System']['temp'] . '/books/export/html/' . 'llibre.html' . $bookId . '/';	// 'book.html'
	$book->book2html($html_dir);

	$filepath = $PNConfig['System']['temp'] . '/books/export/html/' . 'llibre.html.' . $bookId . '.zip';// 'book.html'

	Loader::RequireOnce("modules/books/pnincludes/pclzip.lib.php");
	$file = new PclZip($filepath);
	$v_list = $file->create($html_dir,PCLZIP_OPT_REMOVE_PATH,$html_dir,PCLZIP_OPT_ADD_PATH,'llibre.html');	// 'book.html'
	if ($v_list == 0) {
	      return LogUtil::registerError('Error : ' . $file->errorInfo(true));
	}

	Loader::loadClass('FileUtil');

	FileUtil::deldir($html_dir);

	header('Content-Description: File Transfer');
	header('Content-Type: application/zip');
	header('Content-Transfer-Encoding: binary');
	header('Content-Disposition: attachment; filename=' . 'llibre.html.zip');
	header('Content-Length: ' . filesize($filepath));
	readfile($filepath);

	unlink($filepath);

	// halts execution
	pnShutDown();
}

/**
 * exports a book as zip file with html structure and offers to the user the opportunity to download it
 * @author:	Francesc Bassas i Bullich
 * @param:	$args	array with the bookId
 * @return:	output	force download
*/
function books_user_getEpubBook($args)
{
	$dom = ZLanguage::getThemeDomain('Books');
	
	// bookId
	$bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'GET');

	// argument check
	if ($bookId == null || !is_numeric($bookId)) {
		return LogUtil::registerError (_MODARGSERROR);
	}

	// security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerPermissionError();
	}

	// checks if the user can export the book
	if (!pnModAPIFunc('books','user','canExport',array('bookId' => $bookId))) {
		return LogUtil::registerPermissionError();
	}

	Loader::RequireOnce("modules/books/pnincludes/Book.php");

	$book = pnModAPIFunc('books','user','getBookById', array('bookId' => $bookId));

	if (!$book) return LogUtil::registerError(__("No s'ha pogut exportar el llibre",$dom));

	$bookSoftwareUri = pnModGetVar('books','bookSoftwareUri');

	$book->replaceImageFolder($bookSoftwareUri . '/centres/' . $book->getSchoolCode() . '_' . $book->getBookId() . '/','images/');

	// save the book as epub file	
	global $PNConfig;
	$epub_dir = substr($_SERVER['SCRIPT_FILENAME'],0, strrpos($_SERVER['SCRIPT_FILENAME'],'/')+1) . $PNConfig['System']['temp'] . '/books/export/epub/' . 'book' . $bookId . '/';
	$filepath = $book->book2epub($epub_dir);
	$filename = basename($filepath);

	header('Content-Description: File Transfer');
	header('Content-Type: application/zip');
	header('Content-Transfer-Encoding: binary');
	header('Content-Disposition: attachment; filename=' . $filename);
	header('Content-Length: ' . filesize($filepath));
	readfile($filepath);

	Loader::loadClass('FileUtil');
	FileUtil::deldir($PNConfig['System']['temp'] . '/books/export/epub/' . 'book' . $bookId . '/');

	// halts execution
	pnShutDown();
}

/**
 * exports a book as SCORM package and offers to the user the opportunity to download it
 * @author:	Francesc Bassas i Bullich
 * @param:	$args	array with the bookId
 * @return:	output	force download
*/
function books_user_getScormBook($args)
{
	$dom = ZLanguage::getThemeDomain('Books');
	
	// bookId
	$bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'GET');

	// argument check
	if ($bookId == null || !is_numeric($bookId)) {
		return LogUtil::registerError (_MODARGSERROR);
	}

	// security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerPermissionError();
	}

	// checks if the user can export the book
	if (!pnModAPIFunc('books','user','canExport',array('bookId' => $bookId))) {
		return LogUtil::registerPermissionError();
	}

	Loader::RequireOnce("modules/books/pnincludes/Book.php");

	$book = pnModAPIFunc('books','user','getBookById', array('bookId' => $bookId));

	if (!$book) return LogUtil::registerError(__("No s'ha pogut exportar el llibre",$dom));

	$bookSoftwareUri = pnModGetVar('books','bookSoftwareUri');

	$book->replaceImageFolder($bookSoftwareUri . '/centres/' . $book->getSchoolCode() . '_' . $book->getBookId() . '/','book_images/');

	global $PNConfig;
	$filepath = $PNConfig['System']['temp'] . '/books/export/scorm/';

	$filename = 'scorm_book' . $bookId . '.zip';

	$book->book2scorm($filepath,$filename);

	header('Content-Description: File Transfer');
	header('Content-Type: application/zip');
	header('Content-Transfer-Encoding: binary');
	header('Content-Disposition: attachment; filename=' . 'llibre.scorm.zip');
	header('Content-Length: ' . filesize($filepath . $filename));
	readfile($filepath . $filename);

	unlink($filepath . $filename);

	// halts execution
	pnShutDown();
}

/**
 * exports a book as zip file with xml structure and offers to the user the opportunity to download it
 * @author:	Francesc Bassas i Bullich
 * @param:	$args	array with the bookId
 * @return:	output	force download
*/
function books_user_exportBook($args)
{
	$dom = ZLanguage::getThemeDomain('Books');
	
	// bookId
	$bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'GET');

	// argument check
	if ($bookId == null || !is_numeric($bookId)) {
		return LogUtil::registerError(_MODARGSERROR);
	}

	// security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerPermissionError();
	}

	// checks if the user can export the book
	if (!pnModAPIFunc('books','user','canExport',array('bookId' => $bookId))) {
		return LogUtil::registerPermissionError();
	}

	Loader::RequireOnce('modules/books/pnincludes/Book.php');

	$book = pnModAPIFunc('books','user','getBookById', array('bookId' => $bookId));

	if (!book) return LogUtil::registerError(__("No s'ha pogut exportar el llibre",$dom));

	$bookSoftwareUri = pnModGetVar('books','bookSoftwareUri');

	$book->replaceImageFolder($bookSoftwareUri . '/centres/' . $book->getSchoolCode() . '_' . $book->getBookId() . '/','/book_images/');

	global $PNConfig;
	$path = $PNConfig['System']['temp'] . '/books/export/xml/' . $bookId . '/';

	mkdir($path);
	chmod($path,0777);

	if (!$book->book2xml($path . 'book.xml')) {
		return LogUtil::registerError(__("No s'ha pogut exportar el llibre",$dom));
	}

	Loader::RequireOnce('modules/books/pnincludes/utils.php');

	copydir(pnModGetVar('books','serverImageFolder') . '/' . $book->getSchoolCode() . '_' . $book->getBookId(),$path . 'book_images');

	Loader::RequireOnce("modules/books/pnincludes/pclzip.lib.php");
	$filepath = $PNConfig['System']['temp'] . '/books/export/xml/' . $bookId . '.zip';
	$file = new PclZip($filepath);
	$v_list = $file->create($path,PCLZIP_OPT_REMOVE_PATH,$path);

	Loader::loadClass('FileUtil');
	FileUtil::deldir($path);

	header('Content-Description: File Transfer');
	header('Content-Type: application/zip');
	header('Content-Transfer-Encoding: binary');
	header('Content-Disposition: attachment; filename=' . 'llibre.xml.zip');
	header('Content-Length: ' . filesize($filepath));
	readfile($filepath);

	unlink($filepath);

	// halts execution
	pnShutDown();
}

/**
 * imports a book from a zip file with xml structure
 * @author:	Francesc Bassas i Bullich
 * @param:	$args	array with the path to the file to import, the schoolCode, the username and the password
 * @return:	output	main site
*/
function books_user_importBook($args)
{
	$dom = ZLanguage::getThemeDomain('Books');
	
	// path to the file
	$filename = FormUtil::getPassedValue('path', isset($args['path']) ? $args['path'] : null, 'POST');
	// schoolCode
	$schoolCode = FormUtil::getPassedValue('schoolCode', isset($args['schoolCode']) ? $args['schoolCode'] : null, 'POST');
	// username
	$username = FormUtil::getPassedValue('username', isset($args['username']) ? $args['username'] : null, 'POST');
	// bookCollection
	$bookCollection = FormUtil::getPassedValue('bookCollection', isset($args['bookCollection']) ? $args['bookCollection'] : null, 'POST');

	// argument check
    if (!isset($args['path'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if (!isset($args['schoolCode'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if (!isset($args['username'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if (!isset($args['bookCollection'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }

	// security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerPermissionError();
	}

	// checks if the user can import a book
	if (!pnModAPIFunc('books','user','canImport',array('schoolCode' => $schoolCode))) {
		return LogUtil::registerError(__('No teniu permís per importar el llibre.',$dom));
	}

	Loader::RequireOnce("modules/books/pnincludes/pclzip.lib.php");

	global $PNConfig;
	$tmp = $PNConfig['System']['temp'] . '/books/import/' . time();

	$file = new PclZip($filename);
	if ( $file->extract(PCLZIP_OPT_PATH,$tmp) == 0) {
		return LogUtil::registerError ($file->errorInfo(true));
	}

	unlink($filename);

	Loader::RequireOnce("modules/books/pnincludes/Book.php");

	// loads the xml file to the book object
	$book = Book::xml2book($tmp . '/book.xml');

	if (!$book) {
		return LogUtil::registerError(__("S'ha produït un error en importar el llibre.",$dom));
	}

	if (!$bookId = pnModAPIFunc('books', 'user', 'insertBookRow',
                                array('book' => $book,
                                        'schoolCode' => $schoolCode,
                                        'username' => $username,
                                        'bookCollection' => $bookCollection))) {
		LogUtil::registerError(__("S'ha produït un error en importar el llibre.",$dom));
	}

	$book->replaceImageFolder('/book_images/', pnModGetVar('books','bookSoftwareUri') . '/centres/' . $schoolCode . '_' . $bookId . '/');

	if (!pnModAPIFunc('books','user','insertBookTables',array('book' => $book,'schoolCode' => $schoolCode,'bookId' => $bookId,'username' => $username))) {
		LogUtil::registerError(__("S'ha produït un error en importar el llibre.",$dom));
	}

	pnModAPIFunc('books','user','changeURLImageFolder',array('bookId' => $bookId, 'schoolCode' => $schoolCode));

	// import book images
	Loader::RequireOnce('modules/books/pnincludes/utils.php');

	copydir($tmp . '/book_images',pnModGetVar('books','serverImageFolder') . '/' . $schoolCode . '_' . $bookId);

	chmod($image_folder . $schoolCode . '_' . $bookId, 0777);
	chmod($image_folder . $schoolCode . '_' . $bookId . '/.thumbs', 0777);

	Loader::loadClass('FileUtil');
	FileUtil::deldir($tmp);

    return true;
}

/**
 * create the book rss and redirect user to the rss page
 * @author:	Albert Pérez Monfort
 * @param:	$args	array with the fisbn of the book
 * @return:	redirect the user to the rss page
*/
function books_user_getRss($args)
{
    // bookId
    $fisbn = FormUtil::getPassedValue('fisbn', isset($args['fisbn']) ? $args['fisbn'] : null, 'GET');
    // security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerPermissionError();
	}
    include_once('../config/xtecAPI.php');
    generateRss($fisbn);
    return pnRedirect('../rss/' . $fisbn . '.xml');
}

/**
 * Displays an informative page about the results obtained after create a new book
 * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
 * @return:	The book information and information about the creation process
*/
function books_user_displayMsg($args)
{
	$result = FormUtil::getPassedValue('result', isset($args['result']) ? $args['result'] : null, 'POST');
	$msg = FormUtil::getPassedValue('msg', isset($args['msg']) ? $args['msg'] : null, 'POST');
    $title = FormUtil::getPassedValue('title', isset($args['title']) ? $args['title'] : null, 'POST');
    $returnURL = FormUtil::getPassedValue('returnURL', isset($args['returnURL']) ? $args['returnURL'] : 'index.php', 'POST');
	// create output object
	$pnRender = pnRender::getInstance('books',false);
	$pnRender->assign('result', $result);
	$pnRender->assign('msg', $msg);
	$pnRender->assign('title', $title);
    $pnRender->assign('returnURL', $returnURL);
	return $pnRender->fetch('books_user_bookMsg.htm');
}
