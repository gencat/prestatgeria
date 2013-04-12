<?php
/**
 * Update a descriptor in database
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	descriptor id and value
 * @return:	true if success and false otherwise
*/
function books_adminapi_updateDescriptor($args)
{
	$dom = ZLanguage::getThemeDomain('Books');
	
	$did = FormUtil::getPassedValue('did', isset($args['did']) ? $args['did'] : null, 'POST');
	$items = FormUtil::getPassedValue('items', isset($args['items']) ? $args['items'] : null, 'POST');
	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	// Needed argument
	if (!isset($did) || !is_numeric($did)) {
		return LogUtil::registerError (_MODARGSERROR);
	}
	//Get form information
	$item = pnModAPIFunc('books', 'user', 'getDescriptor', array('did' => $did));
	if ($item == false) {
		LogUtil::registerError (__('BOOKSDESCRIPTORNOTVALID', $dom));
	}
	$pntable = pnDBGetTables();
	$c = $pntable['books_descriptors_column'];
	$where = "$c[did] = $did";
	if (!DBUTil::updateObject ($items, 'books_descriptors', $where)) {
		return LogUtil::registerError (_UPDATEFAILED);
	}
	return true;
}

/**
 * delete a descriptor in database
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	descriptor id
 * @return:	true if success and false otherwise
*/
function books_adminapi_deleteDescriptor($args)
{
	$dom = ZLanguage::getThemeDomain('Books');
	
	$did = FormUtil::getPassedValue('did', isset($args['did']) ? $args['did'] : null, 'POST');
    $descriptor = FormUtil::getPassedValue('descriptor', isset($args['descriptor']) ? $args['descriptor'] : null, 'POST');
    $key = ($descriptor == null) ? 'did' : 'descriptor';
    $value = ($descriptor == null) ? $did : $descriptor;
	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	// Needed argument
	if (!isset($did) || !is_numeric($did)) {
		return LogUtil::registerError (_MODARGSERROR);
	}
	//Get form information
	$item = pnModAPIFunc('books', 'user', 'getDescriptor', array('did' => $did));
	if ($item == false) {
		LogUtil::registerError (__('BOOKSDESCRIPTORNOTVALID',$dom));
	}
	if (!DBUtil::deleteObjectByID('books_descriptors', $value, $key)) {
		return LogUtil::registerError (_DELETEFAILED);
	}

	return true;
}

/**
 * Get all the books table prefix names available by database.
 * @author: Francesc Bassas i Bullich
 * @return:	An array where each position corresponds to a database index and contains an array with the books table prefix for these database.
*/
function books_adminapi_getAllBooksByDatabase()
{
	// security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	
	// connect to database of the book	
	$connect = DBConnectionStack::init('default');
	
	$sql = "SELECT `zk_books`.bookId, `zk_books`.schoolCode, `zk_books_schools`.schoolId
			FROM zk_books, zk_books_schools
			WHERE  `zk_books`.schoolCode =  `zk_books_schools`.schoolCode
			ORDER BY `zk_books_schools`.schoolId ASC";	
	$rs = DBUtil::executeSQL($sql);
	
	if(!$rs) {
		DBConnectionStack::popConnection();
		return false;		
	}
	
	// $books -> array[50]
	$books = array(	array(),array(),array(),array(),array(),array(),array(),array(),array(),array(),
					array(),array(),array(),array(),array(),array(),array(),array(),array(),array(),
					array(),array(),array(),array(),array(),array(),array(),array(),array(),array(),
					array(),array(),array(),array(),array(),array(),array(),array(),array(),array(),
					array(),array(),array(),array(),array(),array(),array(),array(),array(),array(),);
					
    for (; !$rs->EOF; $rs->MoveNext()) {
        list ($bookId, $schoolCode, $schoolId) = $rs->fields;
        $book_array = array('schoolCode' => $schoolCode, 'bookId' => $bookId, 'schoolId' => $schoolId);
        array_push($books[floor($schoolId/50) + 1], $book_array);
    }
	
	DBConnectionStack::popConnection();
	
	return $books;
}

