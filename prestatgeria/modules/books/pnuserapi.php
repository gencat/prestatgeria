<?php
/**
 * connects to school's database
 * @author:	Francesc Bassas i Bullich
 * @param:	args	Array with the schoolId
 * @return:	database connection
*/
function books_userapi_connect($args)
{
	$dom = ZLanguage::getThemeDomain('Books');
	
	$schoolId = FormUtil::getPassedValue('schoolId', isset($args['schoolId']) ? $args['schoolId'] : null, 'POST');
	// Security check
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	// Needed argument
	if($schoolId == null || !is_numeric($schoolId)) {
		return LogUtil::registerError (_MODARGSERROR);
	}
	// calculate data base index
	$idb = floor($schoolId/50) + 1;
	global $PNConfig;
	$PNConfig['DBInfo']['book']['dbname'] = pnModGetVar('books','booksDatabase') . $idb;
	// Initialize the DBConnection and place it on the connection stack
	$connect = DBConnectionStack::init('book');
	if(!$connect) {
		return LogUtil::registerError (__('La connexió amb la base de dades de llibres ha fallat',$dom) . ': ' . pnModGetVar('books','booksDatabase').$idb);
	}
	return $connect;
}

/**
 * get all the books available
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	args	Array with the init page and the number of items per page
 * @return:	An array with the groups information
*/
function books_userapi_getAllBooks($args)
{
	$init = FormUtil::getPassedValue('init', isset($args['init']) ? $args['init'] : null, 'POST');
	$ipp = FormUtil::getPassedValue('ipp', isset($args['ipp']) ? $args['ipp'] : null, 'POST');
	$order = FormUtil::getPassedValue('order', isset($args['order']) ? $args['order'] : null, 'POST');
	$notJoin = FormUtil::getPassedValue('notJoin', isset($args['notJoin']) ? $args['notJoin'] : null, 'POST');
	$bookState = FormUtil::getPassedValue('bookState', isset($args['bookState']) ? $args['bookState'] : 1, 'POST');
	$onlyNumber = FormUtil::getPassedValue('onlyNumber', isset($args['onlyNumber']) ? $args['onlyNumber'] : null, 'POST');
	$filter = FormUtil::getPassedValue('filter', isset($args['filter']) ? $args['filter'] : null, 'POST');
	$filterValue = FormUtil::getPassedValue('filterValue', isset($args['filterValue']) ? $args['filterValue'] : null, 'POST');
    $acceptEdit = FormUtil::getPassedValue('acceptEdit', isset($args['acceptEdit']) ? $args['acceptEdit'] : null, 'POST');
	// Security check
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$myJoin = array();
	$myJoin[] = array('join_table' => 'books',
						'join_field' => array(),
						'object_field_name' => array(),
						'compare_field_table' => 'bookId',
						'compare_field_join' => 'bookId');
	if($notJoin == null) {
		$myJoin[] = array('join_table' => 'books_schools',
							'join_field' => array('schoolName','schoolType','schoolCity'),
							'object_field_name' => array('schoolName','schoolType','schoolCity'),
							'compare_field_table' => 'schoolCode',
							'compare_field_join' => 'schoolCode');
	}
	switch($order) {
		case 'lastCreated':
			$orderbyField = 'bookId';
			break;
		case 'bookPages':
			$orderbyField = 'bookPages';
			break;
		case 'bookHits':
			$orderbyField = 'bookHits';
			break;
		default:
			$orderbyField = 'lastEntry';
	}
	$pntables = pnDBGetTables();
	$ocolumn = $pntables['books_column'];
	$lcolumn = $pntables['books_schools_column'];
	switch($filter) {
		case 'userBooks':
			$where = " AND a.$ocolumn[bookAdminName] ='$filterValue'";
			break;
		case 'prefered':
			$where = " AND (";
			foreach($filterValue as $value) {
				$where .= "a.$ocolumn[bookId] ='$value[bookId]' OR ";
			}
			$where = substr($where,0,-3);
			$where .= ')';
			break;
		case 'descriptor':
			$where = " AND a.$ocolumn[bookDescript] LIKE '%#$filterValue#%'";
			break;
		case 'collection':
			$where = " AND a.$ocolumn[collectionId] = $filterValue";
			break;
		case 'admin':
			$where = " AND a.$ocolumn[bookAdminName] = '$filterValue'";
			break;
		case 'schoolCode':
			$where = " AND a.$ocolumn[schoolCode] = '$filterValue'";
			break;
		case 'name':
			$where = " AND b.$lcolumn[schoolId] = $filterValue";
			break;
		case 'city':
			$where = " AND b.$lcolumn[schoolCity] = '$filterValue'";
			break;
		case 'lang':
			$where = " AND a.$ocolumn[bookLang] = '$filterValue'";
			break;
		case 'title':
			if($filterValue != '') {
				$where = " AND (";
				$values = explode(' ',$filterValue);
				foreach($values as $value) {
					if($value != '') {
						$where .= " (a.$ocolumn[bookTitle] LIKE '$value %' OR a.$ocolumn[bookTitle] LIKE '% $value %' OR a.$ocolumn[bookTitle] LIKE '% $value') OR ";
					}
				}
				$where = substr($where,0,-3);
				$where .= ')';
			} else {
				$where = '';
			}
			break;
		default:
			$where = '';
	}
	if($bookState != 'all') {
	    if($acceptEdit == null) {
		    $where = "a.$ocolumn[bookState] = $bookState" . $where;
        } else {
            // this case is possible only during user's acceptation process
            $where = "(a.$ocolumn[bookState] = '-1' AND a.$ocolumn[bookAdminName]='" . pnUserGetVar('uname') . "') OR (a.$ocolumn[bookAdminName]='' AND a.$ocolumn[newBookAdminName]='" . pnUserGetVar('uname') . "')";
        }
	} else {
		$where = substr($where, 4);
	}
    //print $where;die();
	$orderby = "a.$ocolumn[$orderbyField] desc";
	if($onlyNumber == null) {
		$items = DBUtil::selectExpandedObjectArray('books', $myJoin, $where, $orderby, $init, $ipp, 'bookId');
	} else {
		$items = DBUtil::selectExpandedObjectCount('books', $myJoin, $where, 'bookId');
	}
	// Return the items
	return $items;
}

/**
 * get a book information
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	args	Array with the form identity
 * @return:	An array with the groups information
*/
function books_userapi_getBook($args)
{
	$bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
	// Security check
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$myJoin = array();
	$myJoin[] = array('join_table' => 'books',
						'join_field' => array(),
						'object_field_name' => array(),
						'compare_field_table' => 'bookId',
						'compare_field_join' => 'bookId');
	$myJoin[] = array('join_table' => 'books_schools',
						'join_field' => array('schoolName','schoolType','schoolCity'),
						'object_field_name' => array('schoolName','schoolType','schoolCity'),
						'compare_field_table' => 'schoolCode',
						'compare_field_join' => 'schoolCode');
	$where = '';
	$pntables = pnDBGetTables();
	$ocolumn   = $pntables['books_column'];
	$lcolumn   = $pntables['books_schools_column'];
	$where = "a.$ocolumn[bookId] = '".$bookId."'";
	$item = DBUtil::selectExpandedObject('books', $myJoin, $where);
	if($item === false) {
		return LogUtil::registerError (_GETFAILED);
	}
	// Return the items
	return $item;
}

/**
 * get all the descriptors of all the books
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The number of descriptors that must be returned and the order
 * @return:	An array with the descriptors information
*/
function books_userapi_getAllDescriptors($args)
{
	$number = FormUtil::getPassedValue('number', isset($args['number']) ? $args['number'] : null, 'POST');
	$order = FormUtil::getPassedValue('order', isset($args['order']) ? $args['order'] : null, 'POST');
	// Security check
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$pntable = pnDBGetTables();
	$c = $pntable['books_descriptors_column'];
	$where = '';
	$orderby = ($order == null) ? "$c[number] desc" : "$c[$order]";
	$items = DBUtil::selectObjectArray('books_descriptors', $where, $orderby, '-1', $number, 'did');
	// Check for an error with the database code, and if so set an appropriate
	// error message and return
	if($items === false) {
		return LogUtil::registerError (_GETFAILED);
	}
	// Return the items
	return $items;
}

