<?php

class Books_Api_User extends Zikula_AbstractApi {

    /**
     * connects to school's database
     * @author:	Francesc Bassas i Bullich
     * @param:	args	Array with the schoolId
     * @return:	database connection
     */
    public function connect($args) {
        $schoolId = FormUtil::getPassedValue('schoolId', isset($args['schoolId']) ? $args['schoolId'] : null, 'POST');
        $database = FormUtil::getPassedValue('database', isset($args['database']) ? $args['database'] : null, 'POST');

        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }

        global $ZConfig;

        if ($database == null) {
            // calculate data base index
            $idb = floor($schoolId / 50) + 1;
            $database = ModUtil::getVar('Books', 'booksDatabase') . $idb;
        }

        $connect = mysql_connect($ZConfig['DBInfo']['databases']['book']['host'], $ZConfig['DBInfo']['databases']['book']['user'], $ZConfig['DBInfo']['databases']['book']['password']);
        if (!mysql_select_db($database, $connect)) {
            return LogUtil::registerError($this->__('La connexió amb la base de dades de llibres ha fallat') . ': ' . $database);
        }

        // @aginard: Force utf8 connections to DB
        mysql_query("SET NAMES 'utf8'");
        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET COLLATION_CONNECTION = 'utf8_general_ci'");


