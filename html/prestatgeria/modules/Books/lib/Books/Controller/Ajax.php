<?php

class Books_Controller_Ajax extends Zikula_Controller_AbstractAjax {

    public function showBookData($args) {
        if (!SecurityUtil::checkPermission('Books::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $bookId = $this->request->getPost()->get('bookId', '');
        if (!$bookId) {
            throw new Zikula_Exception_Fatal($this->__('no book id'));
        }
        $content = ModUtil::func('Books', 'user', 'getBookData', array('bookId' => $bookId));
        return new Zikula_Response_Ajax(array('content' => $content,
                ));
    }

    public function catalogue($args) {
        if (!SecurityUtil::checkPermission('Books::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $order = $this->request->getPost()->get('order', '');
        $init = $this->request->getPost()->get('init', '');
        if (!$init) {
            throw new Zikula_Exception_Fatal($this->__('no book id'));
        }
        $filter = $this->request->getPost()->get('filter', '');
        $filterValue = $this->request->getPost()->get('filterValue', '');
        $history = $this->request->getPost()->get('history', '');
        $content = ModUtil::func('Books', 'user', 'catalogue', array('order' => $order,
                    'init' => $init,
                    'history' => $history,
                    'filter' => $filter,
                    'filterValue' => $filterValue));
        return new Zikula_Response_Ajax(array('content' => $content,
                ));
    }

    public function addPrefer($args) {
        if (!SecurityUtil::checkPermission('Books::', '::', ACCESS_READ) || !UserUtil::isLoggedIn()) {
            throw new Zikula_Exception_Forbidden();
        }
        $bookId = $this->request->getPost()->get('bookId', '');
        if (!$bookId) {
            throw new Zikula_Exception_Fatal($this->__('no book id'));
        }
        $added = ModUtil::apiFunc('Books', 'user', 'addPrefer', array('bookId' => $bookId));
        if (!$added) {
            throw new Zikula_Exception_Fatal($this->__('adding error'));
        }
        $prefered = ModUtil::apiFunc('Books', 'user', 'getPrefered');
        // Check if the user is logged in
        if (!$prefered) {
            throw new Zikula_Exception_Fatal($this->__('no prefered found'));
        }
        $books = ModUtil::apiFunc('Books', 'user', 'getAllBooks', array('init' => 0,
                    'ipp' => 1000000,
                    'order' => 'bookHits',
                    'filter' => 'prefered',
                    'filterValue' => $prefered,
                    'notJoin' => 1));
        foreach ($books as $book) {
            $booksArray[] = array('bookTitle' => $book['bookTitle'],
                'bookId' => $book['bookId']);
        }
        // Create output object
        $view = Zikula_View::getInstance('Books', false);
        $view->assign('books', $booksArray);
        $content = $view->fetch('books_block_myPrefered.tpl');
        return new Zikula_Response_Ajax(array('content' => $content,
                ));
    }

    public function delPrefer($args) {
        if (!SecurityUtil::checkPermission('Books::', '::', ACCESS_READ) || !UserUtil::isLoggedIn()) {
            throw new Zikula_Exception_Forbidden();
        }
        $bookId = $this->request->getPost()->get('bookId', '');
        if (!$bookId) {
            throw new Zikula_Exception_Fatal($this->__('no book id'));
        }
        $deleted = ModUtil::apiFunc('Books', 'user', 'delPrefer', array('bookId' => $bookId));
        if (!$deleted) {
            throw new Zikula_Exception_Fatal($this->__('delete error'));
        }
        return new Zikula_Response_Ajax(array('bookId' => $bookId,
                ));
    }

    public function addComment($args) {
        if (!SecurityUtil::checkPermission('Books::', '::', ACCESS_COMMENT)) {
            throw new Zikula_Exception_Forbidden();
        }
        $bookId = $this->request->getPost()->get('bookId', '');
        if (!$bookId) {
            throw new Zikula_Exception_Fatal($this->__('no book id'));
        }
        $history = $this->request->getPost()->get('history', '');
        $content = ModUtil::func('Books', 'user', 'addComment', array('bookId' => $bookId,
                    'history' => $history));
        return new Zikula_Response_Ajax(array('content' => $content,
                ));
    }

    public function sendComment($args) {
        if (!SecurityUtil::checkPermission('Books::', '::', ACCESS_COMMENT)) {
            throw new Zikula_Exception_Forbidden();
        }
        $bookId = $this->request->getPost()->get('bookId', '');
        if (!$bookId) {
            throw new Zikula_Exception_Fatal($this->__('no book id'));
        }
        $commentText = $this->request->getPost()->get('commentText', '');
        if (!$commentText) {
            throw new Zikula_Exception_Fatal($this->__('no text'));
        }
        $history = $this->request->getPost()->get('history', '');
        //insert comment into data base
        if (!ModUtil::apiFunc('Books', 'user', 'createComment', array('commentText' => $commentText,
                    'bookId' => $bookId))) {
            throw new Zikula_Exception_Fatal($this->__('Error sending value'));
        }
        if ($history == 2) {
            $content = ModUtil::func('Books', 'user', 'catalogue', array('order' => $order,
                        'init' => $init,
                        'history' => $history));
        } else {
            $content = ModUtil::func('Books', 'user', 'getBookData', array('bookId' => $bookId));
        }
        return new Zikula_Response_Ajax(array('content' => $content,
                ));
    }

    public function collections($args) {
        if (!SecurityUtil::checkPermission('Books::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $content = ModUtil::func('Books', 'user', 'collections');
        return new Zikula_Response_Ajax(array('content' => $content,
                ));
    }

    public function searchReload($args) {
        if (!SecurityUtil::checkPermission('Books::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }       
        $filter = $this->request->getPost()->get('filter', '');
        if (!$filter) {
            throw new Zikula_Exception_Fatal($this->__('no filter'));
        }
        $filterValue = $this->request->getPost()->get('filterValue', '');
        $order = $this->request->getPost()->get('order', '');
        $content = ModUtil::func('Books', 'user', 'search', array('filter' => $filter,
                    'filterValue' => $filterValue,
                    'order' => $order));
        return new Zikula_Response_Ajax(array('content' => $content,
        ));
    }

    public function autocompleteSearch($args) {
        if (!SecurityUtil::checkPermission('Books::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $value = $this->request->getPost()->get('value', '');
        $filter = $this->request->getPost()->get('filter', '');
        $order = $this->request->getPost()->get('order', 'lastEntry');
        $values = ModUtil::apiFunc('Books', 'user', 'filterValues', array('value' => $value,
                    'filter' => $filter));
        $valueEntered = $value;
        $valuesArray = array();
        foreach ($values as $value) {
            switch ($filter) {
                case 'name':
                    $valuesString .= "<div><a style=\"cursor: pointer;\" onclick=\"catalogue('$order','name',1,'" . $value['schoolId'] . "',1)\">" . $value['schoolType'] . ' ' . $value['schoolName'] . " (" . $value['schoolCity'] . ")</a></div>";
                    break;
                case 'descriptor':
                    $pos = strpos($value['bookDescript'], $valueEntered);
                    $string = substr($value['bookDescript'], $pos);
                    $pos2 = strpos($string, "#");
                    $string = substr($string, 0, $pos2);
                    if (!in_array($string, $valuesArray)) {
                        $valuesString .= "<div><a style=\"cursor: pointer;\" onclick=\"catalogue('$order','descriptor',1,'" . $string . "',1)\">" . $string . "</a></div>";
                        $valuesArray[] = $string;
                    }
                    break;
                case 'city':
                    if (!in_array($value['schoolCity'], $valuesArray)) {
                        $valuesString .= "<div><a style=\"cursor: pointer;\" onclick=\"catalogue('$order','city',1,'" . str_replace("'", '--apos--', $value['schoolCity']) . "',1)\">" . $value['schoolCity'] . "</a></div>";
                        $valuesArray[] = $value['schoolCity'];
                    }
                case 'admin':
                    if (!in_array($value['bookAdminName'], $valuesArray)) {
                        $valuesString .= "<div><a style=\"cursor: pointer;\" onclick=\"catalogue('$order','admin',1,'" . $value['bookAdminName'] . "',1)\">" . $value['bookAdminName'] . "</a></div>";
                        $valuesArray[] = $value['bookAdminName'];
                    }
                    break;
            }
        }
        return new Zikula_Response_Ajax(array('values' => $valuesString,
                    'count' => count($values)
                ));
    }

    public function manage($args) {
        if (!SecurityUtil::checkPermission('Books::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $content = ModUtil::func('Books', 'user', 'manage');
        return new Zikula_Response_Ajax(array('content' => $content,
                ));
    }

    public function showCreators($args) {
        if (!SecurityUtil::checkPermission('Books::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $task = $this->request->getPost()->get('task', '');
        if (!$task) {
            throw new Zikula_Exception_Fatal($this->__('no task defined'));
        }
        $userName = $this->request->getPost()->get('userName', '');
        if ($userName != '') {
            if ($task == 'addCreator') {
                if (!ModUtil::apiFunc('Books', 'user', 'addCreator', array('userName' => $userName))) {
                    throw new Zikula_Exception_Fatal($this->__('error creating user'));
                }
            }
            if ($task == 'deleteCreator') {
                if (!ModUtil::apiFunc('Books', 'user', 'deleteCreator', array('userName' => $userName))) {
                    throw new Zikula_Exception_Fatal($this->__('error deleting user'));
                }
            }
        }
        $content = ModUtil::func('Books', 'user', 'getCreators');
        return new Zikula_Response_Ajax(array('content' => $content,
                ));
    }

    public function editDescriptor($args) {
        if (!SecurityUtil::checkPermission('Books::', '::', ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        $did = $this->request->getPost()->get('did', '');
        if (!$did) {
            throw new Zikula_Exception_Fatal($this->__('no descriptor id'));
        }
        $content = ModUtil::func('Books', 'admin', 'descriptorRowContent', array('did' => $did));
        return new Zikula_Response_Ajax(array('did' => $did,
                    'content' => $content,
                ));
    }

    public function updateDescriptor($args) {
        if (!SecurityUtil::checkPermission('Books::', '::', ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        $did = $this->request->getPost()->get('did', '');
        if (!$did) {
            throw new Zikula_Exception_Fatal($this->__('no descriptor id'));
        }
        $value = $this->request->getPost()->get('value', '');
        if (!$value) {
            throw new Zikula_Exception_Fatal($this->__('no value defined'));
        }
        // get old value
        if (!$descriptor = ModUtil::apiFunc('Books', 'user', 'getDescriptor', array('did' => $did))) {
            throw new Zikula_Exception_Fatal($this->__('get old value faild'));
        }
        $oldValue = $descriptor['descriptor'];
        // recalc descriptors number and change the descriptor in all the books
        $booksArray = ModUtil::apiFunc('Books', 'user', 'getAllBooks', array('init' => -1,
                    'rpp' => -1,
                    'notJoin' => 1,
                    'filter' => 'descriptor',
                    'filterValue' => $oldValue));
        // get the number in case the descriptor exists. In this case it is the addition
        $number = ModUtil::apiFunc('Books', 'user', 'getAllBooks', array('init' => -1,
                    'rpp' => -1,
                    'notJoin' => 1,
                    'filter' => 'descriptor',
                    'onlyNumber' => 1,
                    'filterValue' => $value));
        // if the value exists it is an addition so the value is delete
        if ($number > 0) {
            ModUtil::apiFunc('Books', 'admin', 'deleteDescriptor', array('did' => $descriptor['did'],
                'descriptor' => $value));
        } else {
            $number = 0;
        }
        $number = $number + count($booksArray);
        $value = $value;
        // edit descriptor
        if (!ModUtil::apiFunc('Books', 'admin', 'updateDescriptor', array('did' => $did,
                    'items' => array('descriptor' => $value,
                        'number' => $number)))) {
            throw new Zikula_Exception_Fatal($this->__('error updating descriptor'));
        } else {
            foreach ($booksArray as $book) {
                $valueToChange = str_replace('#' . $oldValue . '#', '#' . $value . '#', $book['bookDescript']);
                ModUtil::apiFunc('Books', 'user', 'editBook', array('bookId' => $book['bookId'],
                    'items' => array('bookDescript' => $valueToChange)));
            }
        }
        return new Zikula_Response_Ajax(array('did' => $did,
                    'content' => $content,
                ));
    }

    public function deleteDescriptor($args) {
        if (!SecurityUtil::checkPermission('Books::', '::', ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        $did = $this->request->getPost()->get('did', '');
        if (!$did) {
            throw new Zikula_Exception_Fatal($this->__('no descriptor id'));
        }
        $descriptor = ModUtil::apiFunc('Books', 'user', 'getDescriptor', array('did' => $did));
        // delete descriptor from data base
        if (!ModUtil::apiFunc('Books', 'admin', 'deleteDescriptor', array('did' => $did))) {
            throw new Zikula_Exception_Fatal($this->__('error deleting descriptor'));
        }
        // delete descriptor from books
        // get all the books that have the descriptor
        $books = ModUtil::apiFunc('Books', 'user', 'getAllBooks', array('init' => -1,
                    'rpp' => -1,
                    'notJoin' => 1,
                    'filter' => 'descriptor',
                    'filterValue' => $descriptor['descriptor']));
        // delete descriptors
        foreach ($books as $book) {
            $descriptorsValue = str_replace('#' . $descriptor['descriptor'] . '#', '', $book['bookDescript']);
            ModUtil::apiFunc('Books', 'user', 'editBook', array('bookId' => $book['bookId'],
                'items' => array('bookDescript' => $descriptorsValue)));
        }
        return new Zikula_Response_Ajax(array('did' => $did,
                ));
    }

    public function descriptors($args) {
        if (!SecurityUtil::checkPermission('Books::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $content = ModUtil::func('Books', 'user', 'descriptors');
        return new Zikula_Response_Ajax(array('content' => $content,
                ));
    }

}