/**
 * get a descriptor
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The descriptor identity
 * @return:	The descriptor information
*/
function books_userapi_getDescriptor($args)
{
	$did = FormUtil::getPassedValue('did', isset($args['did']) ? $args['did'] : null, 'POST');
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	// Needed argument
	if($did == null || !is_numeric($did)) {
		return LogUtil::registerError (_MODARGSERROR);
	}
	$item = DBUtil::selectObjectByID('books_descriptors', $did, 'did');
	// Check for an error with the database code, and if so set an appropriate
	// error message and return
	if($item === false) {
		return LogUtil::registerError (_GETFAILED);
	}
	// Return the items
	return $item;
}

/**
 * get all the available collections depending on its state
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The state that must be returned
 * @return:	An array with the collections information
*/
function books_userapi_getAllCollection($args)
{
	$state = FormUtil::getPassedValue('state', isset($args['state']) ? $args['state'] : 0, 'POST');
	// Security check
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$pntable = pnDBGetTables();
	$c = $pntable['books_bookcollections_column'];
	$where = ($state) ? "$c[collectionState] = 1" : "";
	$orderby = "";
	$items = DBUtil::selectObjectArray('books_bookcollections', $where, $orderby, '-1', '-1', 'collectionId');
	// Check for an error with the database code, and if so set an appropriate
	// error message and return
	if($items === false) {
		return LogUtil::registerError (_GETFAILED);
	}
	// Return the items
	return $items;
}

/**
 * get a collection
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The collection identity
 * @return:	The collection information
*/
function books_userapi_getCollection($args)
{
	$collectionId = FormUtil::getPassedValue('collectionId', isset($args['collectionId']) ? $args['collectionId'] : null, 'POST');
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	// Needed argument
	if($collectionId == null || !is_numeric($collectionId)) {
		return LogUtil::registerError (_MODARGSERROR);
	}
	$items = DBUtil::selectObjectByID('books_bookcollections', $collectionId, 'collectionId');
	// Check for an error with the database code, and if so set an appropriate
	// error message and return
	if($items === false) {
		return LogUtil::registerError (_GETFAILED);
	}
	// Return the items
	return $items;
}

/**
 * get the number of books that are associated to a given collection
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The collection identity
 * @return:	The number of book in a collection
*/
function books_userapi_getBooksInCollection($args)
{
	$collectionId = FormUtil::getPassedValue('collectionId', isset($args['collectionId']) ? $args['collectionId'] : null, 'POST');
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	// Needed argument
	if($collectionId == null || !is_numeric($collectionId)) {
		return LogUtil::registerError (_MODARGSERROR);
	}
	$pntable = pnDBGetTables();
	$c = $pntable['books_column'];
	$where = "$c[collectionId] = $collectionId";
	$orderby = "";
	$items = DBUtil::selectObjectArray('books', $where, $orderby, '-1', '-1', 'bookId');
	// error message and return
	if($items === false) {
		return LogUtil::registerError (_GETFAILED);
	}
	// Return the items
	return count($items);
}

/**
 * get the prefered books for a user
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @return:	An array with the prefered books identities
*/
function books_userapi_getPrefered($args)
{
	if(!SecurityUtil::checkPermission('iw_forms::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$pntable = pnDBGetTables();
	$c = $pntable['books_userbooks_column'];
	$where = "$c[userName]='".pnUserGetVar('uname')."'";
	$items = DBUtil::selectObjectArray('books_userbooks', $where, '', '-1', '-1', 'ubid');
	// Check for an error with the database code, and if so set an appropriate
	// error message and return
	if($items === false) {
		return LogUtil::registerError (_GETFAILED);
	}
	// Return the items
	return $items;
}

/**
 * Add a book a prefered
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The book identity
 * @return:	The identity of the new insert if success and false otherwise
*/
function books_userapi_addPrefer($args)
{
	$bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
	if(!SecurityUtil::checkPermission('iw_forms::', "::", ACCESS_READ) || !pnUserLogin()) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$item = array('bookId' => $bookId,
			'userName' => pnUserGetVar('uname'));
	if(!DBUtil::insertObject($item, 'books_userbooks', 'ubid')) {
		return LogUtil::registerError (_CREATEFAILED);
	}
	// Return the id of the newly created item to the calling process
	return $item['ubid'];
}

/**
 * Delete a book as prefered
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The book identity
 * @return:	True if success and false otherwise
*/
function books_userapi_delPrefer($args)
{
	$bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
	if(!SecurityUtil::checkPermission('iw_forms::', "::", ACCESS_READ) || !pnUserLogin()) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$pntable = pnDBGetTables();
	$c = $pntable['books_userbooks_column'];
	$where = "WHERE $c[bookId]=$bookId AND $c[userName]='".pnUserGetVar('uname')."'";
	if(!DBUTil::deleteWhere ('books_userbooks', $where)) {
		return LogUtil::registerError (_DELETEFAILED);
	}
	return true;
}

/**
 * Save the current position of a user in the cataloge
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The items needed for storage the position in the cataloge
 * @return:	True if success and false otherwise
*/
function books_userapi_saveUserHistory($args)
{
	$item = FormUtil::getPassedValue('item', isset($args['item']) ? $args['item'] : null, 'POST');
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$pntable = pnDBGetTables();
	$c = $pntable['books_nav_column'];
	$where = "$c[sessid] ='".$GLOBALS['_PNSession']['obj']['sessid']."'";
	//Try to update if not create
	if(!DBUtil::selectObjectArray('books_nav', $where, '', '-1', '-1', 'unid')) {
		if(!DBUtil::insertObject($item, 'books_nav', 'unid')) {
			return LogUtil::registerError (_CREATEFAILED);
		}
		return $item['unid'];
	} else {
		if(!DBUTil::updateObject ($item, 'books_nav', $where)) {
			return LogUtil::registerError (_UPDATEFAILED);
		}
		return true;
	}
}

/**
 * Get the saved position of a user in the cataloge
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @return:	The parameters that allow system to recover the saved position in the cataloge
*/
function books_userapi_getUserHistory()
{
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$pntable = pnDBGetTables();
	$c = $pntable['books_nav_column'];
	$where = "$c[sessid] ='".$GLOBALS['_PNSession']['obj']['sessid']."'";
	//Try to update if not create
	$items = DBUtil::selectObjectArray('books_nav', $where, '', '-1', '-1', 'sessid');
	if(!items) {
		return LogUtil::registerError (_CREATEFAILED);
	}
	return $items;
}

/**
 * Save the current position of a user in the cataloge
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The items needed for storage the position in the cataloge
 * @return:	True if success and false otherwise
*/
function books_userapi_createComment($args)
{
	$bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
	$commentText = FormUtil::getPassedValue('commentText', isset($args['commentText']) ? $args['commentText'] : null, 'POST');
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_COMMENT)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$item = array('text' => $commentText,
					'bookId' => $bookId,
					'userName' => pnUserGetVar('uname'),
					'date' => time());
	if(!DBUtil::insertObject($item, 'books_comment', 'cid')) {
		return LogUtil::registerError (_CREATEFAILED);
	}
	return $item['cid'];
}

/**
 * Get all comments for a given book
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The book identity
 * @return:	An array with the comments for a book
*/
function books_userapi_getAllComments($args)
{
	$bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
	// Security check
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$pntable = pnDBGetTables();
	$c = $pntable['books_comment_column'];
	$where = "$c[bookId] = $bookId";
	$orderby = "$c[date] desc";
	$items = DBUtil::selectObjectArray('books_comment', $where, $orderby, '-1', '-1', 'cid');
	// Check for an error with the database code, and if so set an appropriate
	// error message and return
	if($items === false) {
		return LogUtil::registerError (_GETFAILED);
	}
	// Return the items
	return $items;
}

/**
 * Get the possible values for the filter during the sugest process
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The filter type and the current value
 * @return:	An array with the items that satisfy the filter
*/
function books_userapi_filterValues($args)
{
	$filter = FormUtil::getPassedValue('filter', isset($args['filter']) ? $args['filter'] : null, 'POST');
	$value = FormUtil::getPassedValue('value', isset($args['value']) ? $args['value'] : null, 'POST');
	// Security check
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$pntable = pnDBGetTables();
	switch($filter) {
		case 'name':
			$c = $pntable['books_schools_column'];
			$where = "$c[schoolName] LIKE '%$value%'";
			$orderby = "$c[schoolName] desc";
			$items = DBUtil::selectObjectArray('books_schools', $where, $orderby, '-1', '-1', 'schoolId');
			break;
		case 'admin':
			$c = $pntable['books_column'];
			$where .= "$c[bookAdminName] LIKE '$value%'";
			$orderby = "$c[bookAdminName] desc";
			$items = DBUtil::selectObjectArray('books', $where, $orderby, '-1', '-1', 'bookId');
			break;
		case 'city':
			$c = $pntable['books_schools_column'];
			$where = "$c[schoolCity] LIKE '$value%'";
			$orderby = "$c[schoolCity] desc";
			$items = DBUtil::selectObjectArray('books_schools', $where, $orderby, '-1', '-1', 'schoolId');
			break;
		case 'descriptor':
			$c = $pntable['books_column'];
			$where .= "$c[bookDescript] LIKE '%#$value%'";
			$orderby = "$c[bookDescript] desc";
			$items = DBUtil::selectObjectArray('books', $where, $orderby, '-1', '-1', 'bookDescript');
			break;

	}
	// Check for an error with the database code, and if so set an appropriate
	// error message and return
	if($items === false) {
		return LogUtil::registerError (_GETFAILED);
	}
	// Return the items
	return $items;
}

/**
 * Get a school information
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The school identity or the school code
 * @return:	An array with the school information
*/
function books_userapi_getSchool($args)
{
	$schoolId = FormUtil::getPassedValue('schoolId', isset($args['schoolId']) ? $args['schoolId'] : null, 'POST');
	$schoolCode = FormUtil::getPassedValue('schoolCode', isset($args['schoolCode']) ? $args['schoolCode'] : null, 'POST');
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	// Needed argument
	if(($schoolId == null || !is_numeric($schoolId)) && $schoolCode == null) {
		return LogUtil::registerError (_MODARGSERROR);
	}
	if($schoolId != null) {
		$items = DBUtil::selectObjectByID('books_schools', $schoolId, 'schoolId');
	} else {
		$pntable = pnDBGetTables();
		$c = $pntable['books_schools_column'];
		$where = "$c[schoolCode] = '$schoolCode'";
		$items = DBUtil::selectObjectArray('books_schools', $where);
	}
	// Check for an error with the database code, and if so set an appropriate
	// error message and return
	if($items === false) {
		return LogUtil::registerError (_GETFAILED);
	}
	// Return the items
	return $items;
}

/**
 * Delete the books that not had been actived during a given number of days
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The number of days
 * @return:	True if success and false otherwise
*/
function books_userapi_deletedNotActived($args)
{
	$days = FormUtil::getPassedValue('days', isset($args['days']) ? $args['days'] : 15, 'POST');
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		$days = 15;
	}
	$pntable = pnDBGetTables();
	$c = $pntable['books_column'];
	$time = time() - $days*24*60*60;
	$where = "WHERE $c[bookDateInit] < ".$time." AND $c[bookState]='-1'";
	if(!DBUTil::deleteWhere ('books', $where)) {
		return LogUtil::registerError (_DELETEFAILED);
	}
	return true;
}

