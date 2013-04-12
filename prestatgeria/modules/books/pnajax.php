<?php
function books_ajax_showBookData($args)
{
	if (!SecurityUtil::checkPermission('books::', '::', ACCESS_READ)) {
		AjaxUtil::error(DataUtil::formatForDisplayHTML(_MODULENOAUTH));
	}
	$bookId = FormUtil::getPassedValue('bookId', -1, 'GET');
	if ($bookId == -1) {
		AjaxUtil::error('no book id');
	}
	$content = pnModFunc('books', 'user', 'getBookData', array('bookId' => $bookId));
	AjaxUtil::output(array('content' => $content));
}

function books_ajax_catalogue($args)
{
	if (!SecurityUtil::checkPermission('books::', '::', ACCESS_READ)) {
		AjaxUtil::error(DataUtil::formatForDisplayHTML(_MODULENOAUTH));
	}
	$order = FormUtil::getPassedValue('order', -1, 'GET');
	if ($order == -1) {
		AjaxUtil::error('no book id');
	}
	$init = FormUtil::getPassedValue('init', -1, 'GET');
	if ($init == -1) {
		AjaxUtil::error('no book id');
	}
	$filter = FormUtil::getPassedValue('filter', -1, 'GET');
	$filterValue = FormUtil::getPassedValue('filterValue', -1, 'GET');
	$history = FormUtil::getPassedValue('history', -1, 'GET');
	$content = pnModFunc('books', 'user', 'catalogue', array('order' => $order,
                        										'init' => $init,
                        										'history' => $history,
                        										'filter' => $filter,
                        										'filterValue' => $filterValue));
	AjaxUtil::output(array('content' => $content));
}

function books_ajax_addPrefer($args)
{
	if (!SecurityUtil::checkPermission('books::', '::', ACCESS_READ) || !pnUserLogin()) {
		AjaxUtil::error(DataUtil::formatForDisplayHTML(_MODULENOAUTH));
	}
	$bookId = FormUtil::getPassedValue('bookId', -1, 'GET');
	if ($bookId == -1) {
		AjaxUtil::error('no book id');
	}
	$added = pnModAPIFunc('books', 'user', 'addPrefer', array('bookId' => $bookId));
	if(!$added){
		AjaxUtil::error('adding error');
	}
	$prefered = pnModAPIFunc('books', 'user', 'getPrefered');
	// Check if the user is logged in
	if(!$prefered){
		AjaxUtil::error('no prefered found');
	}
	$books = pnModAPIFunc('books','user','getAllBooks', array('init' => 0,
                        										'ipp' => 1000000,
                        										'order' => 'bookHits',
                        										'filter' => 'prefered',
                        										'filterValue' => $prefered,
                        										'notJoin' => 1));
	foreach($books as $book){
		$booksArray[] = array('bookTitle' => $book['bookTitle'],
				        		'bookId' => $book['bookId']);
	}
	// Create output object
	$pnRender = pnRender::getInstance('books',false);
	$pnRender -> assign('books',$booksArray);
	$content = $pnRender -> fetch('books_block_myPrefered.htm');
	AjaxUtil::output(array('content' => $content));
}

function books_ajax_delPrefer($args)
{
	if (!SecurityUtil::checkPermission('books::', '::', ACCESS_READ) || !pnUserLogin()) {
		AjaxUtil::error(DataUtil::formatForDisplayHTML(_MODULENOAUTH));
	}
	$bookId = FormUtil::getPassedValue('bookId', -1, 'GET');
	if ($bookId == -1) {
		AjaxUtil::error('no book id');
	}
	$deleted = pnModAPIFunc('books', 'user', 'delPrefer', array('bookId' => $bookId));
	if(!$deleted){
		AjaxUtil::error('delete error');
	}
	AjaxUtil::output(array('bookId' => $bookId));
}

function books_ajax_addComment($args)
{
	if (!SecurityUtil::checkPermission('books::', '::', ACCESS_COMMENT)) {
		AjaxUtil::error(DataUtil::formatForDisplayHTML(_MODULENOAUTH));
	}
	$bookId = FormUtil::getPassedValue('bookId', -1, 'GET');
	if ($bookId == -1) {
		AjaxUtil::error('no book id');
	}
	$history = FormUtil::getPassedValue('history', -1, 'GET');
	$content = pnModFunc('books', 'user', 'addComment', array('bookId' => $bookId,
									                        	'history' => $history));
	AjaxUtil::output(array('content' => $content));
}

function books_ajax_sendComment($args)
{
	if (!SecurityUtil::checkPermission('books::', '::', ACCESS_COMMENT)) {
		AjaxUtil::error(DataUtil::formatForDisplayHTML(_MODULENOAUTH));
	}
	$bookId = FormUtil::getPassedValue('bookId', -1, 'GET');
	if ($bookId == -1) {
		AjaxUtil::error('no book id');
	}
	$commentText = FormUtil::getPassedValue('commentText', -1, 'GET');
	if ($commentText == -1) {
		AjaxUtil::error('no text');
	}
	$history = FormUtil::getPassedValue('history', -1, 'GET');
	//insert comment into data base
	if(!pnModAPIFunc('books', 'user', 'createComment', array('commentText' => $commentText,
								                        		'bookId' => $bookId))){
		AjaxUtil::error('Error sending value');
	}
	if($history == 2){
		$content = pnModFunc('books', 'user', 'catalogue', array('order' => $order,
											'init' => $init,
											'history' => $history));
	}else{
		$content = pnModFunc('books', 'user', 'getBookData', array('bookId' => $bookId));
	}
	AjaxUtil::output(array('content' => $content));
}

