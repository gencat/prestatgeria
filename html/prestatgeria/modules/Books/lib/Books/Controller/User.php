<?php

class Books_Controller_User extends Zikula_AbstractController {

    protected function postInitialize() {
        // Set caching to false by default.
        $this->view->setCaching(false);
    }

    /**
     * show the list of books created according to given order and criteria
     * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:    order and criteria parameters
     * @return:	The list of available books
     */
    public function catalogue($args) {
        $order = FormUtil::getPassedValue('order', isset($args['order']) ? $args['order'] : 'lastEntry', 'POST');
        $init = FormUtil::getPassedValue('init', isset($args['init']) ? $args['init'] : '1', 'POST');
        $history = FormUtil::getPassedValue('history', isset($args['history']) ? $args['history'] : null, 'POST');
        $filter = FormUtil::getPassedValue('filter', isset($args['filter']) ? $args['filter'] : null, 'POST');
        $filterValue = FormUtil::getPassedValue('filterValue', isset($args['filterValue']) ? $args['filterValue'] : null, 'POST');
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        if ($history == 1 || $history == 4) {
            if ($history == 4) {
                $historyValues = ModUtil::apiFunc('Books', 'user', 'getUserHistory');
                $index = $GLOBALS['_ZSession']['obj']['sessid'];
                $order = $historyValues[$index]['booksOrder'];
            }
            if ($order == '') {
                $order = 'lastEntry';
            }
            ModUtil::apiFunc('Books', 'user', 'saveUserHistory', array('item' => array('init' => $init,
                    'booksOrder' => $order,
                    'filter' => $filter,
                    'filterValue' => $filterValue,
                    'sessid' => $GLOBALS['_ZSession']['obj']['sessid'])));
        }
        if ($history == 2) {
            $historyValues = ModUtil::apiFunc('Books', 'user', 'getUserHistory');
            $index = $GLOBALS['_ZSession']['obj']['sessid'];
            $init = $historyValues[$index]['init'];
            $order = $historyValues[$index]['booksOrder'];
            $filter = $historyValues[$index]['filter'];
            $filterValue = $historyValues[$index]['filterValue'];
            if ($order == '') {
                $order = 'lastEntry';
            }
        }
        $books = ModUtil::apiFunc('Books', 'user', 'getAllBooks', array('init' => $init - 1,
                    'filter' => $filter,
                    'filterValue' => $filterValue,
                    'ipp' => 15,
                    'order' => $order));
        $total = ModUtil::apiFunc('Books', 'user', 'getAllBooks', array('onlyNumber' => 1,
                    'filter' => $filter,
                    'filterValue' => $filterValue));
        $pager = ModUtil::func('Books', 'user', 'pager', array('init' => $init,
                    'ipp' => 15,
                    'total' => $total,
                    'urltemplate' => "javascript:catalogue('$order','$filter',%%,'$filterValue',1)"));
        $filterValueSearch = $filterValue;
        if ($filter == 'collection') {
            $collection = ModUtil::apiFunc('Books', 'user', 'getCollection', array('collectionId' => $filterValue));
            $filterValue = $collection['collectionName'];
        }
        if ($filter == 'lang') {
            switch ($filterValue) {
                case 'ca':
                    $filterValue = $this->__('català');
                    break;
                case 'es':
                    $filterValue = $this->__('castellà');
                    break;
                case 'en':
                    $filterValue = $this->__('anglès');
                    break;
                case 'fr':
                    $filterValue = $this->__('francès');
                    break;
            }
        }
        if ($filter == 'name' || $filter == 'schoolCode') {
            $school = ($filter == 'name') ? ModUtil::apiFunc('Books', 'user', 'getSchool', array('schoolId' => $filterValue)) : ModUtil::apiFunc('Books', 'user', 'getSchool', array('schoolCode' => $filterValue));
            $filterValue = ($filter == 'name') ? $school['schoolType'] . ' ' . $school['schoolName'] : $school[0]['schoolType'] . ' ' . $school[0]['schoolName'];
            $filterValueSearch = $filterValue;
        }
        if ($filter == 'city') {
            $filterValueSearch = $filterValue;
        }
        $search = ModUtil::func('Books', 'user', 'search', array('filter' => $filter,
                    'order' => $order,
                    'filterValue' => $filterValueSearch));
        $canComment = (SecurityUtil::checkPermission('Books::', "::", ACCESS_COMMENT)) ? true : false;
        $canExport = (ModUtil::apiFunc('Books', 'user', 'canExport', array('bookId' => $bookId))) ? true : false;
        if ($filter == 'schoolCode') {
            $school = $school[0];
            $target = 'books_user_schoolCatalogue.tpl';
        } else {
            $school = '';
            $target = 'books_user_catalogue.tpl';
        }
        // Create output object
        return $this->view->assign('books', $books)
                        ->assign('pager', $pager)
                        ->assign('search', $search)
                        ->assign('filter', $filter)
                        ->assign('filterValue', $filterValue)
                        ->assign('order', $order)
                        ->assign('userName', UserUtil::getVar('uname'))
                        ->assign('bookSoftwareUrl', ModUtil::getVar('Books', 'bookSoftwareUrl'))
                        ->assign('canComment', $canComment)
                        ->assign('canExport', $canExport)
                        ->assign('school', $school)
                        ->fetch($target);
    }

    /**
     * check if a user can create new books
     * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
     * @param: userName
     * @return:	The school code that is going to create a book or false otherwise
     */
    public function canCreate($args) {
        $userName = FormUtil::getPassedValue('userName', isset($args['userName']) ? $args['userName'] : null, 'GET');
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        if (!UserUtil::isLoggedIn()) {
            return false;
        }
        //check if it is the school who is creating a book
        $school = ModUtil::apiFunc('Books', 'user', 'getSchool', array('schoolCode' => $userName));
        if ($school) {
            return $school[0]['schoolCode'];
        }
        if (!ModUtil::getVar('Books', 'canCreateToOthers')) {
            return false;
        }
        //check if the user is allowed to create a book for a school
        $schoolCode = ModUtil::apiFunc('Books', 'user', 'getCreator');
        if ($schoolCode) {
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
    public function getBookData($args) {
        $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'GETPOST');
        $history = FormUtil::getPassedValue('history', isset($args['history']) ? $args['history'] : null, 'POST');
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $book = ModUtil::apiFunc('Books', 'user', 'getBook', array('bookId' => $bookId));
        if (!$book) {
            return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("No s'ha trobat el llibre sol·licitat"),
                        'title' => $this->__("Resultat de la càrrega d'un llibre"),
                        'result' => 0));
        }