/**
 * Activate a book
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The book identity and the action which can be accept or not accept the book
 * @return:	True if success and false otherwise
*/
function books_userapi_activateBook($args)
{
	$dom = ZLanguage::getThemeDomain('Books');
	
	$bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
	$action = FormUtil::getPassedValue('action', isset($args['action']) ? $args['action'] : null, 'POST');
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$book = pnModAPIFunc('books','user','getBook', array('bookId' => $bookId));
    if(!$book) {
        LogUtil::registerError (__("No s'ha trobat el llibre sol·licitat.",$dom));
        return false;
    }
    // only can action here the owners and the persons who are accepting books
    $userName = pnUserGetVar('uname');
    $isOwner = false;
    $canAccept = false;
    $canDelete = false;
	// check if user is the owner of the book
	if($book['schoolCode'] == $userName || ($book['bookAdminName'] == $userName && $book['bookState'] == '-1')) {
        $canAccept = true;
        $canDelete = true;
	}
    if($book['newBookAdminName'] == $userName && $book['bookAdminName'] == '' && $action == 'delete') {
        $canAccept = true;
        $userName = '';
        // do same action as activation but delete the bookAdmin name
        $action = 'activate';
    }
    if($book['newBookAdminName'] == $userName && $book['bookAdminName'] == '' && $action == 'activate') {
        $canAccept = true;
    }
	$pntable = pnDBGetTables();
	$c = $pntable['books_column'];
	//get school id
	$school = pnModAPIFunc('books', 'user', 'getSchool', array('schoolCode' => $book['schoolCode']));
	$schoolId = $school[0]['schoolId'];
	//calculate data base
	$database = floor($schoolId/50) + 1;
	global $PNConfig;
	$PNConfig['DBInfo']['book']['dbname'] = pnModGetVar('books','booksDatabase').$database;
	//connect to database
	$connect = DBConnectionStack::init('book');
	if(!$connect) {
		return false;
	}
	$prefix = $school[0]['schoolCode'].'_'.$bookId;
	DBConnectionStack::popConnection();
	if($action == 'activate') {
    	if(!$canAccept) {
    		LogUtil::registerError (__('No teniu autorització per acceptar aquest llibre.',$dom));
            return false;
    	}
		$where = "$c[bookId] = $bookId";
		$item = array('bookState' => '1',
                        'bookAdminName' => $userName,
                        'newBookAdminName' => '');
		if(!DBUTil::updateObject ($item, 'books', $where)) {
			$connect->close();
			return LogUtil::registerError (_UPDATEFAILED);
		}
		$user = pnUserGetVars(pnUserGetVar('uid'));
		$pass = $user['pn_pass'];
		//Update admin name and password in book
		$sql="UPDATE `".$prefix."_config` SET myname='" . $userName . "', mypass='" . $pass . "';";
		$rs = $connect->Execute($sql);
		if(!$rs) {
			$connect->close();
			return false;
		}
	}
	if($action == 'delete') {
	    if(!$canDelete) {
    		LogUtil::registerError (__('No pots esborrar aquest llibre.',$dom));
            return false;
    	}
		$where = "$c[bookId] = $bookId AND ($c[bookAdminName] = '" . pnUserGetVar('uname') . "' OR $c[schoolCode] = '" . $userName . "') AND $c[bookState] = -1";
		if(!DBUTil::deleteWhere ('books', $where)) {
			return LogUtil::registerError (_DELETEFAILED);
		}
        // delete the book images folder
        $path = pnModGetVar('books','serverImageFolder') . '/' . $book['schoolCode'] .'_' . $book['bookId'];
        if(file_exists($path)) {
            rmdir($path);
        }
		// delete the book tables in database
		$sql="DROP TABLE `".$prefix."_access`;";
		$rs = $connect->Execute($sql);
		if(!$rs) {
			$connect->close();
			return false;
		}
		$sql="DROP TABLE `".$prefix."_contents`;";
		$rs = $connect->Execute($sql);
		if(!$rs) {
			$connect->close();
			return false;
		}
		$sql="DROP TABLE `".$prefix."_users`;";
		$rs = $connect->Execute($sql);
		if(!$rs) {
			$connect->close();
			return false;
		}
		$sql="DROP TABLE `".$prefix."_words`;";
		$rs = $connect->Execute($sql);
		if(!$rs) {
			$connect->close();
			return false;
		}
		$sql="DROP TABLE `".$prefix."_config`;";
		$rs = $connect->Execute($sql);
		if(!$rs) {
			$connect->close();
			return false;
		}
	}
	return true;
}

/**
 * Add a user as creator for the current school
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The username of the user who is going to be allowed to create new books
 * @return:	The new database identity if success and false otherwise
*/
function books_userapi_addCreator($args)
{
	$userName = FormUtil::getPassedValue('userName', isset($args['userName']) ? $args['userName'] : null, 'POST');
	$userName = strtolower($userName);
	// Security check
	if(!pnModFunc('books', 'user', 'canCreate', array('userName' => pnUserGetVar('uname')))) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
    if(!pnModGetVar('books', 'canCreateToOthers')) {
        return false;   
    }
    // an allowed user only can be for one school. First remove other possible entries
	$pntable = pnDBGetTables();
	$c = $pntable['books_allowed_column'];
	$where = "$c[userName] = '$userName'";
	if(!DBUTil::deleteWhere ('books_allowed', $where)) {
		return LogUtil::registerError (_DELETEFAILED);
	}    
	$item = array('userName' => $userName,
					'schoolCode' => pnUserGetVar('uname'));
	if(!DBUtil::insertObject($item, 'books_allowed', 'aid')) {
		return LogUtil::registerError (_CREATEFAILED);
	}
	return $item['aid'];
}