        return $connect;
    }

    /**
     * get all the books available
     * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:	args	Array with the init page and the number of items per page
     * @return:	An array with the groups information
     */
    public function getAllBooks($args) {
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
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $myJoin = array();
        $myJoin[] = array('join_table' => 'books',
            'join_field' => array(),
            'object_field_name' => array(),
            'compare_field_table' => 'bookId',
            'compare_field_join' => 'bookId');
        if ($notJoin == null) {
            $myJoin[] = array('join_table' => 'books_schools',
                'join_field' => array('schoolName', 'schoolType', 'schoolCity'),
                'object_field_name' => array('schoolName', 'schoolType', 'schoolCity'),
                'compare_field_table' => 'schoolCode',
                'compare_field_join' => 'schoolCode');
        }
        switch ($order) {
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
        $tables = DBUtil::getTables();
        $ocolumn = $tables['books_column'];
        $lcolumn = $tables['books_schools_column'];
        $filterValue = str_replace("'", "''", $filterValue);
        $filterValue = str_replace("--apos--", "''", $filterValue);
        switch ($filter) {
            case 'userBooks':
                $where = " AND a.$ocolumn[bookAdminName] ='$filterValue'";
                break;
            case 'prefered':
                $where = " AND (";
                foreach ($filterValue as $value) {
                    $where .= "a.$ocolumn[bookId] ='$value[bookId]' OR ";
                }
                $where = substr($where, 0, -3);
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
                $where = " AND b.$lcolumn[schoolCity] LIKE '%$filterValue%'";
                break;
            case 'lang':
                $where = " AND a.$ocolumn[bookLang] = '$filterValue'";
                break;
            case 'title':
                if ($filterValue != '') {
                    $where = " AND (";
                    $values = explode(' ', $filterValue);
                    foreach ($values as $value) {
                        if ($value != '') {
                            $where .= " (a.$ocolumn[bookTitle] LIKE '%$value%') OR ";
                        }
                    }
                    $where = substr($where, 0, -3);
                    $where .= ')';
                } else {
                    $where = '';
                }
                break;
            default:
                $where = '';
        }
        if ($bookState != 'all') {
            if ($acceptEdit == null) {
                $where = "a.$ocolumn[bookState] = $bookState" . $where;
            } else {
                // this case is possible only during user's acceptation process
                $where = "(a.$ocolumn[bookState] = '-1' AND a.$ocolumn[bookAdminName]='" . UserUtil::getVar('uname') . "') OR (a.$ocolumn[bookAdminName]='' AND a.$ocolumn[newBookAdminName]='" . UserUtil::getVar('uname') . "')";
            }
        } else {
            $where = substr($where, 4);
        }

        $orderby = "a.$ocolumn[$orderbyField] desc";
        if ($onlyNumber == null) {
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
    public function getBook($args) {
        $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $myJoin = array();
        $myJoin[] = array('join_table' => 'books',
            'join_field' => array(),
            'object_field_name' => array(),
            'compare_field_table' => 'bookId',
            'compare_field_join' => 'bookId');
        $myJoin[] = array('join_table' => 'books_schools',
            'join_field' => array('schoolName', 'schoolType', 'schoolCity'),
            'object_field_name' => array('schoolName', 'schoolType', 'schoolCity'),
            'compare_field_table' => 'schoolCode',
            'compare_field_join' => 'schoolCode');
        $where = '';
        $tables = DBUtil::getTables();
        $ocolumn = $tables['books_column'];
        $lcolumn = $tables['books_schools_column'];
        $where = "a.$ocolumn[bookId] = '" . $bookId . "'";
        $item = DBUtil::selectExpandedObject('books', $myJoin, $where);
        if ($item === false) {
            return LogUtil::registerError(_GETFAILED);
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
    public function getAllDescriptors($args) {
        $number = FormUtil::getPassedValue('number', isset($args['number']) ? $args['number'] : null, 'POST');
        $order = FormUtil::getPassedValue('order', isset($args['order']) ? $args['order'] : null, 'POST');
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $table = DBUtil::getTables();
        $c = $table['books_descriptors_column'];
        $where = '';
        $orderby = ($order == null) ? "$c[number] desc" : "$c[$order]";
        $items = DBUtil::selectObjectArray('books_descriptors', $where, $orderby, '-1', $number, 'did');
        // Check for an error with the database code, and if so set an appropriate
        // error message and return
        if ($items === false) {
            return LogUtil::registerError(_GETFAILED);
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
    public function getDescriptor($args) {
        $did = FormUtil::getPassedValue('did', isset($args['did']) ? $args['did'] : null, 'POST');
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        // Needed argument
        if ($did == null || !is_numeric($did)) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        $item = DBUtil::selectObjectByID('books_descriptors', $did, 'did');
        // Check for an error with the database code, and if so set an appropriate
        // error message and return
        if ($item === false) {
            return LogUtil::registerError(_GETFAILED);
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
    public function getAllCollection($args) {
        $state = FormUtil::getPassedValue('state', isset($args['state']) ? $args['state'] : 0, 'POST');
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $table = DBUtil::getTables();
        $c = $table['books_bookcollections_column'];
        $where = ($state) ? "$c[collectionState] = 1" : "";
        $orderby = "";
        $items = DBUtil::selectObjectArray('books_bookcollections', $where, $orderby, '-1', '-1', 'collectionId');
        // Check for an error with the database code, and if so set an appropriate
        // error message and return
        if ($items === false) {
            return LogUtil::registerError(_GETFAILED);
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
    public function getCollection($args) {
        $collectionId = FormUtil::getPassedValue('collectionId', isset($args['collectionId']) ? $args['collectionId'] : null, 'POST');
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        // Needed argument
        if ($collectionId == null || !is_numeric($collectionId)) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        $items = DBUtil::selectObjectByID('books_bookcollections', $collectionId, 'collectionId');
        // Check for an error with the database code, and if so set an appropriate
        // error message and return
        if ($items === false) {
            return LogUtil::registerError(_GETFAILED);
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
    public function getBooksInCollection($args) {
        $collectionId = FormUtil::getPassedValue('collectionId', isset($args['collectionId']) ? $args['collectionId'] : null, 'POST');
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        // Needed argument
        if ($collectionId == null || !is_numeric($collectionId)) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        $table = DBUtil::getTables();
        $c = $table['books_column'];
        $where = "$c[collectionId] = $collectionId";
        $orderby = "";
        $items = DBUtil::selectObjectArray('books', $where, $orderby, '-1', '-1', 'bookId');
        // error message and return
        if ($items === false) {
            return LogUtil::registerError(_GETFAILED);
        }
        // Return the items
        return count($items);
    }

    /**
     * get the prefered books for a user
     * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
     * @return:	An array with the prefered books identities
     */
    public function getPrefered($args) {
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $table = DBUtil::getTables();
        $c = $table['books_userbooks_column'];
        $where = "$c[userName]='" . UserUtil::getVar('uname') . "'";
        $items = DBUtil::selectObjectArray('books_userbooks', $where, '', '-1', '-1', 'ubid');
        // Check for an error with the database code, and if so set an appropriate
        // error message and return
        if ($items === false) {
            return LogUtil::registerError(_GETFAILED);
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
    public function addPrefer($args) {
        $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ) || !UserUtil::isLoggedIn()) {
            throw new Zikula_Exception_Forbidden();
        }
        $item = array('bookId' => $bookId,
            'userName' => UserUtil::getVar('uname'));
        if (!DBUtil::insertObject($item, 'books_userbooks', 'ubid')) {
            return LogUtil::registerError(_CREATEFAILED);
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
    public function delPrefer($args) {
        $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ) || !UserUtil::isLoggedIn()) {
            throw new Zikula_Exception_Forbidden();
        }
        $table = DBUtil::getTables();
        $c = $table['books_userbooks_column'];
        $where = "WHERE $c[bookId]=$bookId AND $c[userName]='" . UserUtil::getVar('uname') . "'";
        if (!DBUTil::deleteWhere('books_userbooks', $where)) {
            return LogUtil::registerError(_DELETEFAILED);
        }
        return true;
    }

    /**
     * Save the current position of a user in the cataloge
     * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:	The items needed for storage the position in the cataloge
     * @return:	True if success and false otherwise
     */
    public function saveUserHistory($args) {
        $item = FormUtil::getPassedValue('item', isset($args['item']) ? $args['item'] : null, 'POST');
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $table = DBUtil::getTables();
        $c = $table['books_nav_column'];
        $where = "$c[sessid] ='" . $GLOBALS['_ZSession']['obj']['sessid'] . "'";
        //Try to update if not create
        if (!DBUtil::selectObjectArray('books_nav', $where, '', '-1', '-1', 'unid')) {
            if (!DBUtil::insertObject($item, 'books_nav', 'unid')) {
                return LogUtil::registerError(_CREATEFAILED);
            }
            return $item['unid'];
        } else {
            if (!DBUTil::updateObject($item, 'books_nav', $where)) {
                return LogUtil::registerError(_UPDATEFAILED);
            }
            return true;
        }
    }

    /**
     * Get the saved position of a user in the cataloge
     * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
     * @return:	The parameters that allow system to recover the saved position in the cataloge
     */
    public function getUserHistory() {
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $table = DBUtil::getTables();
        $c = $table['books_nav_column'];
        $where = "$c[sessid] ='" . $GLOBALS['_ZSession']['obj']['sessid'] . "'";
        //Try to update if not create
        $items = DBUtil::selectObjectArray('books_nav', $where, '', '-1', '-1', 'sessid');
        if (!items) {
            return LogUtil::registerError(_CREATEFAILED);
        }
        return $items;
    }

    /**
     * Save the current position of a user in the cataloge
     * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:	The items needed for storage the position in the cataloge
     * @return:	True if success and false otherwise
     */
    public function createComment($args) {
        $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
        $commentText = FormUtil::getPassedValue('commentText', isset($args['commentText']) ? $args['commentText'] : null, 'POST');
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_COMMENT)) {
            throw new Zikula_Exception_Forbidden();
        }
        $item = array('text' => $commentText,
            'bookId' => $bookId,
            'userName' => UserUtil::getVar('uname'),
            'date' => time());
        if (!DBUtil::insertObject($item, 'books_comment', 'cid')) {
            return LogUtil::registerError(_CREATEFAILED);
        }
        return $item['cid'];
    }

    /**
     * Get all comments for a given book
     * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:	The book identity
     * @return:	An array with the comments for a book
     */
    public function getAllComments($args) {
        $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $table = DBUtil::getTables();
        $c = $table['books_comment_column'];
        $where = "$c[bookId] = $bookId";
        $orderby = "$c[date] desc";
        $items = DBUtil::selectObjectArray('books_comment', $where, $orderby, '-1', '-1', 'cid');
        // Check for an error with the database code, and if so set an appropriate
        // error message and return
        if ($items === false) {
            return LogUtil::registerError(_GETFAILED);
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
    public function filterValues($args) {
        $filter = FormUtil::getPassedValue('filter', isset($args['filter']) ? $args['filter'] : null, 'POST');
        $value = FormUtil::getPassedValue('value', isset($args['value']) ? $args['value'] : null, 'POST');
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $table = DBUtil::getTables();
        $value = str_replace("'", "''", $value);
        switch ($filter) {
            case 'name':
                $c = $table['books_schools_column'];
                $where = "$c[schoolName] LIKE '%$value%'";
                $orderby = "$c[schoolName] desc";
                $items = DBUtil::selectObjectArray('books_schools', $where, $orderby, '-1', '-1', 'schoolId');
                break;
            case 'admin':
                $c = $table['books_column'];
                $where .= "$c[bookAdminName] LIKE '$value%'";
                $orderby = "$c[bookAdminName] desc";
                $items = DBUtil::selectObjectArray('books', $where, $orderby, '-1', '-1', 'bookId');
                break;
            case 'city':
                $c = $table['books_schools_column'];
                $where = "$c[schoolCity] LIKE '%$value%'";
                $orderby = "$c[schoolCity] desc";
                $items = DBUtil::selectObjectArray('books_schools', $where, $orderby, '-1', '-1', 'schoolId');
                break;
            case 'descriptor':
                $c = $table['books_column'];
                $where .= "$c[bookDescript] LIKE '%#$value%'";
                $orderby = "$c[bookDescript] desc";
                $items = DBUtil::selectObjectArray('books', $where, $orderby, '-1', '-1', 'bookDescript');
                break;
        }
        // Check for an error with the database code, and if so set an appropriate
        // error message and return
        if ($items === false) {
            return LogUtil::registerError(_GETFAILED);
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
    public function getSchool($args) {
        $schoolId = FormUtil::getPassedValue('schoolId', isset($args['schoolId']) ? $args['schoolId'] : null, 'POST');
        $schoolCode = FormUtil::getPassedValue('schoolCode', isset($args['schoolCode']) ? $args['schoolCode'] : null, 'POST');
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        // Needed argument
        if (($schoolId == null || !is_numeric($schoolId)) && $schoolCode == null) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if ($schoolId != null) {
            $items = DBUtil::selectObjectByID('books_schools', $schoolId, 'schoolId');
        } else {
            $table = DBUtil::getTables();
            $c = $table['books_schools_column'];
            $where = "$c[schoolCode] = '$schoolCode'";
            $items = DBUtil::selectObjectArray('books_schools', $where);
        }
        // Check for an error with the database code, and if so set an appropriate
        // error message and return
        if ($items === false) {
            return LogUtil::registerError(_GETFAILED);
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
    public function deletedNotActived($args) {
        $days = FormUtil::getPassedValue('days', isset($args['days']) ? $args['days'] : 15, 'POST');
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            $days = 15;
        }
        $table = DBUtil::getTables();
        $c = $table['books_column'];
        $time = time() - $days * 24 * 60 * 60;
        $where = "WHERE $c[bookDateInit] < " . $time . " AND $c[bookState]='-1'";
        if (!DBUTil::deleteWhere('books', $where)) {
            return LogUtil::registerError(_DELETEFAILED);
        }
        return true;
    }

    /**
     * Activate a book
     * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:	The book identity and the action which can be accept or not accept the book
     * @return:	True if success and false otherwise
     */
    public function activateBook($args) {


        $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
        $action = FormUtil::getPassedValue('action', isset($args['action']) ? $args['action'] : null, 'POST');
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $book = ModUtil::apiFunc('books', 'user', 'getBook', array('bookId' => $bookId));
        if (!$book) {
            LogUtil::registerError($this->__("No s'ha trobat el llibre sol·licitat."));
            return false;
        }
        // only can action here the owners and the persons who are accepting books
        $userName = UserUtil::getVar('uname');
        $isOwner = false;
        $canAccept = false;
        $canDelete = false;
        // check if user is the owner of the book
        if ($book['schoolCode'] == $userName || ($book['bookAdminName'] == $userName && $book['bookState'] == '-1')) {
            $canAccept = true;
            $canDelete = true;
        }
        if ($book['newBookAdminName'] == $userName && $book['bookAdminName'] == '' && $action == 'delete') {
            $canAccept = true;
            $userName = '';
            // do same action as activation but delete the bookAdmin name
            $action = 'activate';
        }
        if ($book['newBookAdminName'] == $userName && $book['bookAdminName'] == '' && $action == 'activate') {
            $canAccept = true;
        }
        $table = DBUtil::getTables();
        $c = $table['books_column'];
        //get school id
        $school = ModUtil::apiFunc('books', 'user', 'getSchool', array('schoolCode' => $book['schoolCode']));
        $schoolId = $school[0]['schoolId'];
        //calculate data base
        $database = floor($schoolId / 50) + 1;
        //connect to database
        $connect = ModUtil::apiFunc($this->name, 'user', 'connect', array('database' => ModUtil::getVar('Books', 'booksDatabase') . $database));
        if (!$connect)
            return false;

        $prefix = $school[0]['schoolCode'] . '_' . $bookId;
        if ($action == 'activate') {
            if (!$canAccept) {
                LogUtil::registerError($this->__('No teniu autorització per acceptar aquest llibre.'));
                return false;
            }
            $where = "$c[bookId] = $bookId";
            $item = array('bookState' => '1',
                'bookAdminName' => $userName,
                'newBookAdminName' => '');
            if (!DBUTil::updateObject($item, 'books', $where)) {
                mysql_close($connect);
                return LogUtil::registerError(_UPDATEFAILED);
            }
            $fullpass = UserUtil::getVar('pass');
            $fullpass_array = explode('$', $fullpass);
            $pass = $fullpass_array[2];
            //Update admin name and password in book
            $sql = "UPDATE `" . $prefix . "_config` SET myname='" . $userName . "', mypass='" . $pass . "';";
            $rs = mysql_query($sql, $connect);
            if (!$rs) {
                mysql_close($connect);
                return false;
            }
        }
        if ($action == 'delete') {
            if (!$canDelete) {
                LogUtil::registerError($this->__('No pots esborrar aquest llibre.'));
                return false;
            }
            $where = "$c[bookId] = $bookId AND ($c[bookAdminName] = '" . UserUtil::getVar('uname') . "' OR $c[schoolCode] = '" . $userName . "') AND $c[bookState] = -1";
            if (!DBUTil::deleteWhere('books', $where)) {
                return LogUtil::registerError(_DELETEFAILED);
            }
            // delete the book images folder
            $path = ModUtil::getVar('Books', 'serverImageFolder') . '/' . $book['schoolCode'] . '_' . $book['bookId'];
            if (file_exists($path)) {
                rmdir($path);
            }
            // delete the book tables in database
            $sql = "DROP TABLE `" . $prefix . "_access`;";
            $rs = mysql_query($sql, $connect);
            if (!$rs) {
                mysql_close($connect);
                return false;
            }
            $sql = "DROP TABLE `" . $prefix . "_contents`;";
            $rs = mysql_query($sql, $connect);
            if (!$rs) {
                mysql_close($connect);
                return false;
            }
            $sql = "DROP TABLE `" . $prefix . "_users`;";
            $rs = mysql_query($sql, $connect);
            if (!$rs) {
                mysql_close($connect);
                return false;
            }
            $sql = "DROP TABLE `" . $prefix . "_words`;";
            $rs = mysql_query($sql, $connect);
            if (!$rs) {
                mysql_close($connect);
                return false;
            }
            $sql = "DROP TABLE `" . $prefix . "_config`;";
            $rs = mysql_query($sql, $connect);
            if (!$rs) {
                mysql_close($connect);
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
    public function addCreator($args) {
        $userName = FormUtil::getPassedValue('userName', isset($args['userName']) ? $args['userName'] : null, 'POST');
        $userName = strtolower($userName);
        // Security check
        if (!ModUtil::func('Books', 'user', 'canCreate', array('userName' => UserUtil::getVar('uname')))) {
            throw new Zikula_Exception_Forbidden();
        }
        if (!ModUtil::getVar('Books', 'canCreateToOthers')) {
            return false;
        }
        // an allowed user only can be for one school. First remove other possible entries
        $table = DBUtil::getTables();
        $c = $table['books_allowed_column'];
        $where = "$c[userName] = '$userName'";
        if (!DBUTil::deleteWhere('books_allowed', $where)) {
            return LogUtil::registerError(_DELETEFAILED);
        }
        $item = array('userName' => $userName,
            'schoolCode' => UserUtil::getVar('uname'));
        if (!DBUtil::insertObject($item, 'books_allowed', 'aid')) {
            return LogUtil::registerError(_CREATEFAILED);
        }
        return $item['aid'];
    }

    /**
     * Delete a user as creator for the current school
     * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:	The username of the user who is not going to be allowed to create new books
     * @return:	Thue if success and false otherwise
     */
    public function deleteCreator($args) {
        $userName = FormUtil::getPassedValue('userName', isset($args['userName']) ? $args['userName'] : null, 'POST');
        // Security check
        if (!ModUtil::func('Books', 'user', 'canCreate', array('userName' => UserUtil::getVar('uname')))) {
            throw new Zikula_Exception_Forbidden();
        }
        $table = DBUtil::getTables();
        $c = $table['books_allowed_column'];
        $where = "$c[schoolCode] = '" . UserUtil::getVar('uname') . "' AND $c[userName] = '$userName'";
        if (!DBUTil::deleteWhere('books_allowed', $where)) {
            return LogUtil::registerError(_DELETEFAILED);
        }
        // Return the items
        return true;
    }

    /**
     * Get all the book creators for the current school
     * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
     * @return:	An array with the creators information
     */
    public function getAllCreators() {
        // Security check
        if (!ModUtil::func('Books', 'user', 'canCreate', array('userName' => UserUtil::getVar('uname')))) {
            throw new Zikula_Exception_Forbidden();
        }
        $table = DBUtil::getTables();
        $c = $table['books_allowed_column'];
        $where = "$c[schoolCode] = '" . UserUtil::getVar('uname') . "'";
        $orderby = "$c[userName] desc";
        $items = DBUtil::selectObjectArray('books_allowed', $where, $orderby, '-1', '-1', 'aid');
        // Check for an error with the database code, and if so set an appropriate
        // error message and return
        if ($items === false) {
            return LogUtil::registerError(_GETFAILED);
        }
        // Return the items
        return $items;
    }

    /**
     * get the creation properties for the current user
     * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
     * @return:	The creation properties
     */
    public function getCreator() {
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $table = DBUtil::getTables();
        $c = $table['books_allowed_column'];
        $where = "$c[userName] = '" . UserUtil::getVar('uname') . "'";
        $items = DBUtil::selectObjectArray('books_allowed', $where);
        // Check for an error with the database code, and if so set an appropriate
        // error message and return
        if ($items === false) {
            return LogUtil::registerError(_GETFAILED);
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
    public function getSchoolInfo($args) {
        $schoolCode = FormUtil::getPassedValue('schoolCode', isset($args['schoolCode']) ? $args['schoolCode'] : null, 'POST');
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        // Needed argument
        if ($schoolCode == null) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        $items = DBUtil::selectObjectByID('books_schools_info', $schoolCode, 'schoolCode');
        // Check for an error with the database code, and if so set an appropriate
        // error message and return
        if ($items === false) {
            return LogUtil::registerError(_GETFAILED);
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
    public function getBookMainSettings($args) {
        // argument check
        if (!isset($args['bookId']) || !is_numeric($args['bookId'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        // security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }
        // get book information
        $book = ModUtil::apiFunc('Books', 'user', 'getBook', array('bookId' => $args['bookId']));
        if (!$book) {
            return false;
        }
        // get school information
        $school = ModUtil::apiFunc('Books', 'user', 'getSchool', array('schoolCode' => $book['schoolCode']));
        if (!$school) {
            return false;
        }
        $isOwner = false;
        // check if user is the owner of the book
        if ($book['schoolCode'] == UserUtil::getVar('uname')) {
            $isOwner = true;
        }
        // calculate data base index
        $idb = floor($school[0]['schoolId'] / 50) + 1;

        // Initialize the DBConnection and place it on the connection stack
        $connect = ModUtil::apiFunc($this->name, 'user', 'connect', array('database' => ModUtil::getVar('Books', 'booksDatabase') . $idb));
        if (!$connect)
            return false;
        // set prefix for the tables of the book
        $prefix = $book['schoolCode'] . '_' . $args['bookId'];
        $sql = "SELECT opentext,theme,mypass,myname FROM " . $prefix . "_config";
        $rs = mysql_query($sql, $connect);
        if (!$rs) {
            mysql_close($connect);
            return false;
        }

        while ($row = mysql_fetch_assoc($rs)) {
            // the password is returned only for editing issues
            $mypass = (!$isOwner && $book['bookAdminName'] != UserUtil::getVar('uname')) ? '' : $row['mypass'];
            $items = array('opentext' => $row['opentext'],
                'theme' => $row['theme'],
                'mypass' => $mypass,
                'myname' => $row['myname']);
        }
        mysql_close($connect);
        return $items;
    }

    public function createSchool($args) {
        $items = FormUtil::getPassedValue('items', isset($args['items']) ? $args['items'] : null, 'POST');
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        if (!DBUtil::insertObject($items, 'books_schools', 'schoolId')) {
            return LogUtil::registerError(_CREATEFAILED);
        }
        return $items['schoolId'];
    }

    public function editBook($args) {
        $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
        $items = FormUtil::getPassedValue('items', isset($args['items']) ? $args['items'] : null, 'POST');
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        //TODO: Protect book edition
        /*
          // checks if the user can create a book
          if(!$canCreate = ModUtil::func('Books', 'user', 'canCreate', array('userName' => UserUtil::getVar('uname')))) {
          return LogUtil::registerPermissionError();
          }
          if()
          print $canCreate;
          die();
         */
        $table = DBUtil::getTables();
        $c = $table['books_column'];
        $where = "$c[bookId] = $bookId";
        if (!DBUTil::updateObject($items, 'books', $where)) {
            return LogUtil::registerError(_UPDATEFAILED);
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
    public function createBook($args) {
        // argument check
        if (!isset($args['ccentre'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!isset($args['tllibre'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!isset($args['illibre'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!isset($args['descllibre'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!isset($args['ellibre'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!isset($args['bookCollection'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!isset($args['dllibre'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!isset($args['mailxtec'])) {
            return LogUtil::registerError(_MODARGSERROR);
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
        if (!$creator = ModUtil::func('Books', 'user', 'canCreate', array('userName' => UserUtil::getVar('uname')))) {
            return LogUtil::registerPermissionError();
        }

        $canCreateToOthers = ModUtil::getVar('Books', 'canCreateToOthers');

        // check if user can create books
        if ($ccentre != UserUtil::getVar('uname') && $ccentre != $creator) {
            // check if the use can create books here
            if (!$allowedUser = ModUtil::apiFunc('Books', 'user', 'allowedUser', array('ccentre' => $ccentre)) || !$canCreateToOthers) {
                LogUtil::registerError($this->__('No pots crear llibres en nom del centre'));
                // redirect to the main site for the user
                return System::redirect();
            }
        }
        $descriptorsArray = explode(',', $dllibre);
        $descriptorsString = '#';
        foreach ($descriptorsArray as $descriptor) {
            if ($descriptor != '') {
                $descriptor = trim(mb_strtolower($descriptor));
                //$descriptor = preg_replace('/\s*/m', '', $descriptor);
                $descriptorsString .= '#' . $descriptor . '#';
            }
        }
        $state = (UserUtil::getVar('uname') == $mailxtec) ? 1 : '-1';
        $item = array('schoolCode' => $ccentre,
            'bookTitle' => $tllibre,
            'bookLang' => $illibre,
            'bookAdminName' => $mailxtec,
            'bookDateInit' => time(),
            'bookState' => $state,
            'bookDescript' => $descriptorsString,
            'collectionId' => $bookCollection);

        if (!DBUtil::insertObject($item, 'books', 'bookId')) {
            return LogUtil::registerError(_CREATEFAILED);
        }
        // create the book tables
        if (!ModUtil::apiFunc('Books', 'user', 'createBookTables', array('bookId' => $item['bookId'],
                    'schoolCode' => $ccentre))) {
            // delete book information because creation has failed
            if (!DBUTil::deleteObjectById('books', $item['bookId'], 'bookId')) {
                return LogUtil::registerError(_DELETEFAILED);
            }
            return false;
        }
        // get school from database
        $rsschool = DBUtil::selectObjectByID('books_schools', $ccentre, 'schoolCode');
        if ($rsschool === false) {
            // delete book information because creation has failed
            if (!DBUTil::deleteObjectById('books', $item['bookId'], 'bookId')) {
                return LogUtil::registerError(_DELETEFAILED);
            }
            return LogUtil::registerError(_GETFAILED);
        }

        // connect to book database
        $connect = ModUtil::apiFunc('Books', 'user', 'connect', array('schoolId' => $rsschool['schoolId']));
        if (!$connect) {
            return false;
        }
        // set prefix for the tables of the book
        $prefix = $ccentre . '_' . $item['bookId'];

        // _config
        $fullpass = UserUtil::getVar('pass');
        $fullpass_array = explode('$', $fullpass);
        $pass = $fullpass_array[2];
        $sql = "INSERT INTO " . $prefix . "_config (
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
				'" . mysql_real_escape_string($tllibre) . "',
				'" . mysql_real_escape_string($site_path) . "llibre.php?fisbn=" . $prefix . "',
				'" . mysql_real_escape_string($mailxtec) . "',				
				'" . mysql_real_escape_string($pass) . "',
				'" . mysql_real_escape_string($descllibre) . "',
				'" . mysql_real_escape_string($abouttext) . "',
				'" . mysql_real_escape_string($version) . "',
				'" . mysql_real_escape_string($mailxtec . ModUtil::getVar('Books', 'mailDomServer')) . "',
				'" . mysql_real_escape_string($pathtoproccess) . "',
				'" . mysql_real_escape_string($Processor) . "',
				'" . mysql_real_escape_string($illibre) . "',
				'" . mysql_real_escape_string($image_folder_path) . $prefix . "',
				'" . mysql_real_escape_string($ellibre) . "'
			);";

        $rs = mysql_query($sql, $connect);

        if (!$rs) {
            mysql_close($connect);
            return false;
        }

        mysql_close($connect);

        return $item['bookId'];
    }

    /**
     * gets a book object
     * @author:	Francesc Bassas i Bullich
     * @param:	$args	array with the bookId
     * @return:	book object on success or false on failure
     */
    public function getBookById($args) {
        // argument check
        if (!isset($args['bookId']) || !is_numeric($args['bookId'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }

        // bookId
        $bookId = $args['bookId'];

        // security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }

        // checks if the user can export the book
        if (!ModUtil::apiFunc('Books', 'user', 'canExport', array('bookId' => $bookId))) {
            return LogUtil::registerPermissionError();
        }

        // get book from database
        $bookrecord = DBUtil::selectObjectByID('books', $bookId, 'bookId');

        if ($bookrecord === false) {
            return LogUtil::registerError(_GETFAILED);
        }

        // get school from database
        $schoolrecord = DBUtil::selectObjectByID('books_schools', $bookrecord['schoolCode'], 'schoolCode');

        if ($schoolrecord === false) {
            return LogUtil::registerError(_GETFAILED);
        }

        // connect to book database
        $connect = ModUtil::apiFunc('Books', 'user', 'connect', array('schoolId' => $schoolrecord['schoolId']));

        if (!$connect)
            return false;

        // set prefix for the tables of the book
        $prefix = $bookrecord['schoolCode'] . '_' . $bookId;

        $sql = 'SELECT site_title, opentext, openimage, abouttext, adminemail, showsearch, lang, theme, html_editor ' .
                'FROM ' . $prefix . '_config';

        $rsBook = mysql_query($sql, $connect);
        Loader::RequireOnce("modules/Books/includes/Book.php");
        $row = mysql_fetch_row($rsBook);
        $book = new Book($bookId,
                        $bookrecord['schoolCode'],
                        $row['site_title'],
                        $row['opentext'],
                        $row['openimage'],
                        $row['abouttext'],
                        $row['adminemail'],
                        $row['showsearch'],
                        $row['lang'],
                        $row['theme'],
                        $row['html_editor'],
                        $bookrecord['bookDescript']);

        // get chapters
        $sql = 'SELECT recno, name, openimage, opentext, permissions, notifyemail, entriespage, showname, showemail, showurl, showimage, formatpage ' .
                'FROM ' . $prefix . '_contents ' .
                'ORDER BY ordernum';

        $rsChapter = mysql_query($sql, $connect);

        if (!$rsChapter) {
            return false;
        } else {
            while ($row = mysql_fetch_assoc($rsChapter)) {
                Loader::RequireOnce("modules/Books/includes/Chapter.php");
                $chapter = new Chapter($row['recno'],
                                $row['name'],
                                $row['opentext'],
                                $row['openimage'],
                                $row['permissions'],
                                $row['notifyemail'],
                                $row['entriespage'],
                                $row['showname'],
                                $row['showemail'],
                                $row['showurl'],
                                $row['showimage'],
                                $row['formatpage']
                );


                // get pages
                $sql = 'SELECT email, webaddress, webname, comment, name, title, updated, approved, myimage, imagealign ' .
                        'FROM ' . $prefix . '_words ' .
                        'WHERE contentsid = ' . $chapter->getChapterId() . ' ' .
                        'ORDER BY ordernum';

                $rsPages = mysql_query($sql, $connect);

                if (!$rsPages) {
                    return false;
                } else {
                    while ($row = mysql_fetch_assoc($rsPages)) {
                        Loader::RequireOnce("modules/Books/includes/Page.php");
                        $page = new Page($row['title'],
                                        $row['comment'],
                                        $row['name'],
                                        $row['email'],
                                        $row['webaddress'],
                                        $row['webname'],
                                        $row['updated'],
                                        $row['myimage'],
                                        $row['imagealign']
                        );

                        if ($row['approved'] == 'Y') {
                            $chapter->addPage($page);
                        } else {
                            $chapter->addUnnaproved($page);
                        }

                        // $rsPages->MoveNext();
                    }
                    //$rsPages->close();
                    $book->pushChapter($chapter);
                }
                // $rsChapter->MoveNext();
            }
            //$rsChapter->close();
        }
        //$connect->close();
        mysql_close($connect);

        return $book;
    }

    /**
     * imports a book
     * @author:	Francesc Bassas i Bullich
     * @param:	$args	array with the path to the file to import, the schoolCode, the admin username and their password
     * @return:	
     */
    public function importBook($args) {
        // argument check
        if (!isset($args['book'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!isset($args['schoolCode'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!isset($args['username'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!isset($args['bookCollection'])) {
            return LogUtil::registerError(_MODARGSERROR);
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
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }

        // checks if the user can import a book
        if (!ModUtil::apiFunc('Books', 'user', 'canImport', array('schoolCode' => $schoolCode))) {
            return LogUtil::registerPermissionError();
        }

        // inserts the book's row into the table books

        $state = (UserUtil::getVar('uname') == $username) ? 1 : '-1';

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

        if (!DBUtil::insertObject($item, 'books', 'bookId')) {
            return LogUtil::registerError(_CREATEFAILED);
        }

        // create the book tables
        if (!ModUtil::apiFunc('Books', 'user', 'createBookTables', array('bookId' => $item['bookId'], 'schoolCode' => $book->getSchoolCode())))
            return false;

        // OMPLE LA BASE DE DADES
        // get school from database

        $rsSchool = DBUtil::selectObjectByID('books_schools', $book->getSchoolCode(), 'schoolCode');

        if ($rsSchool === false) {
            return LogUtil::registerError(_GETFAILED);
        }


        // connect to book database
        $connect = ModUtil::apiFunc('Books', 'user', 'connect', array('schoolId' => $rsSchool['schoolId']));


        if (!$connect)
            return false;

        // set prefix for the tables of the book
        $prefix = $book->getSchoolCode() . '_' . $item['bookId'];

        // _config
        // no està definit enlloc
        $site_path;
        // paràmetres definits al config.php de myscrapbook
        $version;
        $pathtoproccess;
        $Processor;

        $sql = "INSERT INTO " . $prefix . "_config (
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
				'" . mysql_real_escape_string($book->getBookTitle()) . "',
				'" . mysql_real_escape_string($site_path) . "llibre.php?fisbn=" . $prefix . "',
				'" . mysql_real_escape_string($username) . "',				
				'" . mysql_real_escape_string($password) . "',
				'" . mysql_real_escape_string($book->getOverview()) . "',
				'" . mysql_real_escape_string($book->getImage()) . "',
				'" . mysql_real_escape_string($book->getAbout()) . "',
				'" . mysql_real_escape_string($version) . "',
				'" . mysql_real_escape_string($username . ModUtil::getVar('Books', 'mailDomServer')) . "',
				'" . mysql_real_escape_string($pathtoproccess) . "',
				'" . mysql_real_escape_string($Processor) . "',
				'" . mysql_real_escape_string($book->getLang()) . "',
				'" . mysql_real_escape_string('/centres/' . $schoolCode . '_' . $item['bookId']) . "',
				'" . mysql_real_escape_string($book->getTheme()) . "'
			);";

        $rs = mysql_query($sql, $connect);

        if (!$rs) {
            mysql_close($connect);
            return false;
        }

        // _contents

        foreach ($book->getChapters() as $key => $chapter) {
            $sql = "INSERT INTO " . $prefix . "_contents (
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
					'" . mysql_real_escape_string($key + 1) . "',
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

            $rs = mysql_query($sql, $connect);

            if (!$rs) {
                mysql_close($connect);
                return false;
            }

            // _words

            $chapterId = DBUtil::getInsertId();

            foreach ($chapter->getPages() as $key => $page) {
                $sql = "INSERT INTO " . $prefix . "_words (
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
				'" . mysql_real_escape_string(date("YmdHis", time())) . "',
				'" . mysql_real_escape_string($chapterId) . "',
				'" . mysql_real_escape_string('Y') . "',
				'" . mysql_real_escape_string($page->getImage()) . "',
				'" . mysql_real_escape_string($key + 1) . "',
				'" . mysql_real_escape_string($page->getImageAlign()) . "'
			)";

                $rs = mysql_query($sql, $connect);

                if (!$rs) {
                    mysql_close($connect);
                    return false;
                }
            }

            foreach ($chapter->getUnnaproved() as $key => $page) {
                $sql = "INSERT INTO " . $prefix . "_words (
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
				'" . mysql_real_escape_string(date("YmdHis", time())) . "',
				'" . mysql_real_escape_string($chapterId) . "',
				'" . mysql_real_escape_string('N') . "',
				'" . mysql_real_escape_string($page->getImage()) . "',
				'" . mysql_real_escape_string($key + 1) . "',
				'" . mysql_real_escape_string($page->getImageAlign()) . "'
			)";

                $rs = mysql_query($sql, $connect);

                if (!$rs) {
                    mysql_close($connect);
                    return false;
                }
            }
        }

        mysql_close($connect);

        return $item['bookId'];
    }

    /**
     * 
     * @author:	Francesc Bassas i Bullich
     * @param:	$args
     * @return:	
     */
    public function insertBookRow($args) {
        // argument check
        if (!isset($args['book'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!isset($args['schoolCode'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!isset($args['username'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!isset($args['bookCollection'])) {
            return LogUtil::registerError(_MODARGSERROR);
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
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }

        // checks if the user can import a book
        if (!ModUtil::apiFunc('Books', 'user', 'canImport', array('schoolCode' => $schoolCode))) {
            return LogUtil::registerPermissionError();
        }

        // inserts the book's row into the table books

        $state = (UserUtil::getVar('uname') == $username) ? 1 : '-1';

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

        if (!DBUtil::insertObject($item, 'books', 'bookId')) {
            return LogUtil::registerError(_CREATEFAILED);
        }

        return $item['bookId'];
    }

    /**
     * 
     * @author:	Francesc Bassas i Bullich
     * @param:	$args
     * @return:	
     */
    public function insertBookTables($args) {
        // argument check
        if (!isset($args['book'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!isset($args['schoolCode'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!isset($args['bookId'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!isset($args['username'])) {
            return LogUtil::registerError(_MODARGSERROR);
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
        if (!ModUtil::getVar('Books', 'canCreateToOthers')) {
            $password = UserUtil::getVar('pass');
        }
        // security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }

        // checks if the user can import a book
        if (!ModUtil::apiFunc('Books', 'user', 'canImport', array('schoolCode' => $schoolCode))) {
            return LogUtil::registerPermissionError();
        }

        // create the book tables
        if (!ModUtil::apiFunc('Books', 'user', 'createBookTables', array('bookId' => $bookId, 'schoolCode' => $schoolCode)))
            return false;

        // OMPLE LA BASE DE DADES
        // get school from database

        $rsSchool = DBUtil::selectObjectByID('books_schools', $schoolCode, 'schoolCode');

        if ($rsSchool === false) {
            return LogUtil::registerError(_GETFAILED);
        }

        // connect to book database
        $connect = ModUtil::apiFunc('Books', 'user', 'connect', array('schoolId' => $rsSchool['schoolId']));

        if (!$connect)
            return false;

        // set prefix for the tables of the book
        $prefix = $schoolCode . '_' . $bookId;

        // _config
        // no està definit enlloc
        $site_path;
        // paràmetres definits al config.php de myscrapbook
        $version;
        $pathtoproccess;
        $Processor;

        $sql = "INSERT INTO " . $prefix . "_config (
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
				'" . mysql_real_escape_string($book->getBookTitle()) . "',
				'" . mysql_real_escape_string($site_path) . "llibre.php?fisbn=" . $prefix . "',
				'" . mysql_real_escape_string($username) . "',				
				'" . mysql_real_escape_string($password) . "',
				'" . mysql_real_escape_string($book->getOverview()) . "',
				'" . mysql_real_escape_string($book->getImage()) . "',
				'" . mysql_real_escape_string($book->getAbout()) . "',
				'" . mysql_real_escape_string($version) . "',
				'" . mysql_real_escape_string($username . ModUtil::getVar('Books', 'mailDomServer')) . "',
				'" . mysql_real_escape_string($pathtoproccess) . "',
				'" . mysql_real_escape_string($Processor) . "',
				'" . mysql_real_escape_string($book->getLang()) . "',
				'" . mysql_real_escape_string('/centres/' . $prefix) . "',
				'" . mysql_real_escape_string($book->getTheme()) . "'
			);";

        $rs = mysql_query($sql, $connect);

        if (!$rs) {
            mysql_close($connect);
            return false;
        }

        // _contents

        foreach ($book->getChapters() as $key => $chapter) {
            $sql = "INSERT INTO " . $prefix . "_contents (
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
					'" . mysql_real_escape_string($key + 1) . "',
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

            $rs = mysql_query($sql, $connect);

            if (!$rs) {
                mysql_close($connect);
                return false;
            }

            // _words

            $chapterId = DBUtil::getInsertId();

            foreach ($chapter->getPages() as $key => $page) {
                $sql = "INSERT INTO " . $prefix . "_words (
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
				'" . mysql_real_escape_string(date("YmdHis", time())) . "',
				'" . mysql_real_escape_string($chapterId) . "',
				'" . mysql_real_escape_string('Y') . "',
				'" . mysql_real_escape_string($page->getImage()) . "',
				'" . mysql_real_escape_string($key + 1) . "',
				'" . mysql_real_escape_string($page->getImageAlign()) . "'
			)";

                $rs = mysql_query($sql, $connect);

                if (!$rs) {
                    mysql_close($connect);
                    return false;
                }
            }

            foreach ($chapter->getUnnaproved() as $key => $page) {
                $sql = "INSERT INTO " . $prefix . "_words (
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
				'" . mysql_real_escape_string(date("YmdHis", time())) . "',
				'" . mysql_real_escape_string($chapterId) . "',
				'" . mysql_real_escape_string('N') . "',
				'" . mysql_real_escape_string($page->getImage()) . "',
				'" . mysql_real_escape_string($key + 1) . "',
				'" . mysql_real_escape_string($page->getImageAlign()) . "'
			)";

                $rs = mysql_query($sql, $connect);

                if (!$rs) {
                    mysql_close($connect);
                    return false;
                }
            }
        }

        mysql_close($connect);

        return true;
    }

    /**
     * creates the book tables
     * @author:	Francesc Bassas i Bullich
     * @param:	$args	array with the bookId
     * @return:	true on success or false on failure
     */
    public function createBookTables($args) {
        // argument check
        if (!isset($args['bookId']) || !is_numeric($args['bookId'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!isset($args['schoolCode'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        // bookId
        $bookId = $args['bookId'];
        // schoolCode
        $schoolCode = $args['schoolCode'];
        // security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }
        // checks if the user can create a book
        if (!ModUtil::func('Books', 'user', 'canCreate', array('userName' => UserUtil::getVar('uname')))) {
            return LogUtil::registerPermissionError();
        }
        /////////////////////////////////////////////////////
        // TODO: caldria crear totes les taules de forma atòmica //
        /////////////////////////////////////////////////////
        // get school from database
        $rsSchool = DBUtil::selectObjectByID('books_schools', $schoolCode, 'schoolCode');
        if ($rsSchool === false) {
            return LogUtil::registerError(_GETFAILED);
        }
        // connect to book database
        $connect = ModUtil::apiFunc('Books', 'user', 'connect', array('schoolId' => $rsSchool['schoolId']));
        if (!$connect)
            return false;

        // set prefix for the tables of the book
        $prefix = $schoolCode . '_' . $bookId;

        // _access
        $sql = "CREATE TABLE " . $prefix . "_access(
				recno		int(10) 	NOT NULL auto_increment,
				userid		int(10)		NOT NULL default '0',
				contentsid	int(10)		NOT NULL default '0',
				myaccess	char(1)		NOT NULL default 'N',
				PRIMARY KEY  (recno)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

        $rs = mysql_query($sql, $connect);

        if (!$rs)
            return false;

        // _contents
        $sql = "CREATE TABLE " . $prefix . "_contents(
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

        $rs = mysql_query($sql, $connect);

        if (!$rs)
            return false;

        // _users
        $sql = "CREATE TABLE " . $prefix . "_users (
				recno		int(10)			NOT NULL auto_increment,
				myusername	varchar(60)		NOT NULL default '',
				mypassword	varchar(60)		NOT NULL default '',
				email		varchar(80)		NOT NULL default '',
				name		varchar(100)	NOT NULL default '',
				loggedin	char(1)			NOT NULL default 'N',
				PRIMARY KEY  (recno)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

        $rs = mysql_query($sql, $connect);

        if (!$rs)
            return false;

        // _words
        $sql = "CREATE TABLE " . $prefix . "_words (
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

        $rs = mysql_query($sql, $connect);

        if (!$rs)
            return false;

        // _config
        $sql = "CREATE TABLE " . $prefix . "_config (
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

        $rs = mysql_query($sql, $connect);

        if (!$rs)
            return false;

        mysql_close($connect);

        return true;
    }

    /**
     * checks if a user can export a book
     * @author:	Francesc Bassas i Bullich
     * @param:	$args	array with the bookId
     * @return:	true if the user can export the book false otherwise
     */
    public function canExport($args) {
        // argument check
        if ($args['bookId'] == null || !is_numeric($args['bookId'])) {
            return false; // LogUtil::registerError (_MODARGSERROR);
        }

        // bookId
        $bookId = $args['bookId'];

        // checks if the user is a site admin
        if (SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            return true;
        }

        // security check
        if (!UserUtil::isLoggedIn() || !SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            return false; // LogUtil::registerPermissionError()
        }

        // gets logged user name
        $username = UserUtil::getVar('uname');

        // gets the schoolCode and bookAdminName of the book
        $bookinfo = ModUtil::apiFunc('Books', 'user', 'getBook', array('bookId' => $bookId));
        if (!$bookinfo) {
            return false;
        }

        // checks if the user is a school
        $school = ModUtil::apiFunc('Books', 'user', 'getSchool', array('schoolCode' => $username));
        if ($school) {
            // check if book belongs to the school
            if ($school == $bookinfo['schoolCode']) {
                return true;
            }
        }

        // checks if user is the admin of the book
        if ($username == $bookinfo['bookAdminName']) {
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
    public function canImport($args) {
        // argument check
        if ($args['schoolCode'] == null) {
            return LogUtil::registerError(_MODARGSERROR);
        }

        // schoolCode
        $schoolCode = $args['schoolCode'];

        // checks if the user is a site admin
        if (SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            return true;
        }

        // security check
        if (!UserUtil::isLoggedIn() || !SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }

        // gets logged user name
        $username = UserUtil::getVar('uname');

        // checks if the user is a school
        $school = ModUtil::apiFunc('Books', 'user', 'getSchool', array('schoolCode' => $username));
        if ($school) {
            return true;
        }

        // checks if user is allowed to create books in the school
        $table = DBUtil::getTables();
        $booksallowedcolumn = $table['books_allowed_column'];
        $where = "WHERE $booksallowedcolumn[userName] = '" . $username . "'" . " AND " .
                "$booksallowedcolumn[schoolCode] = '" . $schoolCode . "'";
        $rsallowed = DBUtil::selectObjectArray('books_allowed', $where);

        if (count($rsallowed) == 1) {
            return true;
        }

        return false;
    }

    /**
     * changes URLImageFolder 
     * @author:	Francesc Bassas i Bullich
     * @param:	$args	
     */
    public function changeURLImageFolder($args) {
        // argument check
        if ($args['bookId'] == null || !is_numeric($args['bookId'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }

        if ($args['schoolCode'] == null) {
            return LogUtil::registerError(_MODARGSERROR);
        }

        // bookId
        $bookId = $args['bookId'];

        // schoolCode
        $schoolCode = $args['schoolCode'];

        // get school from database
        $rsSchool = DBUtil::selectObjectByID('books_schools', $schoolCode, 'schoolCode');

        if ($rsSchool === false) {
            return LogUtil::registerError(_GETFAILED);
        }
        // connect to book database
        $connect = ModUtil::apiFunc('Books', 'user', 'connect', array('schoolId' => $rsSchool['schoolId']));

        if (!$connect)
            return false;

        // set prefix for the tables of the book
        $prefix = $schoolCode . '_' . $bookId;

        $sql = "UPDATE $prefix" . "_config SET image_folder = '/centres/$prefix'";

        $rsWords = mysql_query($sql, $connect);

        mysql_close($connect);
    }

    /**
     * Update the book main properties in table config 
     * @author:	Albert Pérez Monfort
     * @param:	The book properties that are stored in the book table config
     * @return: True if success and false otherwise
     */
    public function editBookSettings($args) {
        // argument check
        if (!isset($args['bookId']) || !is_numeric($args['bookId'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        // security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }
        // get book information
        $book = ModUtil::apiFunc('Books', 'user', 'getBook', array('bookId' => $args['bookId']));
        if (!$book) {
            return false;
        }
        // get school information
        $school = ModUtil::apiFunc('Books', 'user', 'getSchool', array('schoolCode' => $book['schoolCode']));
        if (!$school) {
            return false;
        }
        $isOwner = false;
        // check if user is the owner of the book
        if ($book['schoolCode'] == UserUtil::getVar('uname')) {
            $isOwner = true;
        }
        // check if user is the owner or the administrator of the book
        if (!$isOwner && $book['bookAdminName'] != UserUtil::getVar('uname')) {
            return false;
        }
        // calculate data base index
        $idb = floor($school[0]['schoolId'] / 50) + 1;
        // Initialize the DBConnection and place it on the connection stack
        $connect = ModUtil::apiFunc($this->name, 'user', 'connect', array('database' => ModUtil::getVar('Books', 'booksDatabase') . $idb));
        if (!$connect)
            return false;
        // set prefix for the tables of the book
        $prefix = $book['schoolCode'] . '_' . $args['bookId'];
        $sql = "UPDATE " . $prefix . "_config SET opentext='" . DataUtil::formatForStore($args['opentext']) .
                "', site_title='" . DataUtil::formatForStore($args['site_title']) .
                "', lang='" . $args['lang'] .
                "', theme='" . $args['theme'] .
                "', myname='" . $args['myname'] .
                "', mypass='" . $args['mypass'] . "'";
        $rs = mysql_query($sql, $connect);
        if (!$rs) {
            mysql_close($connect);
            return false;
        }

        mysql_close($connect);

        return true;
    }

// XTEC ********** AFEGIT -> Manage descriptors when save / edit books
// 2012.02.24 @mmartinez
    public function updateDescriptors($args) {
        // argument check
        if (!isset($args['oldValue']) || !isset($args['newValue'])) {
            return LogUtil::registerError(_MODARGSERROR);
        }

        // security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }

        //check if there are diferences 
        if ($args['oldValue'] != $args['newValue']) {
            $oldValue = explode('#', $args['oldValue']);
            $newValue = explode('#', $args['newValue']);

            $tables = DBUtil::getTables();
            $columns = $tables['books_descriptors_column'];
            $where = '';

            //process the values taken out
            $taken_out = array_diff($oldValue, $newValue);
            foreach ($taken_out as $val) {
                $where = "$columns[descriptor] = '{$val}'";
                $item = DBUtil::selectObject('books_descriptors', $where);
                if (!$item) {
                    //no exits
                    continue;
                } else {
                    //if exits, first check if value > 1 to less one, or not to delete the value
                    if ($item['number'] > 1) {
                        //less one
                        $obj = array('number' => ($item['number'] - 1));
                        $result = DBUtil::updateObject($obj, 'books_descriptors', $where, 'did');
                    } else {
                        //take out from db
                        $result = DBUtil::deleteObjectByID('books_descriptors', $item['did'], 'did');
                    }
                }
            }

            //process the new values
            $insert = array_diff($newValue, $oldValue);
            foreach ($insert as $val) {
                $where = "$columns[descriptor] = '{$val}'";
                $item = DBUtil::selectObject('books_descriptors', $where);
                if (!$item) {
                    //no exits, insert
                    $obj = array('descriptor' => $val, 'number' => 1);
                    $result = DBUtil::insertObject($obj, 'books_descriptors', 'did');
                } else {
                    //plus one
                    $obj = array('number' => ($item['number'] + 1));
                    $result = DBUtil::updateObject($obj, 'books_descriptors', $where, 'did');
                }
            }
        }

        return true;
    }

// ************ FI
}