        $book['bookDayInit'] = date('d/m/Y', $book['bookDateInit']);
        $book['bookDayLastVisit'] = ($book['bookLastVisit'] != '') ? date('d/m/Y', $book['bookLastVisit']) : '';
        $book['bookTimeLastVisit'] = ($book['bookLastVisit'] != '') ? date('H.i', $book['bookLastVisit']) : '';
        if ($book['collectionId'] > 0) {
            $collection = ModUtil::apiFunc('Books', 'user', 'getCollection', array('collectionId' => $book['collectionId']));
        }
        $book['bookCollectionName'] = $collection['collectionName'];
        $comments = ModUtil::apiFunc('Books', 'user', 'getAllComments', array('bookId' => $bookId));
        foreach ($comments as $comment) {
            $commentsArray[] = array('userName' => $comment['userName'],
                'text' => $comment['text'],
                'dateDay' => date('d/m/Y', $comment['date']),
                'dateTime' => date('H.i', $comment['date']));
        }
        // get book main settings
        $bookSettings = ModUtil::apiFunc('Books', 'user', 'getBookMainSettings', array('bookId' => $bookId));
        /*
          return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $bookSettings,
          'title' => $this->__("Resultat de la càrrega d'un llibre"),
          'result' => 0));
         */

        if (!$bookSettings) {
            return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("Nos s'ha trobat el llibre sol·licitat"),
                        'title' => $this->__("Resultat de la càrrega d'un llibre"),
                        'result' => 0));
        }
        $book['opentext'] = $bookSettings['opentext'];

        $canComment = (SecurityUtil::checkPermission('Books::', "::", ACCESS_COMMENT)) ? true : false;
        $canExport = (ModUtil::apiFunc('Books', 'user', 'canExport', array('bookId' => $bookId))) ? true : false;

        // Create output object
        return $this->view->assign('bookInfoBook', $book)
                        ->assign('userName', UserUtil::getVar('uname'))
                        ->assign('history', $history)
                        ->assign('comments', $comments)
                        ->assign('canComment', $canComment)
                        ->assign('canExport', $canExport)
                        ->assign('bookSoftwareUrl', ModUtil::getVar('Books', 'bookSoftwareUrl'))
                        ->fetch('books_user_bookData.tpl');
    }

    /**
     * Generate a pager of books
     * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:	the information needed for the pager
     * @return:	A pager navigator
     */
    public function pager($args) {
        $ipp = FormUtil::getPassedValue('ipp', isset($args['ipp']) ? $args['ipp'] : null, 'POST');
        $init = FormUtil::getPassedValue('init', isset($args['init']) ? $args['init'] : null, 'POST');
        $total = FormUtil::getPassedValue('total', isset($args['total']) ? $args['total'] : null, 'POST');
        $urltemplate = FormUtil::getPassedValue('urltemplate', isset($args['urltemplate']) ? $args['urltemplate'] : null, 'POST');
        // Security check
        if (!SecurityUtil::checkPermission('Books::', '::', ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }

        // Quick check to ensure that we have work to do
        if ($total <= $ipp) {
            //return;
        }
        if (!isset($init) || empty($init)) {
            $init = 1;
        }
        if (!isset($ipp) || empty($ipp)) {
            $ipp = 10;
        }
        // Show startnum link
        if ($init != 1) {
            $url = preg_replace('/%%/', 1, $urltemplate);
            $text = '<a href="' . $url . '"><<</a> | ';
        } else {
            $text = '<< | ';
        }
        $items[] = array('text' => $text);
        // Show following items
        $pagenum = 1;
        for ($curnum = 1; $curnum <= $total; $curnum += $ipp) {
            if (($init < $curnum) || ($init > ($curnum + $ipp - 1))) {
                //mod by marsu - use sliding window for pagelinks
                if ((($pagenum % 10) == 0) // link if page is multiple of 10
                        || ($pagenum == 1) // link first page
                        || (($curnum > ($init - 4 * $ipp)) //link -3 and +3 pages
                        && ($curnum < ($init + 4 * $ipp)))
                ) {
                    // Not on this page - show link
                    $url = preg_replace('/%%/', $curnum, $urltemplate);
                    $text = '<a href="' . $url . '">' . $pagenum . '</a> | ';
                    $items[] = array('text' => $text);
                }
                //end mod by marsu
            } else {
                // On this page - show text
                $text = $pagenum . ' | ';
                $items[] = array('text' => $text);
            }
            $pagenum++;
        }
        if (($curnum >= $ipp + 1) && ($init < $curnum - $ipp)) {
            $url = preg_replace('/%%/', $curnum - $ipp, $urltemplate);
            $text = '<a href="' . $url . '">>></a>';
        } else {
            $text = '>>';
        }
        $items[] = array('text' => $text);

        return $this->view->assign('items', $items)
                        ->assign('total', $total)
                        ->fetch('books_user_pager.tpl');
    }

    /**
     * Displays the form needed to create a new comment for a book
     * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:	the book identity
     * @return:	The form fields
     */
    public function addComment($args) {
        $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
        $history = FormUtil::getPassedValue('history', isset($args['history']) ? $args['history'] : null, 'POST');
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_COMMENT)) {
            throw new Zikula_Exception_Forbidden();
        }
        $book = ModUtil::apiFunc('Books', 'user', 'getBook', array('bookId' => $bookId));
        // Create output object
        $view = Zikula_View::getInstance('Books', false);
        $view->assign('bookInfo', $book);
        $view->assign('history', $history);
        return $view->fetch('books_user_addComment.tpl');
    }

    /**
     * Displays the available collections
     * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
     * @return:	The list of collections
     */
    public function collections() {
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $collections = ModUtil::apiFunc('Books', 'user', 'getAllCollection');
        foreach ($collections as $collection) {
            $booksInCollection = ModUtil::apiFunc('Books', 'user', 'getBooksInCollection', array('collectionId' => $collection['collectionId']));
            $collectionsArray[] = array('collectionName' => $collection['collectionName'],
                'collectionState' => $collection['collectionState'],
                'collectionId' => $collection['collectionId'],
                'collectionAutoOut' => $collection['collectionAutoOut'],
                'booksInCollection' => $booksInCollection);
        }
        // Create output object
        return $this->view->assign('collections', $collectionsArray)
                        ->fetch('books_user_collections.tpl');
    }

    /**
     * Displays the form needed to create a new book
     * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
     * @return:	The form fields
     */
    public function newItem() {

        $create = ModUtil::func('Books', 'user', 'canCreate', array('userName' => UserUtil::getVar('uname')));
        // Security check
        if (!$create) {
            return $this->view->fetch('books_user_cantcreatenew.tpl');
        }
        $collections = ModUtil::apiFunc('Books', 'user', 'getAllCollection', array('state' => 1));
        return $this->view->assign('collections', $collections)
                        ->assign('canCreateToOthers', ModUtil::getVar('Books', 'canCreateToOthers'))
                        ->assign('schoolCode', $create)
                        ->assign('userName', UserUtil::getVar('uname'))
                        ->assign('helpTexts', ModUtil::func('Books', 'user', 'getHelpTexts'))
                        ->fetch('books_user_new.tpl');
    }

    /**
     * Checks if a created user is a school and in this case create the school in the table of schools. It allows to associate users previously created as schools
     * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
     * @return:	Redirect user to main page
     */
    public function inscribe() {
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        //******* Prestatgeria adaption *******
        //check if the user is a school, CRP or something like this
        $uname = str_replace('a', '0', UserUtil::getVar('uname'));
        $uname = str_replace('b', '1', $uname);
        $uname = str_replace('c', '2', $uname);
        $uname = str_replace('e', '4', $uname);
        $schoolInfo = ModUtil::apiFunc('Books', 'user', 'getSchoolInfo', array('schoolCode' => $uname));
        //if school is an school insert record in schools table
        if ($schoolInfo) {
            $items = array('schoolCode' => UserUtil::getVar('uname'),
                'schoolName' => $schoolInfo['schoolName'],
                'schoolType' => $schoolInfo['schoolType'],
                'schoolDateIns' => time(),
                'schoolCity' => $schoolInfo['schoolCity'],
                'schoolZipCode' => $schoolInfo['schoolZipCode'],
                'schoolRegion' => $schoolInfo['schoolRegion']);
            $created = ModUtil::apiFunc('Books', 'user', 'createSchool', array('items' => $items));
        }
        return System::redirect();
    }

    /**
     * Checks the information given for a new book and create it if the information received is correct
     * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:    The book main parameters
     * @return:	Redirect to a informative page if success or to the creation page oterwise
     */
    public function updateBook($args) {


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
        if (!$creator = ModUtil::func('Books', 'user', 'canCreate', array('userName' => UserUtil::getVar('uname')))) {
            throw new Zikula_Exception_Forbidden();
        }
        // Confirm authorisation code
        $this->checkCsrfToken();

        if ($confirm != 1) {
            return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("No has acceptat les condicions d'ús. El llibre no s'ha pogut crear"),
                        'title' => $this->__('Resultat en la creació del llibre'),
                        'result' => 0));
        }
        $canCreateToOthers = ModUtil::getVar('Books', 'canCreateToOthers');
        if ($ccentre != UserUtil::getVar('uname') && $ccentre != $creator) {
            // Check if the user can create books here
            if (!$allowedUser = ModUtil::apiFunc('Books', 'user', 'allowedUser', array('ccentre' => $ccentre)) || !$canCreateToOthers) {
                return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__('No pots crear llibres en nom del centre'),
                            'title' => $this->__('Resultat en la creació del llibre'),
                            'result' => 0));
            }
        }
        if ($importBook == 1) {
            //import a book from a file
            //Upload file
            //gets the attached file array
            $fileName = $_FILES['importFile']['name'];
            if ($fileName == '') {
                return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("No s'ha trobat el fitxer d'importació"),
                            'title' => $this->__('Resultat en la creació del llibre'),
                            'result' => 0));
            }
            $file_extension = strtolower(substr(strrchr($fileName, "."), 1));
            if ($file_extension != 'zip') {
                return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("El fitxer d'importació no és correcte"),
                            'title' => $this->__('Resultat en la creació del llibre'),
                            'result' => 0));
            }
            //Update the file
            global $ZConfig;
            $path = $ZConfig['System']['temp'] . '/books/import/' . $fileName;
            if (!move_uploaded_file($_FILES['importFile']['tmp_name'], $path)) {
                return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("S'ha produït un error en carregar el fitxer d'importació"),
                            'title' => $this->__('Resultat en la creació del llibre'),
                            'result' => 0));
            }
            if (!ModUtil::func('Books', 'user', 'importBook', array('path' => $path,
                        'schoolCode' => $ccentre,
                        'username' => $mailxtec,
                        'bookCollection' => $bookCollection))) {
                return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("S'ha produït un error en la importació del llibre. Torna-ho a provar més endavant"),
                            'title' => $this->__('Resultat en la creació del llibre'),
                            'result' => 0));
            } else {
                return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("El llibre s'ha editat correctament."),
                            'title' => $this->__('Resultat en la creació del llibre'),
                            'result' => 1));
            }
        } else {
            //Create book
            if (!$bookId = ModUtil::apiFunc('Books', 'user', 'createBook', array('ccentre' => $ccentre,
                        'tllibre' => $tllibre,
                        'illibre' => $illibre,
                        'descllibre' => $descllibre,
                        'ellibre' => $ellibre,
                        'bookCollection' => $bookCollection,
                        'dllibre' => $dllibre,
                        'mailxtec' => $mailxtec))) {
                // remove book images folder
                rmdir($path);
                return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("S'ha produït un error en la creació del llibre. Torna-ho a provar més endavant"),
                            'title' => $this->__('Resultat en la creació del llibre'),
                            'result' => 0));
            }