/**
 * Update a book, if it is necessary, changing paths in _config.opentext _contents.opentext and _words.comment fields of book.
 * @author:	Francesc Bassas i Bullich
 * @param:	string 'oldpath' the path to change
 * @param:	string 'newpath' the new path 
 * @param:	string 'book_id' the id of the book to update
 * @param:	string 'school_code' the school_code of the school of the book to update
 * @param:	string 'school_id' the school_id of the school of the book to update
 * @return:	bool true if success and false otherwise
 * @todo: Use MySQL replace statement instead of str_replace PHP function
*/
function books_adminapi_changeBookPath($args)
{	
	// security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	
	// arguments check
	$oldpath = FormUtil::getPassedValue('oldpath', isset($args['oldpath']) ? $args['oldpath'] : null, 'POST');
	$newpath = FormUtil::getPassedValue('newpath', isset($args['newpath']) ? $args['newpath'] : null, 'POST');
	$book_id = FormUtil::getPassedValue('book_id', isset($args['book_id']) ? $args['book_id'] : null, 'POST');
	$book_schoolcode = FormUtil::getPassedValue('book_schoolcode', isset($args['book_schoolcode']) ? $args['book_schoolcode'] : null, 'POST');
	$book_schoolId = FormUtil::getPassedValue('book_schoolId', isset($args['book_schoolId']) ? $args['book_schoolId'] : null, 'POST');
	
	if (!$oldpath) { return LogUtil::registerError (_MODARGSERROR); }
	if (!$newpath) { return LogUtil::registerError (_MODARGSERROR); }
	if (!$book_id) { return LogUtil::registerError (_MODARGSERROR); }
	if (!$book_schoolcode) { return LogUtil::registerError (_MODARGSERROR); }
	if (!$book_schoolId) { return LogUtil::registerError (_MODARGSERROR); }
	
	// connect to database of the book
	$connect = pnModAPIFunc('books', 'user', 'connect', array('schoolId' => $book_schoolId));
	
	if( !$connect ) { return false; }
	
	// _config table
	$sql = 	'SELECT opentext ' .
			'FROM ' . $book_schoolcode . '_' . $book_id . '_config';
	$rs = DBUtil::executeSQL($sql);
	list ($opentext)  = $rs->fields;
	
	// replace paths
	$opentext = str_replace($oldpath, $newpath, $opentext, $count);
	
	if ($count != 0) {
		// update _config.opentext
		$sql = 'UPDATE ' . $book_schoolcode . '_' . $book_id . '_config ' .
			   'SET opentext = "' . mysql_real_escape_string($opentext) . '" ' .
			   'WHERE ' . $book_schoolcode . '_' . $book_id . '_config.recno=1 LIMIT 1';
		$rs = DBUtil::executeSQL($sql);
	}
		
	// _contents table
	$sql = 	'SELECT recno, opentext ' .
			'FROM ' . $book_schoolcode . '_' . $book_id . '_contents';	
	$rs = DBUtil::executeSQL($sql);
	
    for (; !$rs->EOF; $rs->MoveNext()) {
		list ($recno,$opentext)  = $rs->fields;
		
		// replace paths
    	$opentext = str_replace($oldpath, $newpath, $opentext, $count);
	
		if ($count != 0) {
			// update _contents.opentext
			$sql = 'UPDATE ' . $book_schoolcode . '_' . $book_id . '_contents ' .
				   'SET opentext = "' . mysql_real_escape_string($opentext) . '" ' .
				   'WHERE ' . $book_schoolcode . '_' . $book_id . '_contents.recno=' . $recno . ' LIMIT 1';
			DBUtil::executeSQL($sql);
		}
    }
	
	// _words table
	$sql = 	'SELECT id, comment ' .
			'FROM ' . $book_schoolcode . '_' . $book_id . '_words';	
	$rs = DBUtil::executeSQL($sql);
	
    for (; !$rs->EOF; $rs->MoveNext()) {
		list ($id,$comment)  = $rs->fields;
		
		// replace paths
    	$comment = str_replace($oldpath, $newpath, $comment, $count);
	
		if ($count != 0) {
			// update _words.comment
			$sql = 'UPDATE ' . $book_schoolcode . '_' . $book_id . '_words ' .
				   'SET comment = "' . mysql_real_escape_string($comment) . '" ' .
				   'WHERE ' . $book_schoolcode . '_' . $book_id . '_words.id=' . $id . ' LIMIT 1';
			DBUtil::executeSQL($sql);
		}
    }

    DBConnectionStack::popConnection();
    
    return true;
}

/**
 * Get a school information
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @return:	The schools information
*/
function books_adminapi_getAllSchoolInfo($args)
{
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}

	if ($args['schoolsInfo'] == 1){
		$table = 'books_schools_info';
		$key = 'schoolInfo';
	} else {
		$table = 'books_schools';
		$key = 'schoolId';
	}

	$pntable = pnDBGetTables();
	$c = $pntable[$table . '_column'];
	$where = '';
	$orderby = "$c[schoolCode]";
	$items = DBUtil::selectObjectArray($table, $where, $orderby, '-1', '-1', $key);
	// Check for an error with the database code, and if so set an appropriate
	// error message and return
	if($items === false) {
		return LogUtil::registerError (_GETFAILED);
	}
	// Return the items
	return $items;

}

function books_adminapi_createSchool($args)
{
	if(!SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}

	$time = time();

	$item = array('schoolCode' => $args['schoolCode'],
			'schoolType' => $args['schoolType'],
			'schoolName' => $args['schoolName'],
			'schoolCity' => $args['schoolCity'],
			'schoolZipCode' => $args['schoolZipCode'],
			'schoolRegion' => $args['schoolRegion'],
			'schoolDateIns' => $time,
			'schoolState' => 1,
			);

	if(!DBUtil::insertObject($item, 'books_schools', 'schoolId')) {
		return LogUtil::registerError (_CREATEFAILED);
	}

	// Return the id of the newly created item to the calling process
	return $item['schoolId'];
}