function books_ajax_collections($args)
{
	if (!SecurityUtil::checkPermission('books::', '::', ACCESS_READ)) {
		AjaxUtil::error(DataUtil::formatForDisplayHTML(_MODULENOAUTH));
	}
	$content = pnModFunc('Books', 'user', 'collections');
	AjaxUtil::output(array('content' => $content));
}

function books_ajax_searchReload($args)
{
	if (!SecurityUtil::checkPermission('books::', '::', ACCESS_READ)) {
		AjaxUtil::error(DataUtil::formatForDisplayHTML(_MODULENOAUTH));
	}
	$filter = FormUtil::getPassedValue('filter', -1, 'GET');
	if ($filter == -1) {
		AjaxUtil::error('no filter');
	}
	$filterValue = FormUtil::getPassedValue('filterValue', -1, 'GET');
	if ($filterValue == -1) {
		AjaxUtil::error('no filter');
	}
	$order = FormUtil::getPassedValue('order', -1, 'GET');
	$content = pnModFunc('books', 'user', 'search', array('filter' => $filter,
															'filterValue' => $filterValue,
															'order' => $order));
	AjaxUtil::output(array('content' => $content));
}


function books_ajax_autocompleteSearch($args)
{
	if (!SecurityUtil::checkPermission('books::', '::', ACCESS_READ)) {
		AjaxUtil::error(DataUtil::formatForDisplayHTML(_MODULENOAUTH));
	}
	$value = FormUtil::getPassedValue('value', -1, 'GET');
	$filter = FormUtil::getPassedValue('filter', -1, 'GET');
	$order = FormUtil::getPassedValue('order', 'lastEntry', 'GET');
	$values = pnModAPIFunc('books', 'user', 'filterValues', array('value' => $value,
									                            	'filter' => $filter));
	$valueEntered = $value;
	$valuesArray = array();
	foreach($values as $value){
		switch($filter){
			case 'name':
				$valuesString .= "<div><a style=\"cursor: pointer;\" onclick=\"catalogue('$order','name',1,'".$value['schoolId']."',1)\">".$value['schoolType'].' '.$value['schoolName']." (".$value['schoolCity'].")</a></div>";
				break;
			case 'descriptor':
				$pos = strpos($value['bookDescript'],$valueEntered);
				$string = substr($value['bookDescript'],$pos);
				$pos2 = strpos($string,"#");
				$string = substr($string,0,$pos2);
				if(!in_array($string, $valuesArray)){
					$valuesString .= "<div><a style=\"cursor: pointer;\" onclick=\"catalogue('$order','descriptor',1,'".$string."',1)\">".$string."</a></div>";
					$valuesArray[] = $string;
				}
				break;
			case 'city':
				if(!in_array($value['schoolCity'], $valuesArray)){
					$valuesString .= "<div><a style=\"cursor: pointer;\" onclick=\"catalogue('$order','city',1,'".str_replace("'",'--apos--',$value['schoolCity'])."',1)\">".$value['schoolCity']."</a></div>";
					$valuesArray[] = $value['schoolCity'];
				}
			case 'admin':
				if(!in_array($value['bookAdminName'], $valuesArray)){
					$valuesString .= "<div><a style=\"cursor: pointer;\" onclick=\"catalogue('$order','admin',1,'".$value['bookAdminName']."',1)\">".$value['bookAdminName']."</a></div>";
					$valuesArray[] = $value['bookAdminName'];
				}
				break;
		}
	}
	AjaxUtil::output(array('values' => $valuesString,
							'count' => count($values)));
}

function books_ajax_manage($args)
{
	if (!SecurityUtil::checkPermission('books::', '::', ACCESS_READ)) {
		AjaxUtil::error(DataUtil::formatForDisplayHTML(_MODULENOAUTH));
	}
	$content = pnModFunc('books', 'user', 'manage');
	AjaxUtil::output(array('content' => $content));
}

function books_ajax_showCreators($args)
{
	if (!SecurityUtil::checkPermission('books::', '::', ACCESS_READ)) {
		AjaxUtil::error(DataUtil::formatForDisplayHTML(_MODULENOAUTH));
	}
	$task = FormUtil::getPassedValue('task', -1, 'GET');
	if ($task == -1) {
		AjaxUtil::error('no task defined');
	}
	$userName = FormUtil::getPassedValue('userName', -1, 'GET');
	if($userName != ''){
		if($task == 'addCreator'){
			if (!pnModAPIFunc('books', 'user', 'addCreator', array('userName' => $userName))) {
				AjaxUtil::error('error creating user');
			}
		}
		if($task == 'deleteCreator'){
			if (!pnModAPIFunc('books', 'user', 'deleteCreator', array('userName' => $userName))) {
				AjaxUtil::error('error deleting user');
			}
		}
	}
	$content = pnModFunc('books', 'user', 'getCreators');
	AjaxUtil::output(array('content' => $content));
}