// XTEC *********** AFEGIT -> Manage descriptors when save / edit books
// 2012.02.24 @mmartinez
            $descriptorsArray = explode(',', $dllibre);

            $bookDescriptString = '#';
            foreach ($descriptorsArray as $descriptor) {
                if ($descriptor != '') {
                    $descriptor = trim(mb_strtolower($descriptor));
                    //$descriptor = preg_replace('/\s*/m', '', $descriptor);
                    $bookDescriptString .= '#' . $descriptor . '#';
                }
            }

            if (!ModUtil::apiFunc('Books', 'user', 'updateDescriptors', array('oldValue' => '',
                        'newValue' => $bookDescriptString))) {
                return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("S'ha produït un error en editar els descriptors del llibre."),
                            'title' => $this->__('Edita el llibre'),
                            'result' => 0));
            }
// *********** FI
        }
        // create the book folder where the book images have to be stored
        $path = ModUtil::getVar('Books', 'serverImageFolder') . '/' . $ccentre . '_' . $bookId;
        if (!mkdir($path, 0777)) {
            // change book state to -1 to make possible to delete it
            ModUtil::apiFunc('Books', 'user', 'editBook', array('bookId' => $bookId,
                'items' => array('bookState' => -1)));
            // delete book entry
            ModUtil::apiFunc('Books', 'user', 'activateBook', array('bookId' => $bookId,
                'action' => 'delete'));
            return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("S'ha produït un error en la creació del llibre. Torna-ho a provar més endavant"),
                        'title' => $this->__('Resultat en la creació del llibre'),
                        'result' => 0));
        }
        //if the user is the same as the administrator it is not necessari validate the book. Otherwise validation is needed
        if ($mailxtec != $ccentre && $mailxtec != UserUtil::getVar('uname')) {
            LogUtil::registerStatus($this->__("El llibre no estarà disponible fins que la persona a qui se n'ha assignat l'administració confimi que el vol activar. Ho pot fer des de la mateixa Prestatgeria. Quan s'hi identifiqui rebrà un avís d'activació."));
            //send mail to user
            //Check if module Mailer is active
            $modid = ModUtil::getIdFromName('Mailer');
            $modinfo = ModUtil::getInfo($modid);
            //if it is active
            if ($modinfo['state'] == 3) {
                $view = Zikula_View::getInstance('Books', false);
                $school = ModUtil::apiFunc('Books', 'user', 'getSchool', array('schoolCode' => $ccentre));
                $book = array('bookTitle' => $tllibre,
                    'schoolType' => $school[0]['schoolType'],
                    'schoolName' => $school[0]['schoolName'],
                    'schoolCode' => $school[0]['schoolCode'],
                    'bookId' => $bookId);
                $view->assign('book', $book);
                $view->assign('bookSoftwareUrl', ModUtil::getVar('Books', 'bookSoftwareUrl'));
                $sendResult = ModUtil::apiFunc('Mailer', 'user', 'sendmessage', array('toname' => $mailxtec,
                            'toaddress' => $mailxtec . ModUtil::getVar('Books', 'mailDomServer'),
                            'subject' => $this->__("Tens un llibre pendent d'activació"),
                            'body' => $view->fetch('books_user_newBookMail.tpl'),
                            'html' => 1));
            }
        }
        return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("El llibre s'ha creat correctament."),
                    'title' => $this->__('Resultat en la creació del llibre'),
                    'result' => 1));
    }

    /**
     * Displays the search form in the books cataloge
     * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:    The default form fields
     * @return:	The search form fields
     */
    public function search($args) {
        $filter = FormUtil::getPassedValue('filter', isset($args['filter']) ? $args['filter'] : null, 'POST');
        $order = FormUtil::getPassedValue('order', isset($args['order']) ? $args['order'] : null, 'POST');
        $filterValue = FormUtil::getPassedValue('filterValue', isset($args['filterValue']) ? $args['filterValue'] : null, 'POST');
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $collections = ModUtil::apiFunc('Books', 'user', 'getAllCollection');
        // Create output object
        return $this->view->assign('filter', $filter)
                        ->assign('order', $order)
                        ->assign('filterValue', $filterValue)
                        ->assign('collections', $collections)
                        ->fetch('books_user_search.tpl');
    }

    /**
     * Update the activation results of a book following the user wishes
     * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:    The book identity and the user's activation wishes
     * @return:	Redirect user to the main page
     */
    public function submitActivationNotify($args) {
        $submit = FormUtil::getPassedValue('submit', isset($args['submit']) ? $args['submit'] : null, 'POST');
        $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
        $book = ModUtil::apiFunc('Books', 'user', 'getBook', array('bookId' => $bookId));
        if ($book['bookState'] == 1 && $book['newBookAdminName'] != UserUtil::getVar('uname')) {
            return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__('Aquest llibre ja està activat'),
                        'title' => $this->__("Resultat de l'acceptació d'un llibre"),
                        'result' => 0,
                        'returnURL' => 'index.php'));
        }
        if ($book['bookAdminName'] != UserUtil::getVar('uname') && $book['bookAdminName'] != '' && $book['newBookAdminName'] != UserUtil::getVar('uname')) {
            return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__('No tens autorització per acceptar aquest llibre.'),
                        'title' => $this->__("Resultat de l'acceptació d'un llibre"),
                        'result' => 0,
                        'returnURL' => 'index.php'));
        }
        if ($submit == $this->__("Accepto l'assignació")) {
            if (ModUtil::apiFunc('Books', 'user', 'activateBook', array('bookId' => $bookId,
                        'action' => 'activate'))) {
                $msg = $this->__("El llibre s'ha activat correctament. L'hauries de veure a l'apartat dels teus llibres.");
            } else {
                return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("S'ha produït un error i no s'ha pogut portar a terme l'acció sol·licitada."),
                            'title' => $this->__("Resultat de l'acceptació d'un llibre"),
                            'result' => 0,
                            'returnURL' => 'index.php'));
            }
        } else {
            if (ModUtil::apiFunc('Books', 'user', 'activateBook', array('bookId' => $bookId,
                        'action' => 'delete'))) {
                $msg = $this->__("No s'ha acceptat l'administració del llibre i l'assignació ha estat esborrada.");
            } else {
                return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("S'ha produït un error i no s'ha pogut portar a terme l'acció sol·licitada."),
                            'title' => $this->__("Resultat de l'acceptació d'un llibre"),
                            'result' => 0,
                            'returnURL' => 'index.php'));
            }
        }
        return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $msg,
                    'title' => $this->__("Resultat de l'acceptació d'un llibre"),
                    'result' => 1,
                    'returnURL' => 'index.php'));
    }

    /**
     * Displays the managment page for books
     * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
     * @return:	The managment books information
     */
    public function manage() {
        $userName = UserUtil::getVar('uname');
        // Security check
        // get school
        $school = ModUtil::apiFunc('Books', 'user', 'getSchool', array('schoolCode' => $userName));
        if (!$school) {
            throw new Zikula_Exception_Forbidden();
        }
        $books = ModUtil::apiFunc('Books', 'user', 'getAllBooks', array('init' => '-1',
                    'ipp' => '-1',
                    'order' => 'bookHits',
                    'filter' => 'schoolCode',
                    'filterValue' => $userName,
                    'bookState' => 'all',
                    'notJoin' => 1));
        foreach ($books as $book) {
            $lastVisit = ($book['bookLastVisit'] != '') ? date('d/m/y', $book['bookLastVisit']) : '';
            $booksArray[] = array('bookTitle' => $book['bookTitle'],
                'bookId' => $book['bookId'],
                'schoolCode' => $book['schoolCode'],
                'bookState' => $book['bookState'],
                'bookAdminName' => $book['bookAdminName'],
                'newBookAdminName' => $book['newBookAdminName'],
                'bookPages' => $book['bookPages'],
                'bookHits' => $book['bookHits'],
                'bookDayInit' => date('d/m/y', $book['bookDateInit']),
                'bookDateLastVisit' => $lastVisit,
            );
        }
        $allowed = ModUtil::apiFunc('Books', 'user', 'getAllCreators');

        return $this->view->assign('books', $booksArray)
                        ->assign('allowed', $allowed)
                        ->assign('canCreateToOthers', ModUtil::getVar('Books', 'canCreateToOthers'))
                        ->assign('bookSoftwareUrl', ModUtil::getVar('Books', 'bookSoftwareUrl'))
                        ->assign('schoolCode', $userName)
                        ->fetch('books_user_manage.tpl');
    }

    /**
     * Get and display the list of users that can create books for a given school
     * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
     * @return:	The list of users that can create books for a given school
     */
    public function getCreators() {
        // Security check
        if (!ModUtil::func('Books', 'user', 'canCreate', array('userName' => UserUtil::getVar('uname')))) {
            throw new Zikula_Exception_Forbidden();
        }
        $allowed = ModUtil::apiFunc('Books', 'user', 'getAllCreators');

        return $this->view->assign('allowed', $allowed)
                        ->fetch('books_user_manageCreators.tpl');
    }

    /**
     * Display the list of descriptors for all the books
     * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
     * @return:	The list of descriptors
     */
    public function descriptors() {
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $max_font_size = 30;
        $min_font_size = 12;
        $maximum_count = 0;
        $minimum_count = 10000;
        // get all descriptors
        $tags = ModUtil::apiFunc('Books', 'user', 'getAllDescriptors', array('order' => 'descriptor'));
        $cloudArray = array(); // create an array to hold tag code
        if (count($tags) > 0) {
            foreach ($tags as $tag) {
                if ($tag['number'] > $maximum_count) {
                    $maximum_count = $tag['number'];
                }
                if ($tag['number'] < $minimum_count) {
                    $minimum_count = $tag['number'];
                }
            }
            $spread = $maximum_count - $minimum_count;
            if ($spread == 0) {
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
        return $this->view->assign('cloud', $cloudArray)
                        ->fetch('books_user_descriptors.tpl');
    }

    /**
     * Delete a book
     * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:    The book identity and the confirmation flag
     * @return:	Redirect user to the managment page
     */
    public function removeBook($args) {


        $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'REQUEST');
        $confirmation = FormUtil::getPassedValue('confirmation', isset($args['confirmation']) ? $args['confirmation'] : null, 'POST');
        $submit = FormUtil::getPassedValue('submit', isset($args['submit']) ? $args['submit'] : null, 'POST');
        // security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        // gets book information
        $book = ModUtil::apiFunc('Books', 'user', 'getBook', array('bookId' => $bookId));
        if (!$book) {
            return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("No s'ha trobat el llibre sol·licitat."),
                        'title' => $this->__("Resultat de la càrrega d'un llibre"),
                        'result' => 0));
        }
        // check if user is the owner of the book
        if ($book['schoolCode'] != UserUtil::getVar('uname')) {
            return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__('No pots esborrar aquest llibre.'),
                        'title' => $this->__("Resultat de la càrrega d'un llibre"),
                        'result' => 0));
        }
        if ($confirmation == null) {
            $view = Zikula_View::getInstance('Books', false);
            $view->assign('book', $book);
            return $view->fetch('books_user_removeBook.tpl');
        }
        if ($submit == _CANCEL) {
            return System::redirect(ModUtil::url('Books', 'user', 'manage'));
        }