/**
 * Delete a user as creator for the current school
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The username of the user who is not going to be allowed to create new books
 * @return:	Thue if success and false otherwise
*/
function books_userapi_deleteCreator($args)
{
	$userName = FormUtil::getPassedValue('userName', isset($args['userName']) ? $args['userName'] : null, 'POST');
	// Security check
	if(!pnModFunc('books', 'user', 'canCreate', array('userName' => pnUserGetVar('uname')))) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$pntable = pnDBGetTables();
	$c = $pntable['books_allowed_column'];
	$where = "$c[schoolCode] = '".pnUserGetVar('uname')."' AND $c[userName] = '$userName'";
	if(!DBUTil::deleteWhere ('books_allowed', $where)) {
		return LogUtil::registerError (_DELETEFAILED);
	}
	// Return the items
	return true;
}

/**
 * Get all the book creators for the current school
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @return:	An array with the creators information
*/
function books_userapi_getAllCreators()
{
	// Security check
	if(!pnModFunc('books', 'user', 'canCreate', array('userName' => pnUserGetVar('uname')))) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$pntable = pnDBGetTables();
	$c = $pntable['books_allowed_column'];
	$where = "$c[schoolCode] = '".pnUserGetVar('uname')."'";
	$orderby = "$c[userName] desc";
	$items = DBUtil::selectObjectArray('books_allowed', $where, $orderby, '-1', '-1', 'aid');
	// Check for an error with the database code, and if so set an appropriate
	// error message and return
	if($items === false) {
		return LogUtil::registerError (_GETFAILED);
	}
	// Return the items
	return $items;
}

/**
 * get the creation properties for the current user
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @return:	The creation properties
*/
function books_userapi_getCreator()
{	
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$pntable = pnDBGetTables();
	$c = $pntable['books_allowed_column'];
	$where = "$c[userName] = '" . pnUserGetVar('uname') . "'";
	$items = DBUtil::selectObjectArray('books_allowed', $where);
	// Check for an error with the database code, and if so set an appropriate
	// error message and return
	if($items === false) {
		return LogUtil::registerError (_GETFAILED);
	}
	// Return the items
	return $items;
}

/**
 * Get a school information
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The school code
 * @return:	The school information
*/
function books_userapi_getSchoolInfo($args)
{
	$schoolCode = FormUtil::getPassedValue('schoolCode', isset($args['schoolCode']) ? $args['schoolCode'] : null, 'POST');
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	// Needed argument
	if($schoolCode == null) {
		return LogUtil::registerError (_MODARGSERROR);
	}
	$items = DBUtil::selectObjectByID('books_schools_info', $schoolCode, 'schoolCode');
	// Check for an error with the database code, and if so set an appropriate
	// error message and return
	if($items === false) {
		return LogUtil::registerError (_GETFAILED);
	}
	// Return the items
	return $items;
}