function books_ajax_editDescriptor($args)
{
	if (!SecurityUtil::checkPermission('books::', '::', ACCESS_ADMIN)) {
		AjaxUtil::error(DataUtil::formatForDisplayHTML(_MODULENOAUTH));
	}
	$did = FormUtil::getPassedValue('did', -1, 'GET');
	if ($did == -1) {
		AjaxUtil::error('no descriptor id');
	}
	$content = pnModFunc('books', 'admin', 'descriptorRowContent', array('did' => $did));
	AjaxUtil::output(array('did' => $did,
							'content' => $content));
}

function books_ajax_updateDescriptor($args)
{
	if (!SecurityUtil::checkPermission('books::', '::', ACCESS_ADMIN)) {
		AjaxUtil::error(DataUtil::formatForDisplayHTML(_MODULENOAUTH));
	}
	$did = FormUtil::getPassedValue('did', -1, 'GET');
	if ($did == -1) {
		AjaxUtil::error('no descriptor id');
	}
	$value = FormUtil::getPassedValue('value', -1, 'GET');
	if ($value == -1) {
		AjaxUtil::error('no value defined');
	}
    // get old value
    if(!$descriptor = pnModAPIFunc('books', 'user', 'getDescriptor', array('did' => $did))){
        AjaxUtil::error('get old value faild');
    }
    $oldValue = $descriptor['descriptor'];
	// recalc descriptors number and change the descriptor in all the books
	$booksArray = pnModAPIFunc('books', 'user', 'getAllBooks', array('init' => -1,
																	'rpp' => -1,
																	'notJoin' => 1,
																	'filter' => 'descriptor',
																	'filterValue' => $oldValue));
    // get the number in case the descriptor exists. In this case it is the addition
	$number = pnModAPIFunc('books', 'user', 'getAllBooks', array('init' => -1,
																	'rpp' => -1,
																	'notJoin' => 1,
																	'filter' => 'descriptor',
																	'onlyNumber' => 1,
																	'filterValue' => $value));
    // if the value exists it is an addition so the value is delete
    if($number > 0){
        pnModAPIFunc('books','admin','deleteDescriptor', array('did' => $descriptor['did'],
                                                                'descriptor' => $value));
    } else {
        $number = 0;
    }
    $number = $number + count($booksArray);
    $value = $value;
	// edit descriptor
	if(!pnModAPIFunc('books','admin','updateDescriptor',array('did' => $did,
                                                                'items' => array('descriptor' => $value,
                                                                                    'number' => $number)))){
		AjaxUtil::error('error updating descriptor');
	} else {
	    foreach($booksArray as $book){
	        $valueToChange = str_replace('#' . $oldValue . '#', '#' . $value . '#', $book['bookDescript']);
            pnModAPIFunc('books', 'user', 'editBook', array('bookId' => $book['bookId'],
                                                             'items' => array('bookDescript' => $valueToChange)));
        }
	}
	AjaxUtil::output(array('did' => $did,
							'content' => $value));
}

function books_ajax_deleteDescriptor($args)
{
	if (!SecurityUtil::checkPermission('books::', '::', ACCESS_ADMIN)) {
		AjaxUtil::error(DataUtil::formatForDisplayHTML(_MODULENOAUTH));
	}
	$did = FormUtil::getPassedValue('did', -1, 'GET');
	if ($did == -1) {
		AjaxUtil::error('no descriptor id');
	}
	$descriptor = pnModAPIFunc('books', 'user', 'getDescriptor', array('did' => $did));
	// delete descriptor from data base
	if(!pnModAPIFunc('books','admin','deleteDescriptor', array('did' => $did))){
		AjaxUtil::error('error deleting descriptor');
	}
	// delete descriptor from books
	// get all the books that have the descriptor
	$books = pnModAPIFunc('books', 'user', 'getAllBooks', array('init' => -1,
																'rpp' => -1,
																'notJoin' => 1,
																'filter' => 'descriptor',
																'filterValue' => $descriptor['descriptor']));
	// delete descriptors
	foreach($books as $book){
		$descriptorsValue = str_replace('#' . $descriptor['descriptor'] . '#', '', $book['bookDescript']);
		pnModAPIFunc('books', 'user', 'editBook', array('bookId' => $book['bookId'],
														'items' => array('bookDescript' => $descriptorsValue)));
	}
	AjaxUtil::output(array('did' => $did));
}

function books_ajax_descriptors($args)
{
	if (!SecurityUtil::checkPermission('books::', '::', ACCESS_READ)) {
		AjaxUtil::error(DataUtil::formatForDisplayHTML(_MODULENOAUTH));
	}
    $content = pnModFunc('Books', 'user', 'descriptors');
    AjaxUtil::output(array('content' => $content));
}