// XTEC *********** AFEGIT -> Manage descriptors when save / edit books
// 2012.02.24 @mmartinez
        if (!ModUtil::apiFunc('Books', 'user', 'updateDescriptors', array('oldValue' => $book['bookDescript'],
                    'newValue' => ''))) {
            return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("S'ha produït un error en editar els descriptors del llibre."),
                        'title' => $this->__('Edita el llibre'),
                        'result' => 0));
        }
// *********** FI
        // remove the book. If book state is -1 remove it completelly and set state to -2 otherwise and book is invible to users
        switch ($book['bookState']) {
            case -1:
                // the book is removed completely
                if (!ModUtil::apiFunc('Books', 'user', 'activateBook', array('bookId' => $book['bookId'],
                            'action' => 'delete'))) {
                    LogUtil::registerError($this->__("S'ha produït un error en l'esborrament del llibre"));
                    return System::redirect(ModUtil::url('Books', 'user', 'manage'));
                }
                break;
            case 0:
                // TODO: A site administrator is deleting the book
                break;
            case 1:
                // the book state is set to -2
                if (!ModUtil::apiFunc('Books', 'user', 'editBook', array('bookId' => $book['bookId'],
                            'items' => array('bookState' => -2)))) {
                    LogUtil::registerError($this->__("S'ha produït un error en l'esborrament del llibre"));
                    return System::redirect(ModUtil::url('Books', 'user', 'manage'));
                }
                break;
        }
        LogUtil::registerStatus($this->__('El llibre ha estat esborrat'));
        return System::redirect(ModUtil::url('Books', 'user', 'manage'));
    }

    /**
     * Allow to create publicity of the book which is displaied in the main page
     * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:    The book identity
     * @return:	???
     */
    public function newPublic() {
        $msg = 'Aquesta funci&oacute; de moment no est&agrave; operativa, per&ograve; ho estar&agrave; en breu.';
        $title = 'Publicita el llibre';
        return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $msg,
                    'title' => $title,
                    'result' => 0));
    }

    /**
     * Allow to the administrators and owners of a book to change the main properties
     * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:    The book identity
     * @return:	???
     */
    public function editBook() {


        $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'GET');
        // security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        // get book information
        $book = ModUtil::apiFunc('Books', 'user', 'getBook', array('bookId' => $bookId));
        if (!$book) {
            return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("No s'ha trobat el llibre sol·licitat."),
                        'title' => $this->__("Resultat de la càrrega d'un llibre"),
                        'result' => 0));
        }
        $isOwner = false;
        $isAdministrator = false;
        // check if user is the owner of the book
        if ($book['schoolCode'] == UserUtil::getVar('uname')) {
            $isOwner = true;
        }
        // check if user is the administrator of the book
        if ($book['bookAdminName'] == UserUtil::getVar('uname')) {
            $isAdministrator = true;
        }
        if (!$isAdministrator && !$isOwner) {
            return System::redirect();
        }
        // get book main settings
        $bookSettings = ModUtil::apiFunc('Books', 'user', 'getBookMainSettings', array('bookId' => $bookId));
        if (!$bookSettings) {
            return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("No s'ha trobat el llibre sol·licitat."),
                        'title' => $this->__("Resultat de la càrrega d'un llibre"),
                        'result' => 0));
        }
        $bookDescriptors = str_replace('##', ',', substr($book['bookDescript'], 2, -1));

        $book['bookDescript'] = $bookDescriptors;

        $collections = ModUtil::apiFunc('Books', 'user', 'getAllCollection', array('state' => 1));

        // Create output object
        return $this->view->assign('isOwner', $isOwner)
                        ->assign('bookSettings', $bookSettings)
                        ->assign('book', $book)
                        ->assign('helpTexts', ModUtil::func('Books', 'user', 'getHelpTexts'))
                        ->assign('collections', $collections)
                        ->assign('canCreateToOthers', ModUtil::getVar('Books', 'canCreateToOthers'))
                        ->assign('userName', UserUtil::getVar('uname'))
                        ->fetch('books_user_editBook.tpl');
    }

    public function getHelpTexts($args) {
        $helpTexts = array('_BOOKSIMPORTEXPORTEDBOOK' => $this->__("Si voleu podeu importar un llibre des d'un fitxer d'importació"),
            '_BOOKSTITLETOSHOW' => $this->__('Aquest serà el text amb el qual es reconeixerà el llibre.') . '<br />' . $this->__("Des de l'interior del llibre, si n'ets l'administrador, el pots modificar."),
            '_BOOKSLANGUAGETOSHOW' => $this->__("Des de l'interior del llibre, si n'ets l'administrador, el pots modificar.") . '<br />' . $this->__("Des de l'interior del llibre, si n'ets l'administrador, el pots modificar."),
            '_BOOKSINTRODUCTIONTOSHOW' => $this->__("Es tracta d'un text informatiu que hi ha a la contraportada del llibre.") . '<br />' . $this->__("Des de l'interior del llibre, si n'ets l'administrador, el pots modificar."),
            '_BOOKSSTYLETOSHOW' => $this->__("L'aspecte del llibre depèn de l'opció que triada en aquest apartat.") . '<br />' . $this->__("Des de l'interior del llibre, si n'ets l'administrador, el pots modificar."),
            '_BOOKSDESCRIPTORSTOSHOW' => $this->__("Permet posar uns descriptors de cerca.<br />Els descriptors permetran fer una classificació del llibre.<br />Els descriptors s'han d'entrar separats per comes i han de ser paràules amb minúscula i sense espais. Un parell d'exemples de descriptors vàlids són: <strong>tecnologia,mecànica,eso</strong> o bé <strong>català,poesia</strong><br />Un descriptor de l'estil <strong>llengua catalana,poesia</strong> no és vàlid.<br />Aquests descriptors els podrà modificar l'administrador/a del llibre cada vegada que ho cregui oportú des de l'edició del llibre."),
            '_BOOKSADMINTOSHOW' => $this->__("Cal que sigui un usuari/ària de la XTEC vàlid. Altrament, no es podrà crear el llibre.<br />Per accedir a l'administració del llibre, s'haurà de fer servir el nom d'usuari/ària i la contrasenya de la XTEC."),
            '_BOOKSACCEPTTOSHOW' => $this->__("Cal acceptar les condicions d'ús dels llibres per poder-los crear. Aquestes condicions s'han de tenir presents en el moment d'editar els continguts del llibre."),
            '_BOOKSCOLLECTIONSTOSHOW' => $this->__('Si hi ha col·leccions disponibles, podeu associar el llibre a una de les col·leccions proposades.<br />Això farà possible llistar els llibres per col·leccions.'));
        return $helpTexts;
    }

    /**
     * Checks the information given for a edit book and update it if the information received is correct
     * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:    The book main parameters
     * @return:	Redirect to a informative page if success or to the creation page oterwise
     */
    public function updateEditBook($args) {
        $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'POST');
        $bookTitle = FormUtil::getPassedValue('bookTitle', isset($args['bookTitle']) ? $args['bookTitle'] : null, 'POST');
        $bookLang = FormUtil::getPassedValue('bookLang', isset($args['bookLang']) ? $args['bookLang'] : null, 'POST');
        $opentext = FormUtil::getPassedValue('opentext', isset($args['opentext']) ? $args['opentext'] : null, 'POST');
        $theme = FormUtil::getPassedValue('theme', isset($args['theme']) ? $args['theme'] : null, 'POST');
        $bookDescript = FormUtil::getPassedValue('bookDescript', isset($args['bookDescript']) ? $args['bookDescript'] : null, 'POST');
        $bookCollection = FormUtil::getPassedValue('bookCollection', isset($args['bookCollection']) ? $args['bookCollection'] : null, 'POST');
        $bookAdminName = FormUtil::getPassedValue('bookAdminName', isset($args['bookAdminName']) ? $args['bookAdminName'] : null, 'POST');

        $this->checkCsrfToken();

        // get book information
        $book = ModUtil::apiFunc('Books', 'user', 'getBook', array('bookId' => $bookId));
        if (!$book) {
            return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("No s'ha trobat el llibre sol·licitat."),
                        'title' => $this->__("Resultat de la càrrega d'un llibre"),
                        'result' => 0));
        }
        // get book main settings
        $bookSettings = ModUtil::apiFunc('Books', 'user', 'getBookMainSettings', array('bookId' => $bookId));
        if (!$bookSettings) {
            return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("No s'ha trobat el llibre sol·licitat."),
                        'title' => $this->__("Resultat de la càrrega d'un llibre"),
                        'result' => 0));
        }

        $userName = UserUtil::getVar('uname');
        $isOwner = false;
        // check if user is the owner of the book
        if ($book['schoolCode'] == $userName) {
            $isOwner = true;
            $returnURL = ModUtil::url('Books', 'user', 'manage');
        } else {
            $returnURL = ModUtil::url('Books', 'user', 'getBookData', array('bookId' => $bookId));
        }
        if (!$isOwner && $book['bookAdminName'] != $userName) {
            return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__('No tens permís per editar aquest llibre'),
                        'title' => $this->__('Edita el llibre'),
                        'result' => 0));
        }
        $newBookAdminName = '';
        $sendConfirmationMsg = false;
        if ($bookAdminName == $book['bookAdminName']) {
            // the book administrator doesn't change. The confirmation is not required
            $myname = $bookSettings['myname'];
            $mypass = $bookSettings['mypass'];
        } else if ($bookAdminName == $userName) {
            // the administrator change but it is the same as the owner. The confirmation is not required
            $myname = $userName;
            $fullpass = UserUtil::getVar('pass');
            $fullpass_array = explode('$', $fullpass);
            $mypass = $fullpass_array[2];
        } else {
            // the administrator change and the confirmation is required
            $oBookAdminName = $bookAdminName;
            if ($book['bookState'] == '-1') {
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
        if ($book['collectionId'] > 0)
            $bookCollection = $book['collectionId'];
        $descriptorsArray = explode(',', $bookDescript);

        $bookDescriptString = '#';
        foreach ($descriptorsArray as $descriptor) {
            if ($descriptor != '') {
                $descriptor = trim(mb_strtolower($descriptor));
                //$descriptor = preg_replace('/\s*/m', '', $descriptor);
                $bookDescriptString .= '#' . $descriptor . '#';
            }
        }

        if (!ModUtil::apiFunc('Books', 'user', 'editBook', array('bookId' => $book['bookId'],
                    'items' => array('newBookAdminName' => $newBookAdminName,
                        'bookAdminName' => $bookAdminName,
                        'bookTitle' => $bookTitle,
                        'bookLang' => $bookLang,
                        'theme' => $theme,
                        'bookDescript' => $bookDescriptString,
                        'collectionId' => $bookCollection)))) {
            return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("S'ha produït un error en editar el llibre."),
                        'title' => $this->__('Edita el llibre'),
                        'result' => 0));
        }