/**
 * Get book main settings
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	The book identity
 * @return:	The school main settings
*/
function books_userapi_getBookMainSettings($args)
{
    // argument check
    if(!isset($args['bookId']) || !is_numeric($args['bookId'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	// security check
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerPermissionError();
	}
    // get book information
	$book = pnModAPIFunc('books','user','getBook', array('bookId' => $args['bookId']));
	if(!$book) {
        return false;
	}
    // get school information
    $school = pnModAPIFunc('books','user','getSchool', array('schoolCode' => $book['schoolCode']));
    if(!$school) {
        return false;
	}
    $isOwner = false;
	// check if user is the owner of the book
	if($book['schoolCode'] == pnUserGetVar('uname')) {
        $isOwner = true;
	}
	// calculate data base index
	$idb = floor($school[0]['schoolId']/50) + 1;
	global $PNConfig;
	$PNConfig['DBInfo']['book']['dbname'] = pnModGetVar('books','booksDatabase') . $idb;
	// Initialize the DBConnection and place it on the connection stack
	$connect = DBConnectionStack::init('book');
	if(!$connect) {
		return false;
	}
    // set prefix for the tables of the book
	$prefix = $book['schoolCode'] . '_' . $args['bookId'];
    $sql =	"SELECT opentext,theme,mypass,myname FROM " . $prefix . "_config";
	$rs = DBUtil::executeSQL($sql);
	if(!$rs) {
		DBConnectionStack::popConnection();
		return false;		
	}
    for (; !$rs->EOF; $rs->MoveNext()) {
        list ($opentext, $theme, $mypass, $myname) = $rs->fields;
        // the password is returned only for editing issues
        if(!$isOwner && $book['bookAdminName'] != pnUserGetVar('uname')) {$mypass = '';}
        $items = array('opentext' => $opentext,
                       'theme' => $theme,
                       'mypass' => $mypass,
                       'myname' => $myname);
    }
    DBConnectionStack::popConnection();
    return $items;
}

function books_userapi_createSchool($args)
{
	$items = FormUtil::getPassedValue('items', isset($args['items']) ? $args['items'] : null, 'POST');
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	if(!DBUtil::insertObject($items, 'books_schools', 'schoolId')) {
		return LogUtil::registerError (_CREATEFAILED);
	}
	return $items['schoolId'];
}

function books_userapi_editBook($args)
{	
	$bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
	$items = FormUtil::getPassedValue('items', isset($args['items']) ? $args['items'] : null, 'POST');
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	//TODO: Protect book edition
/*
	// checks if the user can create a book
	if(!$canCreate = pnModFunc('books', 'user', 'canCreate', array('userName' => pnUserGetVar('uname')))) {
		return LogUtil::registerPermissionError();
	}
    if()
    print $canCreate;
    die();
*/
	$pntable = pnDBGetTables();
	$c = $pntable['books_column'];
	$where = "$c[bookId] = $bookId";
    $items = DataUtil::formatForStore($items);
	if(!DBUTil::updateObject ($items, 'books', $where)) {
		return LogUtil::registerError (_UPDATEFAILED);
	}
	// Return the items
	return $items;
}

/**
 * creates a book
 * @author:	Francesc Bassas i Bullich & Albert Pérez Monfort
 * @param:	$args
 * @return:	
*/
function books_userapi_createBook($args)
{
	$dom = ZLanguage::getThemeDomain('Books');
	
	// argument check
    if(!isset($args['ccentre'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if(!isset($args['tllibre'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if(!isset($args['illibre'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if(!isset($args['descllibre'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if(!isset($args['ellibre'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if(!isset($args['bookCollection'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if(!isset($args['dllibre'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if(!isset($args['mailxtec'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	
	// ccentre
	$ccentre = $args['ccentre'];
	// tllibre
	$tllibre = $args['tllibre'];
	// illibre
	$illibre = $args['illibre'];
	// descllibre
	$descllibre = $args['descllibre'];
	// ellibre
	$ellibre = $args['ellibre'];
	// bookCollection
	$bookCollection = $args['bookCollection'];
	// dllibre
	$dllibre = $args['dllibre'];
	// mailxtec
	$mailxtec = $args['mailxtec'];

	// security check
	if(!$creator = pnModFunc('books', 'user', 'canCreate', array('userName' => pnUserGetVar('uname')))) {
		return LogUtil::registerPermissionError();
	}
	
	$canCreateToOthers = pnModGetVar('books', 'canCreateToOthers');
	
	// check if user can create books
	if($ccentre != pnUserGetVar('uname') && $ccentre != $creator) {
		// check if the use can create books here
		if(!$allowedUser = pnModAPIFunc('books', 'user', 'allowedUser', array('ccentre' => $ccentre)) || !$canCreateToOthers) {
			LogUtil::registerError (__('No pots crear llibres en nom del centre',$dom));
			// redirect to the main site for the user
			return pnRedirect();
		}
    }
	$descriptorsArray = explode(',',$dllibre);
	$descriptorsString = '#';
	foreach($descriptorsArray as $descriptor) {
		if($descriptor != '') {
		    $descriptor = utf8_encode(strtolower(utf8_decode(trim($descriptor))));
            $descriptor = preg_replace('/\s*/m', '', $descriptor);
			$descriptorsString .= '#' . $descriptor . '#';
		}
	}
	$state = (pnUserGetVar('uname') == $mailxtec) ? 1 : '-1';
	$item = array('schoolCode' => $ccentre,
					'bookTitle' => $tllibre,
					'bookLang' => $illibre,
					'bookAdminName' => $mailxtec,
					'bookDateInit' => time(),
					'bookState' => $state,
					'bookDescript' => $descriptorsString,
					'collectionId' => $bookCollection);

	if(!DBUtil::insertObject($item, 'books', 'bookId')) {
		return LogUtil::registerError (_CREATEFAILED);
	}
	// create the book tables
	if(!pnModAPIFunc('books','user','createBookTables', array('bookId' => $item['bookId'],
                                                                'schoolCode' => $ccentre))) {
		// delete book information because creation has failed
		if(!DBUTil::deleteObjectById ('books', $item['bookId'], 'bookId')) {
			return LogUtil::registerError (_DELETEFAILED);
		}
		return false;
	}
	// get school from database
	$rsschool = DBUtil::selectObjectByID('books_schools',$ccentre,'schoolCode');
	if($rsschool === false) {
		// delete book information because creation has failed
		if(!DBUTil::deleteObjectById ('books', $item['bookId'], 'bookId')) {
			return LogUtil::registerError (_DELETEFAILED);
		}
		return LogUtil::registerError(_GETFAILED);
	}

	// connect to book database
	$connect = pnModAPIFunc('books', 'user', 'connect', array('schoolId' => $rsschool['schoolId']));
	if(!$connect) {
		return false;
	}
	// set prefix for the tables of the book
	$prefix = $ccentre . '_' . $item['bookId'];

	// _config
	$sql =	"INSERT INTO " . $prefix . "_config (
				site_title,
				site_home,
				myname,
				mypass,
				opentext,
				abouttext,
				version,
				adminemail,
				pathtoproccess,
				Processor,
				lang,
				image_folder,
				theme
			) VALUES (
				'".mysql_real_escape_string($tllibre)."',
				'".mysql_real_escape_string($site_path)."llibre.php?fisbn=".$prefix."',
				'".mysql_real_escape_string($mailxtec)."',				
				'".mysql_real_escape_string(pnUserGetVar('pass'))."',
				'".mysql_real_escape_string($descllibre)."',
				'".mysql_real_escape_string($abouttext)."',
				'".mysql_real_escape_string($version)."',
				'".mysql_real_escape_string($mailxtec.pnModGetVar('books','mailDomServer'))."',
				'".mysql_real_escape_string($pathtoproccess)."',
				'".mysql_real_escape_string($Processor)."',
				'".mysql_real_escape_string($illibre)."',
				'".mysql_real_escape_string($image_folder_path).$prefix."',
				'".mysql_real_escape_string($ellibre)."'
			);";

	$rs = DBUtil::executeSQL($sql);

	if(!$rs) {
		DBConnectionStack::popConnection();
		return false;		
	}
	
	DBConnectionStack::popConnection();
	
	return $item['bookId'];
}

/**
 * gets a book object
 * @author:	Francesc Bassas i Bullich
 * @param:	$args	array with the bookId
 * @return:	book object on success or false on failure
*/
function books_userapi_getBookById($args)
{
	// argument check
    if(!isset($args['bookId']) || !is_numeric($args['bookId'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	
	// bookId
	$bookId = $args['bookId'];

	// security check
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerPermissionError();
	}
	
	// checks if the user can export the book
	if(!pnModAPIFunc('books','user','canExport',array('bookId' => $bookId))) {
		return LogUtil::registerPermissionError();
	}
	
	// get book from database
	$bookrecord = DBUtil::selectObjectByID('books', $bookId , 'bookId');
	
	if($bookrecord === false) {
		return LogUtil::registerError (_GETFAILED);
	}

	// get school from database
	$schoolrecord = DBUtil::selectObjectByID('books_schools',$bookrecord['schoolCode'],'schoolCode');

	if($schoolrecord === false) {
		return LogUtil::registerError (_GETFAILED);
	}
	
	// connect to book database
	$connect = pnModAPIFunc('books','user','connect',array('schoolId' => $schoolrecord['schoolId']));

	if(!$connect) return false;

	// set prefix for the tables of the book
	$prefix = $bookrecord['schoolCode'].'_'.$bookId;
	
	$sql = 	'SELECT site_title, opentext, openimage, abouttext, adminemail, showsearch, lang, theme, html_editor ' .
			'FROM ' . $prefix . '_config';

	$rsBook = DBUtil::executeSQL($sql);
	Loader::RequireOnce("modules/books/pnincludes/Book.php");
	$book = new Book(	$bookId,
						$bookrecord['schoolCode'],
						$rsBook->Fields('site_title'),
						$rsBook->Fields('opentext'),
						$rsBook->Fields('openimage'),
						$rsBook->Fields('abouttext'),
						$rsBook->Fields('adminemail'),
						$rsBook->Fields('showsearch'),
						$rsBook->Fields('lang'),
						$rsBook->Fields('theme'),
						$rsBook->Fields('html_editor'),
						$bookrecord['bookDescript']
					);

	// get chapters
	$sql =	'SELECT recno, name, openimage, opentext, permissions, notifyemail, entriespage, showname, showemail, showurl, showimage, formatpage ' .
			'FROM ' . $prefix . '_contents ' .
			'ORDER BY ordernum';

	$rsChapter = DBUtil::executeSQL($sql);

	if(!$rsChapter) {
		return false;
	}		
	else {
		while (!$rsChapter->EOF) {
			Loader::RequireOnce("modules/books/pnincludes/Chapter.php");
			$chapter = new Chapter(	$rsChapter->Fields('recno'),
									$rsChapter->Fields('name'),
									$rsChapter->Fields('opentext'),
									$rsChapter->Fields('openimage'),
									$rsChapter->Fields('permissions'),
									$rsChapter->Fields('notifyemail'),
									$rsChapter->Fields('entriespage'),
									$rsChapter->Fields('showname'),
									$rsChapter->Fields('showemail'),
									$rsChapter->Fields('showurl'),
									$rsChapter->Fields('showimage'),
									$rsChapter->Fields('formatpage')
									);

			
			// get pages
			$sql =	'SELECT email, webaddress, webname, comment, name, title, updated, approved, myimage, imagealign ' .
					'FROM ' . $prefix . '_words ' .
					'WHERE contentsid = ' . $chapter->getChapterId() . ' ' .
					'ORDER BY ordernum';
			
			$rsPages = DBUtil::executeSQL($sql);

			if(!$rsPages) {
				return false;
			}		
			else {
				while (!$rsPages->EOF) {
					Loader::RequireOnce("modules/books/pnincludes/Page.php");
					$page = new Page(	$rsPages->Fields('title'),
										$rsPages->Fields('comment'),
										$rsPages->Fields('name'),
										$rsPages->Fields('email'),
										$rsPages->Fields('webaddress'),
										$rsPages->Fields('webname'),
										$rsPages->Fields('updated'),
										$rsPages->Fields('myimage'),
										$rsPages->Fields('imagealign')
									);
									
					if($rsPages->Fields('approved') == 'Y') {
						$chapter->addPage($page);
					} else {
						$chapter->addUnnaproved($page);
					}

					$rsPages->MoveNext();
				}
				$rsPages->Close();
				$book->pushChapter($chapter);
			}
			$rsChapter->MoveNext();
		}
		$rsChapter->Close();
	}
	
	DBConnectionStack::popConnection();

	return $book;	
}

/**
 * imports a book
 * @author:	Francesc Bassas i Bullich
 * @param:	$args	array with the path to the file to import, the schoolCode, the admin username and their password
 * @return:	
*/
function books_userapi_importBook($args)
{
	// argument check
    if(!isset($args['book'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if(!isset($args['schoolCode'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if(!isset($args['username'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if(!isset($args['bookCollection'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	
	// book
	$book = $args['book'];
	// schoolCode
	$schoolCode = $args['schoolCode'];
	// username
	$username = $args['username'];
	// bookCollection
	$bookCollection = $args['bookCollection'];
	
	// security check
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerPermissionError();
	}

	// checks if the user can import a book
	if(!pnModAPIFunc('books','user','canImport',array('schoolCode' => $schoolCode))) {
		return LogUtil::registerPermissionError();
	}

	// inserts the book's row into the table books
	
	$state = (pnUserGetVar('uname') == $username) ? 1 : '-1';
	
	$item = array('schoolCode' => $book->getSchoolCode(),
					'bookTitle' => $book->getBookTitle(),
					'bookLang' => $book->getLang(),
					'bookAdminName' => $username,
					'bookAdminPassword' => $password,
					'bookDateInit' => time(),
					'bookState' => $state,
					'bookDescript' => $book->getDescriptors(),
					'collectionId' => $bookCollection,
					'bookPages' => $book->countPages());

	if(!DBUtil::insertObject($item, 'books', 'bookId')) {
		return LogUtil::registerError (_CREATEFAILED);
	}

	// create the book tables
	if(!pnModAPIFunc('books','user','createBookTables', array('bookId' => $item['bookId'], 'schoolCode' => $book->getSchoolCode()))) return false;

	// OMPLE LA BASE DE DADES

	// get school from database

	$rsSchool = DBUtil::selectObjectByID('books_schools',$book->getSchoolCode(),'schoolCode');

	if($rsSchool === false) {
		return LogUtil::registerError (_GETFAILED);
	}


	// connect to book database
	$connect = pnModAPIFunc('books','user','connect',array('schoolId' => $rsSchool['schoolId']));

	
	if(!$connect) return false;

	// set prefix for the tables of the book
	$prefix = $book->getSchoolCode() . '_' . $item['bookId'];
	
	// _config
	
	// no està definit enlloc
	$site_path;
	// paràmetres definits al config.php de myscrapbook
	$version;
	$pathtoproccess;
	$Processor;

	$sql =	"INSERT INTO " . $prefix . "_config (
				site_title,
				site_home,
				myname,
				mypass,
				opentext,
				openimage,
				abouttext,
				version,
				adminemail,
				pathtoproccess,
				Processor,
				lang,
				image_folder,
				theme
			) VALUES (
				'".mysql_real_escape_string($book->getBookTitle())."',
				'".mysql_real_escape_string($site_path)."llibre.php?fisbn=".$prefix."',
				'".mysql_real_escape_string($username)."',				
				'".mysql_real_escape_string($password)."',
				'".mysql_real_escape_string($book->getOverview())."',
				'".mysql_real_escape_string($book->getImage())."',
				'".mysql_real_escape_string($book->getAbout())."',
				'".mysql_real_escape_string($version)."',
				'".mysql_real_escape_string($username . pnModGetVar('books','mailDomServer'))."',
				'".mysql_real_escape_string($pathtoproccess)."',
				'".mysql_real_escape_string($Processor)."',
				'".mysql_real_escape_string($book->getLang())."',
				'".mysql_real_escape_string('/centres/'. $schoolCode . '_' . $item['bookId'])."',
				'".mysql_real_escape_string($book->getTheme())."'
			);";

	$rs = DBUtil::executeSQL($sql);

	if(!$rs) {
		DBConnectionStack::popConnection();
		return false;		
	}
	
	// _contents

	foreach ($book->getChapters() as $key => $chapter) {
		$sql =	"INSERT INTO " . $prefix . "_contents (
					name,
					openimage,
					ordernum,
					permissions,
					opentext,
					notifyemail,
					showname,
					showemail,
					showurl,
					showimage,
					formatpage,
					entriespage
				) VALUES (
					'" . mysql_real_escape_string($chapter->getName()) . "',
					'" . mysql_real_escape_string($chapter->getImage()) . "',
					'" . mysql_real_escape_string($key+1) . "',
					'" . mysql_real_escape_string($chapter->getPermission()) . "',
					'" . mysql_real_escape_string($chapter->getDescription()) . "',
					'" . mysql_real_escape_string($chapter->getNotifyEmail()) . "',
					'" . mysql_real_escape_string($chapter->getShowName()) . "',
					'" . mysql_real_escape_string($chapter->getShowEmail()) . "',
					'" . mysql_real_escape_string($chapter->getShowUrl()) . "',
					'" . mysql_real_escape_string($chapter->getShowImage()) . "',
					'" . mysql_real_escape_string($chapter->getFormatPage()) . "',
					'" . mysql_real_escape_string($chapter->getEntriesPage()) . "'
				)";
		
		$rs = DBUtil::executeSQL($sql);
	
		if(!$rs) {
			DBConnectionStack::popConnection();
			return false;		
		}
		
		// _words
		
		$chapterId = DBUtil::getInsertId();
		
		foreach ($chapter->getPages() as $key => $page) {
			$sql =	"INSERT INTO " . $prefix . "_words (
				email,
				webaddress,
				webname,
				comment,
				name,
				title,
				updated,
				contentsid,
				approved,
				myimage,
				ordernum,
				imagealign
			) VALUES (
				'" . mysql_real_escape_string($page->getEmail()) . "',
				'" . mysql_real_escape_string($page->getWebAddress()) . "',
				'" . mysql_real_escape_string($page->getWebName()) . "',
				'" . mysql_real_escape_string($page->getText()) . "',
				'" . mysql_real_escape_string($page->getAuthor()) . "',
				'" . mysql_real_escape_string($page->getTitle()) . "',
				'" . mysql_real_escape_string(date("YmdHis",time())) . "',
				'" . mysql_real_escape_string($chapterId) . "',
				'" . mysql_real_escape_string('Y') . "',
				'" . mysql_real_escape_string($page->getImage()) . "',
				'" . mysql_real_escape_string($key+1) . "',
				'" . mysql_real_escape_string($page->getImageAlign()) . "'
			)";
		
			$rs = DBUtil::executeSQL($sql);
		
			if(!$rs) {
				DBConnectionStack::popConnection();
				return false;		
			}
		}
		
		foreach ($chapter->getUnnaproved() as $key => $page) {
			$sql =	"INSERT INTO " . $prefix . "_words (
				email,
				webaddress,
				webname,
				comment,
				name,
				title,
				updated,
				contentsid,
				approved,
				myimage,
				ordernum,
				imagealign
			) VALUES (
				'" . mysql_real_escape_string($page->getEmail()) . "',
				'" . mysql_real_escape_string($page->getWebAddress()) . "',
				'" . mysql_real_escape_string($page->getWebName()) . "',
				'" . mysql_real_escape_string($page->getText()) . "',
				'" . mysql_real_escape_string($page->getAuthor()) . "',
				'" . mysql_real_escape_string($page->getTitle()) . "',
				'" . mysql_real_escape_string(date("YmdHis",time())) . "',
				'" . mysql_real_escape_string($chapterId) . "',
				'" . mysql_real_escape_string('N') . "',
				'" . mysql_real_escape_string($page->getImage()) . "',
				'" . mysql_real_escape_string($key+1) . "',
				'" . mysql_real_escape_string($page->getImageAlign()) . "'
			)";
		
			$rs = DBUtil::executeSQL($sql);
		
			if(!$rs) {
				DBConnectionStack::popConnection();
				return false;		
			}
		}
	}

	DBConnectionStack::popConnection();
	
	return $item['bookId'];
}

/**
 * 
 * @author:	Francesc Bassas i Bullich
 * @param:	$args
 * @return:	
*/
function books_userapi_insertBookRow($args)
{
	// argument check
    if(!isset($args['book'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if(!isset($args['schoolCode'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if(!isset($args['username'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if(!isset($args['bookCollection'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	
	// book
	$book = $args['book'];
	// schoolCode
	$schoolCode = $args['schoolCode'];
	// username
	$username = $args['username'];
	// bookCollection
	$bookCollection = $args['bookCollection'];
	
	// security check
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerPermissionError();
	}

	// checks if the user can import a book
	if(!pnModAPIFunc('books','user','canImport',array('schoolCode' => $schoolCode))) {
		return LogUtil::registerPermissionError();
	}

	// inserts the book's row into the table books
	
	$state = (pnUserGetVar('uname') == $username) ? 1 : '-1';
	
	$item = array('schoolCode' => $schoolCode,
					'bookTitle' => $book->getBookTitle(),
					'bookLang' => $book->getLang(),
					'bookAdminName' => $username,
					'bookAdminPassword' => $password,
					'bookDateInit' => time(),
					'bookState' => $state,
					'bookDescript' => $book->getDescriptors(),
					'collectionId' => $bookCollection,
					'bookPages' => $book->countPages());

	if(!DBUtil::insertObject($item, 'books', 'bookId')) {
		return LogUtil::registerError (_CREATEFAILED);
	}
			
	return $item['bookId'];
}


/**
 * 
 * @author:	Francesc Bassas i Bullich
 * @param:	$args
 * @return:	
*/
function books_userapi_insertBookTables($args)
{
	// argument check
    if(!isset($args['book'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if(!isset($args['schoolCode'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if(!isset($args['bookId'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if(!isset($args['username'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	
	// book
	$book = $args['book'];
	// schoolCode
	$schoolCode = $args['schoolCode'];
	// bookId
	$bookId = $args['bookId'];
	// username
	$username = $args['username'];
	// if all users create their own books the password is set as the same password as the web site
    if (!pnModGetVar('books', 'canCreateToOthers')) {
        $password = pnUserGetVar('pass');
    }
	// security check
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerPermissionError();
	}

	// checks if the user can import a book
	if(!pnModAPIFunc('books','user','canImport',array('schoolCode' => $schoolCode))) {
		return LogUtil::registerPermissionError();
	}

	// create the book tables
	if(!pnModAPIFunc('books','user','createBookTables', array('bookId' => $bookId, 'schoolCode' => $schoolCode))) return false;

	// OMPLE LA BASE DE DADES

	// get school from database

	$rsSchool = DBUtil::selectObjectByID('books_schools',$schoolCode,'schoolCode');

	if($rsSchool === false) {
		return LogUtil::registerError (_GETFAILED);
	}

	// connect to book database
	$connect = pnModAPIFunc('books','user','connect',array('schoolId' => $rsSchool['schoolId']));

	if(!$connect) return false;

	// set prefix for the tables of the book
	$prefix = $schoolCode . '_' . $bookId;
	
	// _config
	
	// no està definit enlloc
	$site_path;
	// paràmetres definits al config.php de myscrapbook
	$version;
	$pathtoproccess;
	$Processor;

	$sql =	"INSERT INTO " . $prefix . "_config (
				site_title,
				site_home,
				myname,
				mypass,
				opentext,
				openimage,
				abouttext,
				version,
				adminemail,
				pathtoproccess,
				Processor,
				lang,
				image_folder,
				theme
			) VALUES (
				'".mysql_real_escape_string($book->getBookTitle())."',
				'".mysql_real_escape_string($site_path)."llibre.php?fisbn=".$prefix."',
				'".mysql_real_escape_string($username)."',				
				'".mysql_real_escape_string($password)."',
				'".mysql_real_escape_string($book->getOverview())."',
				'".mysql_real_escape_string($book->getImage())."',
				'".mysql_real_escape_string($book->getAbout())."',
				'".mysql_real_escape_string($version)."',
				'".mysql_real_escape_string($username . pnModGetVar('books','mailDomServer'))."',
				'".mysql_real_escape_string($pathtoproccess)."',
				'".mysql_real_escape_string($Processor)."',
				'".mysql_real_escape_string($book->getLang())."',
				'".mysql_real_escape_string('/centres/'. $prefix)."',
				'".mysql_real_escape_string($book->getTheme())."'
			);";

	$rs = DBUtil::executeSQL($sql);

	if(!$rs) {
		DBConnectionStack::popConnection();
		return false;		
	}
	
	// _contents

	foreach ($book->getChapters() as $key => $chapter) {
		$sql =	"INSERT INTO " . $prefix . "_contents (
					name,
					openimage,
					ordernum,
					permissions,
					opentext,
					notifyemail,
					showname,
					showemail,
					showurl,
					showimage,
					formatpage,
					entriespage
				) VALUES (
					'" . mysql_real_escape_string($chapter->getName()) . "',
					'" . mysql_real_escape_string($chapter->getImage()) . "',
					'" . mysql_real_escape_string($key+1) . "',
					'" . mysql_real_escape_string($chapter->getPermission()) . "',
					'" . mysql_real_escape_string($chapter->getDescription()) . "',
					'" . mysql_real_escape_string($chapter->getNotifyEmail()) . "',
					'" . mysql_real_escape_string($chapter->getShowName()) . "',
					'" . mysql_real_escape_string($chapter->getShowEmail()) . "',
					'" . mysql_real_escape_string($chapter->getShowUrl()) . "',
					'" . mysql_real_escape_string($chapter->getShowImage()) . "',
					'" . mysql_real_escape_string($chapter->getFormatPage()) . "',
					'" . mysql_real_escape_string($chapter->getEntriesPage()) . "'
				)";
		
		$rs = DBUtil::executeSQL($sql);
	
		if(!$rs) {
			DBConnectionStack::popConnection();
			return false;		
		}
		
		// _words
		
		$chapterId = DBUtil::getInsertId();
		
		foreach ($chapter->getPages() as $key => $page) {
			$sql =	"INSERT INTO " . $prefix . "_words (
				email,
				webaddress,
				webname,
				comment,
				name,
				title,
				updated,
				contentsid,
				approved,
				myimage,
				ordernum,
				imagealign
			) VALUES (
				'" . mysql_real_escape_string($page->getEmail()) . "',
				'" . mysql_real_escape_string($page->getWebAddress()) . "',
				'" . mysql_real_escape_string($page->getWebName()) . "',
				'" . mysql_real_escape_string($page->getText()) . "',
				'" . mysql_real_escape_string($page->getAuthor()) . "',
				'" . mysql_real_escape_string($page->getTitle()) . "',
				'" . mysql_real_escape_string(date("YmdHis",time())) . "',
				'" . mysql_real_escape_string($chapterId) . "',
				'" . mysql_real_escape_string('Y') . "',
				'" . mysql_real_escape_string($page->getImage()) . "',
				'" . mysql_real_escape_string($key+1) . "',
				'" . mysql_real_escape_string($page->getImageAlign()) . "'
			)";
		
			$rs = DBUtil::executeSQL($sql);
		
			if(!$rs) {
				DBConnectionStack::popConnection();
				return false;		
			}
		}
		
		foreach ($chapter->getUnnaproved() as $key => $page) {
			$sql =	"INSERT INTO " . $prefix . "_words (
				email,
				webaddress,
				webname,
				comment,
				name,
				title,
				updated,
				contentsid,
				approved,
				myimage,
				ordernum,
				imagealign
			) VALUES (
				'" . mysql_real_escape_string($page->getEmail()) . "',
				'" . mysql_real_escape_string($page->getWebAddress()) . "',
				'" . mysql_real_escape_string($page->getWebName()) . "',
				'" . mysql_real_escape_string($page->getText()) . "',
				'" . mysql_real_escape_string($page->getAuthor()) . "',
				'" . mysql_real_escape_string($page->getTitle()) . "',
				'" . mysql_real_escape_string(date("YmdHis",time())) . "',
				'" . mysql_real_escape_string($chapterId) . "',
				'" . mysql_real_escape_string('N') . "',
				'" . mysql_real_escape_string($page->getImage()) . "',
				'" . mysql_real_escape_string($key+1) . "',
				'" . mysql_real_escape_string($page->getImageAlign()) . "'
			)";
		
			$rs = DBUtil::executeSQL($sql);
		
			if(!$rs) {
				DBConnectionStack::popConnection();
				return false;		
			}
		}
	}

	DBConnectionStack::popConnection();
	
	return true;
}

/**
 * creates the book tables
 * @author:	Francesc Bassas i Bullich
 * @param:	$args	array with the bookId
 * @return:	true on success or false on failure
*/
function books_userapi_createBookTables($args)
{
	// argument check
    if(!isset($args['bookId']) || !is_numeric($args['bookId'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	if(!isset($args['schoolCode'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	// bookId
	$bookId = $args['bookId'];
	// schoolCode
	$schoolCode = $args['schoolCode'];
	// security check
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerPermissionError();
	}
	// checks if the user can create a book
	if(!pnModFunc('books', 'user', 'canCreate', array('userName' => pnUserGetVar('uname')))) {
		return LogUtil::registerPermissionError();
	}
	/////////////////////////////////////////////////////
	// TODO: caldria crear totes les taules de forma atòmica //
	/////////////////////////////////////////////////////
	// get school from database
	$rsSchool = DBUtil::selectObjectByID('books_schools',$schoolCode,'schoolCode');
	if($rsSchool === false) {
		return LogUtil::registerError (_GETFAILED);
	}
	// connect to book database
	$connect = pnModAPIFunc('books', 'user', 'connect', array('schoolId' => $rsSchool['schoolId']));
	if(!$connect) return false;

	// set prefix for the tables of the book
	$prefix = $schoolCode . '_' . $bookId;
	
	// _access
	$sql =	"CREATE TABLE " . $prefix . "_access(
				recno		int(10) 	NOT NULL auto_increment,
				userid		int(10)		NOT NULL default '0',
				contentsid	int(10)		NOT NULL default '0',
				myaccess	char(1)		NOT NULL default 'N',
				PRIMARY KEY  (recno)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

	$rs = DBUtil::executeSQL($sql);
	
	if(!$rs) return false;

	// _contents
	$sql =	"CREATE TABLE " . $prefix . "_contents(
				recno			int(10)			NOT NULL auto_increment,
				name			varchar(150)	NOT NULL default '',
				openimage		varchar(80)		NOT NULL default '',
				ordernum		int(10)			NOT NULL default '0',
				opentext		text			NOT NULL,
				permissions		varchar(30)		NOT NULL default 'approval',
				notifyemail		varchar(80)		NOT NULL default '',
				entriespage		char(1)			NOT NULL default 'Y',
				showname		char(1)			NOT NULL default 'Y',
				showemail		char(1)			NOT NULL default '',
				showurl			char(1)			NOT NULL default '',
				showimage		char(1)			NOT NULL default 'Y',
				formatpage		int(2)			NOT NULL default '2',
				sortby			varchar(30)		NOT NULL default '',
				insertto		varchar(30)		NOT NULL default '',
				PRIMARY KEY  (recno)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

	$rs = DBUtil::executeSQL($sql);
	
	if(!$rs) return false;

	// _users
	$sql =	"CREATE TABLE " . $prefix . "_users (
				recno		int(10)			NOT NULL auto_increment,
				myusername	varchar(60)		NOT NULL default '',
				mypassword	varchar(60)		NOT NULL default '',
				email		varchar(80)		NOT NULL default '',
				name		varchar(100)	NOT NULL default '',
				loggedin	char(1)			NOT NULL default 'N',
				PRIMARY KEY  (recno)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

	$rs = DBUtil::executeSQL($sql);

	if(!$rs) return false;

	// _words
	$sql =	"CREATE TABLE " . $prefix . "_words (
				id			int(30)			NOT NULL auto_increment,
				section		varchar(150)	default NULL,
				email		varchar(150)	default NULL,
				webaddress	varchar(150)	default NULL,
				webname		varchar(150)	default NULL,
				comment		text,
				name		varchar(100)	default NULL,
				title		varchar(70)		default NULL,
				updated		timestamp		NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
				contentsid	int(10)			NOT NULL default '0',
				approved	char(1)			NOT NULL default 'N',
				myimage		varchar(60)		NOT NULL default '',
				ordernum	int(11)			NOT NULL default '0',
				imagealign	varchar(60)		NOT NULL default 'top',
				PRIMARY KEY  (id),
				KEY id (id)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

	$rs = DBUtil::executeSQL($sql);

	if(!$rs) return false;

	// _config
	$sql =	"CREATE TABLE " . $prefix . "_config (
				recno			int(10)			NOT NULL auto_increment,
				site_title		varchar(100)	NOT NULL default '',
				site_home		varchar(255)	NOT NULL default '',
				myname			varchar(12)		NOT NULL default '',			
				mypass			varchar(40)		NOT NULL default '',
				loggedin		char(1)			NOT NULL default 'N',
				opentext		text			NOT NULL,
				openimage		varchar(60)		NOT NULL default '',
				logins			int(5)			NOT NULL default '0',
				abouttext		text			NOT NULL,
				version			varchar(25)		NOT NULL default '',
				adminemail		varchar(255)	NOT NULL default '',
				pathtoproccess	varchar(255)	NOT NULL default '',
				Processor		varchar(255)	NOT NULL default '',
				showsearch		varchar(25)		NOT NULL default '',
				lang			char(2)			NOT NULL default '',
				image_folder	varchar(50)		NOT NULL default '',
				theme			varchar(12)		NOT NULL default '',
				html_editor		varchar(20)		NOT NULL default 'xinha',
				PRIMARY KEY  (recno)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

	$rs = DBUtil::executeSQL($sql);

	if(!$rs) return false;
	
	DBConnectionStack::popConnection();
	
	return true;
}

/**
 * checks if a user can export a book
 * @author:	Francesc Bassas i Bullich
 * @param:	$args	array with the bookId
 * @return:	true if the user can export the book false otherwise
*/
function books_userapi_canExport($args)
{	
	// argument check
	if($args['bookId'] == null || !is_numeric($args['bookId'])) {
		return false; // LogUtil::registerError (_MODARGSERROR);
	}

	// bookId
	$bookId = $args['bookId'];

	// checks if the user is a site admin
	if(SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		return true;
	}

	// security check
	if(!pnUserloggedin() || !SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return false; // LogUtil::registerPermissionError()
	}
	
	// gets logged user name
	$username = pnUserGetVar('uname');
	
	// gets the schoolCode and bookAdminName of the book
	$bookinfo = pnModAPIFunc('books','user','getBook', array('bookId' => $bookId));
	if(!$bookinfo) {
		return false;
	}

	// checks if the user is a school
	$school = pnModAPIFunc('books','user','getSchool', array('schoolCode' => $username));
	if($school) {
		// check if book belongs to the school
		if($school == $bookinfo['schoolCode']) {
			return true;
		}		
	}
	
	// checks if user is the admin of the book
	if($username == $bookinfo['bookAdminName']) {
		return true;
	}
	
	return false;
}

/**
 * checks if a user can import a book
 * @author:	Francesc Bassas i Bullich
 * @param:	$args	array with the schoolCode
 * @return:	true if the user can import the book false otherwise
*/
function books_userapi_canImport($args)
{	
	// argument check
	if($args['schoolCode'] == null) {
		return LogUtil::registerError (_MODARGSERROR);
	}

	// schoolCode
	$schoolCode = $args['schoolCode'];

	// checks if the user is a site admin
	if(SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		return true;
	}

	// security check
	if(!pnUserloggedin() || !SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerPermissionError();
	}

	// gets logged user name
	$username = pnUserGetVar('uname');

	// checks if the user is a school
	$school = pnModAPIFunc('books','user','getSchool', array('schoolCode' => $username));
	if($school) {
		return true;
	}

	// checks if user is allowed to create books in the school
	$pntable = pnDBGetTables();
	$booksallowedcolumn = $pntable['books_allowed_column'];
	$where = 	"WHERE $booksallowedcolumn[userName] = '" . $username . "'" . " AND " .
				"$booksallowedcolumn[schoolCode] = '" . $schoolCode . "'";
	$rsallowed = DBUtil::selectObjectArray('books_allowed', $where);

	if(count($rsallowed) == 1) {
		return true;
	}

	return false;
}

/**
 * changes URLImageFolder 
 * @author:	Francesc Bassas i Bullich
 * @param:	$args	
*/
function books_userapi_changeURLImageFolder($args)
{
	// argument check
	if($args['bookId'] == null || !is_numeric($args['bookId'])) {
		return LogUtil::registerError (_MODARGSERROR);
	}

	if($args['schoolCode'] == null) {
		return LogUtil::registerError (_MODARGSERROR);
	}

	// bookId
	$bookId = $args['bookId'];

	// schoolCode
	$schoolCode = $args['schoolCode'];
		
	// get school from database
	$rsSchool = DBUtil::selectObjectByID('books_schools',$schoolCode,'schoolCode');

	if($rsSchool === false) {
		return LogUtil::registerError (_GETFAILED);
	}
	// connect to book database
	$connect = pnModAPIFunc('books','user','connect',array('schoolId' => $rsSchool['schoolId']));

	if(!$connect) return false;

	// set prefix for the tables of the book
	$prefix = $schoolCode . '_' . $bookId;
		
	$sql =	"UPDATE $prefix"."_config SET image_folder = '/centres/$prefix'";
	
	$rsWords = DBUtil::executeSQL($sql);

	DBConnectionStack::popConnection();
}

/**
 * Update the book main properties in table config 
 * @author:	Albert Pérez Monfort
 * @param:	The book properties that are stored in the book table config
 * @return: True if success and false otherwise
*/
function books_userapi_editBookSettings($args)
{
    // argument check
    if(!isset($args['bookId']) || !is_numeric($args['bookId'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
	// security check
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_READ)) {
		return LogUtil::registerPermissionError();
	}
    // get book information
	$book = pnModAPIFunc('books','user','getBook', array('bookId' => $args['bookId']));
	if(!$book) {
        return false;
	}
    // get school information
    $school = pnModAPIFunc('books','user','getSchool', array('schoolCode' => $book['schoolCode']));
    if(!$school) {
        return false;
	}
    $isOwner = false;
	// check if user is the owner of the book
	if($book['schoolCode'] == pnUserGetVar('uname')) {
        $isOwner = true;
	}
	// check if user is the owner or the administrator of the book
	if(!$isOwner && $book['bookAdminName'] != pnUserGetVar('uname')) {
        return false;
	}
	// calculate data base index
	$idb = floor($school[0]['schoolId']/50) + 1;
	global $PNConfig;
	$PNConfig['DBInfo']['book']['dbname'] = pnModGetVar('books','booksDatabase') . $idb;
	// Initialize the DBConnection and place it on the connection stack
	$connect = DBConnectionStack::init('book');
    if(!$connect) {
        return false;
    }
    // set prefix for the tables of the book
    $prefix = $book['schoolCode'] . '_' . $args['bookId'];
    $sql =	"UPDATE " . $prefix . "_config SET opentext='" . DataUtil::formatForStore($args['opentext']) .
                                  "', site_title='" . DataUtil::formatForStore($args['site_title']) .
                                  "', lang='" . $args['lang'] .
                                  "', theme='" . $args['theme'] .
                                  "', myname='" . $args['myname'] .
                                  "', mypass='" . $args['mypass'] . "'";
    $rs = DBUtil::executeSQL($sql);
	if(!$rs) {
        DBConnectionStack::popConnection();
        return false;		
	}

    DBConnectionStack::popConnection();

    return true;
}