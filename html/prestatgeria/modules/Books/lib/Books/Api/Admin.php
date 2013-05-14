<?php

class Books_Api_Admin extends Zikula_AbstractApi {

    /**
     * Update a descriptor in database
     * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:	descriptor id and value
     * @return:	true if success and false otherwise
     */
    public function updateDescriptor($args) {

        $did = FormUtil::getPassedValue('did', isset($args['did']) ? $args['did'] : null, 'POST');
        $items = FormUtil::getPassedValue('items', isset($args['items']) ? $args['items'] : null, 'POST');
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        // Needed argument
        if (!isset($did) || !is_numeric($did)) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        //Get form information
        $item = ModUtil::apiFunc('Books', 'user', 'getDescriptor', array('did' => $did));
        if ($item == false) {
            LogUtil::registerError($this->__('BOOKSDESCRIPTORNOTVALID'));
        }
        $table = DBUtil::getTables();
        $c = $table['books_descriptors_column'];
        $where = "$c[did] = $did";
        if (!DBUTil::updateObject($items, 'books_descriptors', $where)) {
            return LogUtil::registerError(_UPDATEFAILED);
        }
        return true;
    }

    /**
     * delete a descriptor in database
     * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:	descriptor id
     * @return:	true if success and false otherwise
     */
    public function deleteDescriptor($args) {
        $did = FormUtil::getPassedValue('did', isset($args['did']) ? $args['did'] : null, 'POST');
        $descriptor = FormUtil::getPassedValue('descriptor', isset($args['descriptor']) ? $args['descriptor'] : null, 'POST');
        $key = ($descriptor == null) ? 'did' : 'descriptor';
        $value = ($descriptor == null) ? $did : $descriptor;
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        // Needed argument
        if (!isset($did) || !is_numeric($did)) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        //Get form information
        $item = ModUtil::apiFunc('Books', 'user', 'getDescriptor', array('did' => $did));
        if ($item == false) {
            LogUtil::registerError($this->__('BOOKSDESCRIPTORNOTVALID'));
        }
        if (!DBUtil::deleteObjectByID('books_descriptors', $value, $key)) {
            return LogUtil::registerError(_DELETEFAILED);
        }

        return true;
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
    public function changeBookPath($args) {
        // security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }

        // arguments check
        $oldpath = FormUtil::getPassedValue('oldpath', isset($args['oldpath']) ? $args['oldpath'] : null, 'POST');
        $newpath = FormUtil::getPassedValue('newpath', isset($args['newpath']) ? $args['newpath'] : null, 'POST');
        $book_id = FormUtil::getPassedValue('book_id', isset($args['book_id']) ? $args['book_id'] : null, 'POST');
        $book_schoolcode = FormUtil::getPassedValue('book_schoolcode', isset($args['book_schoolcode']) ? $args['book_schoolcode'] : null, 'POST');
        $book_schoolId = FormUtil::getPassedValue('book_schoolId', isset($args['book_schoolId']) ? $args['book_schoolId'] : null, 'POST');

        if (!$oldpath) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!$newpath) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!$book_id) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!$book_schoolcode) {
            return LogUtil::registerError(_MODARGSERROR);
        }
        if (!$book_schoolId) {
            return LogUtil::registerError(_MODARGSERROR);
        }

        // connect to database of the book
        $connect = ModUtil::apiFunc('Books', 'user', 'connect', array('schoolId' => $book_schoolId));

        if (!$connect) {
            return false;
        }

        // _config table
        $sql = 'SELECT opentext ' .
                'FROM ' . $book_schoolcode . '_' . $book_id . '_config';
        $rs = DBUtil::executeSQL($sql);
        list ($opentext) = $rs->fields;

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
        $sql = 'SELECT recno, opentext ' .
                'FROM ' . $book_schoolcode . '_' . $book_id . '_contents';
        $rs = DBUtil::executeSQL($sql);

        for (; !$rs->EOF; $rs->MoveNext()) {
            list ($recno, $opentext) = $rs->fields;

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
        $sql = 'SELECT id, comment ' .
                'FROM ' . $book_schoolcode . '_' . $book_id . '_words';
        $rs = DBUtil::executeSQL($sql);

        for (; !$rs->EOF; $rs->MoveNext()) {
            list ($id, $comment) = $rs->fields;

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
    public function getAllSchoolInfo($args) {
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }

        if ($args['schoolsInfo'] == 1) {
            $table = 'books_schools_info';
            $key = 'schoolInfo';
        } else {
            $table = 'books_schools';
            $key = 'schoolId';
        }

        $tables = DBUtil::getTables();
        $c = $tables[$table . '_column'];
        $where = '';
        $orderby = "$c[schoolCode]";
        $items = DBUtil::selectObjectArray($table, $where, $orderby, '-1', '-1', $key);
        // Check for an error with the database code, and if so set an appropriate
        // error message and return
        if ($items === false) {
            return LogUtil::registerError(_GETFAILED);
        }
        // Return the items
        return $items;
    }

    public function createSchool($args) {
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
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

        if (!DBUtil::insertObject($item, 'books_schools', 'schoolId')) {
            return LogUtil::registerError(_CREATEFAILED);
        }

        // Return the id of the newly created item to the calling process
        return $item['schoolId'];
    }

}