// XTEC *********** AFEGIT -> Manage descriptors when save / edit books
// 2012.02.24 @mmartinez

        if (!ModUtil::apiFunc('Books', 'user', 'updateDescriptors', array('oldValue' => $book['bookDescript'],
                    'newValue' => $bookDescriptString))) {
            return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("S'ha produït un error en editar els descriptors del llibre."),
                        'title' => $this->__('Edita el llibre'),
                        'result' => 0));
        }
// *********** FI
        // edit the book settings
        if (!ModUtil::apiFunc('Books', 'user', 'editBookSettings', array('bookId' => $book['bookId'],
                    'site_title' => $bookTitle,
                    'opentext' => $opentext,
                    'lang' => $bookLang,
                    'theme' => $theme,
                    'myname' => $myname,
                    'mypass' => $mypass))) {
            LogUtil::registerError($this->__("S'ha produït un error en editar les característiques del llibre."));
        }
        // if the book administrator changes the new administrator must accept the book administration. Meanwhile the book has not administrator so it is not accessible
        if ($sendConfirmationMsg) {
            LogUtil::registerStatus($this->__("L'edició del llibre no estarà disponible fins que la persona a qui se n'ha assignat l'administració confimi que vol ser-ne l'administrador/a. Ho pot fer des de la mateixa Prestatgeria. Quan s'hi identifiqui rebrà un avís d'assignació."));
            //send mail to user
            //Check if module Mailer is active
            $modid = ModUtil::getIdFromName('Mailer');
            $modinfo = ModUtil::getInfo($modid);
            //if it is active
            if ($modinfo['state'] == 3) {
                $view = Zikula_View::getInstance('Books', false);
                $school = ModUtil::apiFunc('Books', 'user', 'getSchool', array('schoolCode' => $book['schoolCode']));
                $book = array('bookTitle' => $bookTitle,
                    'schoolType' => $school[0]['schoolType'],
                    'schoolName' => $school[0]['schoolName'],
                    'schoolCode' => $school[0]['schoolCode'],
                    'bookId' => $bookId);
                $view->assign('book', $book);
                $view->assign('bookSoftwareUrl', ModUtil::getVar('Books', 'bookSoftwareUrl'));
                $sendResult = ModUtil::apiFunc('Mailer', 'user', 'sendmessage', array('toname' => $oBookAdminName,
                            'toaddress' => $oBookAdminName . ModUtil::getVar('Books', 'mailDomServer'),
                            'subject' => $this->__("Se t'ha l'administració d'un llibre que has d'acceptar"),
                            'body' => $view->fetch('books_user_newEditBookMail.tpl'),
                            'html' => 1));
            }
        }
        // the book has been edited successfuly
        // return user to previous page
        return ModUtil::func('Books', 'user', 'displayMsg', array('msg' => $this->__("El llibre s'ha editat correctament."),
                    'title' => $this->__('Edita el llibre'),
                    'result' => 1,
                    'returnURL' => $returnURL));
    }

    /**
     * exports a book as zip file with html structure and offers to the user the opportunity to download it
     * @author:	Francesc Bassas i Bullich
     * @param:	$args	array with the bookId
     * @return:	output	force download
     */
    public function getHtmlBook($args) {
        // bookId
        $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'GET');

        // argument check
        if ($bookId == null || !is_numeric($bookId)) {
            return LogUtil::registerError(_MODARGSERROR);
        }

        // security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }

        // checks if the user can export the book
        if (!ModUtil::apiFunc('Books', 'user', 'canExport', array('bookId' => $bookId))) {
            return LogUtil::registerPermissionError();
        }

        Loader::RequireOnce("modules/Books/includes/Book.php");

        $book = ModUtil::apiFunc('Books', 'user', 'getBookById', array('bookId' => $bookId));

        if (!$book)
            return LogUtil::registerError($this->__("No s'ha pogut exportar el llibre"));

        $bookSoftwareUri = ModUtil::getVar('Books', 'bookSoftwareUri');

        $book->replaceImageFolder($bookSoftwareUri . '/centres/' . $book->getSchoolCode() . '_' . $book->getBookId() . '/', 'book_images/');

        // save the book as html structure
        global $ZConfig;
        $html_dir = $ZConfig['System']['temp'] . '/books/export/html/' . 'llibre.html' . $bookId . '/'; // 'book.html'
        $book->book2html($html_dir);

        $filepath = $ZConfig['System']['temp'] . '/books/export/html/' . 'llibre.html.' . $bookId . '.zip'; // 'book.html'

        Loader::RequireOnce("modules/Books/includes/pclzip.lib.php");
        $file = new PclZip($filepath);
        $v_list = $file->create($html_dir, PCLZIP_OPT_REMOVE_PATH, $html_dir, PCLZIP_OPT_ADD_PATH, 'llibre.html'); // 'book.html'
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
        System::shutdown();
    }

    /**
     * exports a book as zip file with html structure and offers to the user the opportunity to download it
     * @author:	Francesc Bassas i Bullich
     * @param:	$args	array with the bookId
     * @return:	output	force download
     */
    public function getEpubBook($args) {
        // bookId
        $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'GET');

        // argument check
        if ($bookId == null || !is_numeric($bookId)) {
            return LogUtil::registerError(_MODARGSERROR);
        }

        // security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }

        // checks if the user can export the book
        if (!ModUtil::apiFunc('Books', 'user', 'canExport', array('bookId' => $bookId))) {
            return LogUtil::registerPermissionError();
        }

        Loader::RequireOnce("modules/Books/includes/Book.php");

        $book = ModUtil::apiFunc('Books', 'user', 'getBookById', array('bookId' => $bookId));

        if (!$book)
            return LogUtil::registerError($this->__("No s'ha pogut exportar el llibre"));

        $bookSoftwareUri = ModUtil::getVar('Books', 'bookSoftwareUri');

        $book->replaceImageFolder($bookSoftwareUri . '/centres/' . $book->getSchoolCode() . '_' . $book->getBookId() . '/', 'images/');

        // save the book as epub file	
        global $ZConfig;
        $epub_dir = substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/') + 1) . $ZConfig['System']['temp'] . '/books/export/epub/' . 'book' . $bookId . '/';
        $filepath = $book->book2epub($epub_dir);
        $filename = basename($filepath);

        header('Content-Description: File Transfer');
        header('Content-Type: application/zip');
        header('Content-Transfer-Encoding: binary');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);

        Loader::loadClass('FileUtil');
        FileUtil::deldir($ZConfig['System']['temp'] . '/books/export/epub/' . 'book' . $bookId . '/');

        // halts execution
        System::shutdown();
    }

    /**
     * exports a book as SCORM package and offers to the user the opportunity to download it
     * @author:	Francesc Bassas i Bullich
     * @param:	$args	array with the bookId
     * @return:	output	force download
     */
    public function getScormBook($args) {
        // bookId
        $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'GET');

        // argument check
        if ($bookId == null || !is_numeric($bookId)) {
            return LogUtil::registerError(_MODARGSERROR);
        }

        // security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }

        // checks if the user can export the book
        if (!ModUtil::apiFunc('Books', 'user', 'canExport', array('bookId' => $bookId))) {
            return LogUtil::registerPermissionError();
        }

        Loader::RequireOnce("modules/Books/includes/Book.php");

        $book = ModUtil::apiFunc('Books', 'user', 'getBookById', array('bookId' => $bookId));

        if (!$book)
            return LogUtil::registerError($this->__("No s'ha pogut exportar el llibre"));

        $bookSoftwareUri = ModUtil::getVar('Books', 'bookSoftwareUri');

        $book->replaceImageFolder($bookSoftwareUri . '/centres/' . $book->getSchoolCode() . '_' . $book->getBookId() . '/', 'book_images/');

        global $ZConfig;
        $filepath = $ZConfig['System']['temp'] . '/books/export/scorm/';

        $filename = 'scorm_book' . $bookId . '.zip';

        $book->book2scorm($filepath, $filename);

        header('Content-Description: File Transfer');
        header('Content-Type: application/zip');
        header('Content-Transfer-Encoding: binary');
        header('Content-Disposition: attachment; filename=' . 'llibre.scorm.zip');
        header('Content-Length: ' . filesize($filepath . $filename));
        readfile($filepath . $filename);

        unlink($filepath . $filename);

        // halts execution
        System::shutdown();
    }

    /**
     * exports a book as zip file with xml structure and offers to the user the opportunity to download it
     * @author:	Francesc Bassas i Bullich
     * @param:	$args	array with the bookId
     * @return:	output	force download
     */
    public function exportBook($args) {
        // bookId
        $bookId = FormUtil::getPassedValue('bookId', isset($args['bookId']) ? $args['bookId'] : null, 'GET');

        // argument check
        if ($bookId == null || !is_numeric($bookId)) {
            return LogUtil::registerError(_MODARGSERROR);
        }

        // security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }

        // checks if the user can export the book
        if (!ModUtil::apiFunc('Books', 'user', 'canExport', array('bookId' => $bookId))) {
            return LogUtil::registerPermissionError();
        }

        Loader::RequireOnce('modules/Books/includes/Book.php');

        $book = ModUtil::apiFunc('Books', 'user', 'getBookById', array('bookId' => $bookId));

        if (!book)
            return LogUtil::registerError($this->__("No s'ha pogut exportar el llibre"));

        $bookSoftwareUri = ModUtil::getVar('Books', 'bookSoftwareUri');

        $book->replaceImageFolder($bookSoftwareUri . '/centres/' . $book->getSchoolCode() . '_' . $book->getBookId() . '/', '/book_images/');

        global $ZConfig;
        $path = $ZConfig['System']['temp'] . '/books/export/xml/' . $bookId . '/';

        mkdir($path);
        chmod($path, 0777);

        if (!$book->book2xml($path . 'book.xml')) {
            return LogUtil::registerError($this->__("No s'ha pogut exportar el llibre"));
        }

        Loader::RequireOnce('modules/Books/includes/utils.php');

        copydir(ModUtil::getVar('Books', 'serverImageFolder') . '/' . $book->getSchoolCode() . '_' . $book->getBookId(), $path . 'book_images');

        Loader::RequireOnce("modules/Books/includes/pclzip.lib.php");
        $filepath = $ZConfig['System']['temp'] . '/books/export/xml/' . $bookId . '.zip';
        $file = new PclZip($filepath);
        $v_list = $file->create($path, PCLZIP_OPT_REMOVE_PATH, $path);

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
        System::shutdown();
    }

    /**
     * imports a book from a zip file with xml structure
     * @author:	Francesc Bassas i Bullich
     * @param:	$args	array with the path to the file to import, the schoolCode, the username and the password
     * @return:	output	main site
     */
    public function importBook($args) {
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

        // security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }

        // checks if the user can import a book
        if (!ModUtil::apiFunc('Books', 'user', 'canImport', array('schoolCode' => $schoolCode))) {
            return LogUtil::registerError($this->__('No teniu permís per importar el llibre.'));
        }

        Loader::RequireOnce("modules/Books/includes/pclzip.lib.php");

        global $ZConfig;
        $tmp = $ZConfig['System']['temp'] . '/books/import/' . time();

        $file = new PclZip($filename);
        if ($file->extract(PCLZIP_OPT_PATH, $tmp) == 0) {
            return LogUtil::registerError($file->errorInfo(true));
        }

        unlink($filename);

        Loader::RequireOnce("modules/Books/includes/Book.php");

        // loads the xml file to the book object
        $book = Book::xml2book($tmp . '/book.xml');

        if (!$book) {
            return LogUtil::registerError($this->__("S'ha produït un error en importar el llibre."));
        }

        if (!$bookId = ModUtil::apiFunc('Books', 'user', 'insertBookRow', array('book' => $book,
                    'schoolCode' => $schoolCode,
                    'username' => $username,
                    'bookCollection' => $bookCollection))) {
            LogUtil::registerError($this->__("S'ha produït un error en importar el llibre."));
        }

        $book->replaceImageFolder('/book_images/', ModUtil::getVar('Books', 'bookSoftwareUri') . '/centres/' . $schoolCode . '_' . $bookId . '/');

        if (!ModUtil::apiFunc('Books', 'user', 'insertBookTables', array('book' => $book, 'schoolCode' => $schoolCode, 'bookId' => $bookId, 'username' => $username))) {
            LogUtil::registerError($this->__("S'ha produït un error en importar el llibre."));
        }

        ModUtil::apiFunc('Books', 'user', 'changeURLImageFolder', array('bookId' => $bookId, 'schoolCode' => $schoolCode));

        // import book images
        Loader::RequireOnce('modules/Books/includes/utils.php');

        copydir($tmp . '/book_images', ModUtil::getVar('Books', 'serverImageFolder') . '/' . $schoolCode . '_' . $bookId);

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
    public function getRss($args) {
        // bookId
        $fisbn = FormUtil::getPassedValue('fisbn', isset($args['fisbn']) ? $args['fisbn'] : null, 'GET');
        // security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }
        include_once('../config/xtecAPI.php');
        generateRss($fisbn);
        return System::redirect('../rss/' . $fisbn . '.xml');
    }

    /**
     * Displays an informative page about the results obtained after create a new book
     * @author:   Albert Pérez Monfort (aperezm@xtec.cat)
     * @return:	The book information and information about the creation process
     */
    public function displayMsg($args) {
        $result = FormUtil::getPassedValue('result', isset($args['result']) ? $args['result'] : null, 'POST');
        $msg = FormUtil::getPassedValue('msg', isset($args['msg']) ? $args['msg'] : null, 'POST');
        $title = FormUtil::getPassedValue('title', isset($args['title']) ? $args['title'] : null, 'POST');
        $returnURL = FormUtil::getPassedValue('returnURL', isset($args['returnURL']) ? $args['returnURL'] : 'index.php', 'POST');
        // create output object
        return $this->view->assign('result', $result)
                        ->assign('msg', $msg)
                        ->assign('title', $title)
                        ->assign('returnURL', $returnURL)
                        ->fetch('books_user_bookMsg.tpl');
    }

}