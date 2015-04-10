<?php

class Books_Controller_Admin extends Zikula_AbstractController {

    protected function postInitialize() {
        // Set caching to false by default.
        $this->view->setCaching(false);
    }

    public function main($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        // Create output object
        return $this->view->fetch('books_admin_main.tpl');
    }

    public function config($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        return $this->view->assign('canCreateToOthers', ModUtil::getVar('Books', 'canCreateToOthers'))
                        ->assign('mailDomServer', ModUtil::getVar('Books', 'mailDomServer'))
                        ->assign('bookSoftwareUrl', ModUtil::getVar('Books', 'bookSoftwareUrl'))
                        ->assign('bookSoftwareUri', ModUtil::getVar('Books', 'bookSoftwareUri'))
                        ->assign('booksDatabase', ModUtil::getVar('Books', 'booksDatabase'))
                        ->assign('serverImageFolder', ModUtil::getVar('Books', 'serverImageFolder'))
                        ->assign('pwd', getcwd())
                        ->fetch('books_admin_config.tpl');
    }

    public function update_conf($args) {
        $canCreateToOthers = FormUtil::getPassedValue('canCreateToOthers', isset($args['canCreateToOthers']) ? $args['canCreateToOthers'] : null, 'POST');
        $mailDomServer = FormUtil::getPassedValue('mailDomServer', isset($args['mailDomServer']) ? $args['mailDomServer'] : null, 'POST');
        $bookSoftwareUrl = FormUtil::getPassedValue('bookSoftwareUrl', isset($args['bookSoftwareUrl']) ? $args['bookSoftwareUrl'] : null, 'POST');
        $bookSoftwareUri = FormUtil::getPassedValue('bookSoftwareUri', isset($args['bookSoftwareUri']) ? $args['bookSoftwareUri'] : null, 'POST');
        $booksDatabase = FormUtil::getPassedValue('booksDatabase', isset($args['booksDatabase']) ? $args['booksDatabase'] : null, 'POST');
        $serverImageFolder = FormUtil::getPassedValue('serverImageFolder', isset($args['serverImageFolder']) ? $args['serverImageFolder'] : null, 'POST');
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }

        // confirm authorisation code
        $this->checkCsrfToken();

        LogUtil::registerStatus($this->__('La configuració ha estat modificada'));
        ModUtil::setVar('Books', 'canCreateToOthers', $canCreateToOthers);
        ModUtil::setVar('Books', 'mailDomServer', $mailDomServer);
        ModUtil::setVar('Books', 'bookSoftwareUrl', $bookSoftwareUrl);
        ModUtil::setVar('Books', 'bookSoftwareUri', $bookSoftwareUri);
        ModUtil::setVar('Books', 'booksDatabase', $booksDatabase);
        ModUtil::setVar('Books', 'serverImageFolder', $serverImageFolder);
        return System::redirect(ModUtil::url('Books', 'admin', 'config'));
    }

    public function manageDescriptors() {
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        $descriptors = ModUtil::apiFunc('Books', 'user', 'getAllDescriptors', array('order' => 'descriptor'));
        return $this->view->assign('descriptors', $descriptors)
                        ->fetch('books_admin_manageDescriptors.tpl');
    }

    public function descriptorRowContent($args) {
        $did = FormUtil::getPassedValue('did', isset($args['did']) ? $args['did'] : null, 'POST');
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        $descriptor = ModUtil::apiFunc('Books', 'user', 'getDescriptor', array('did' => $did));
        return $this->view->assign('descriptor', $descriptor)
                        ->fetch('books_admin_descriptorRowContent.tpl');
    }

    public function purge() {
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        // get all descriptors
        $descriptors = ModUtil::apiFunc('Books', 'user', 'getAllDescriptors', array('order' => 'descriptor'));
        foreach ($descriptors as $descriptor) {
            // recalc descriptors number
            $number = ModUtil::apiFunc('Books', 'user', 'getAllBooks', array('init' => 0,
                        'rpp' => 1,
                        'notJoin' => 1,
                        'filter' => 'descriptor',
                        'onlyNumber' => 1,
                        'filterValue' => $descriptor['descriptor']));
            if ($number == 0) {
                // delete descriptor
                ModUtil::apiFunc('Books', 'admin', 'deleteDescriptor', array('did' => $descriptor['did']));
            }
        }
        return System::redirect(ModUtil::url('Books', 'admin', 'manageDescriptors'));
    }

    public function schoolsList($args) {
        $schoolsInfo = FormUtil::getPassedValue('schoolsInfo', isset($args['schoolsInfo']) ? $args['schoolsInfo'] : 0, 'GET');
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        $schools = ModUtil::apiFunc('Books', 'admin', 'getAllSchoolInfo', array('schoolsInfo' => $schoolsInfo));

        return $this->view->assign('schools', $schools)
                        ->fetch('books_admin_schoolsList.tpl');
    }

    public function newSchool() {
        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }

        return $this->view->fetch('books_admin_newSchool.tpl');
    }

    public function createSchool($args) {
        $schoolCode = FormUtil::getPassedValue('schoolCode', isset($args['schoolCode']) ? $args['schoolCode'] : null, 'POST');
        $schoolType = FormUtil::getPassedValue('schoolType', isset($args['schoolType']) ? $args['schoolType'] : null, 'POST');
        $schoolName = FormUtil::getPassedValue('schoolName', isset($args['schoolName']) ? $args['schoolName'] : null, 'POST');
        $schoolCity = FormUtil::getPassedValue('schoolCity', isset($args['schoolCity']) ? $args['schoolCity'] : null, 'POST');
        $schoolZipCode = FormUtil::getPassedValue('schoolZipCode', isset($args['schoolZipCode']) ? $args['schoolZipCode'] : null, 'POST');
        $schoolRegion = FormUtil::getPassedValue('schoolRegion', isset($args['schoolRegion']) ? $args['schoolRegion'] : null, 'POST');

        // Security check
        if (!SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }

        $created = ModUtil::apiFunc('Books', 'admin', 'createSchool', array('schoolCode' => $schoolCode,
                    'schoolType' => $schoolType,
                    'schoolName' => $schoolName,
                    'schoolCity' => $schoolCity,
                    'schoolZipCode' => $schoolZipCode,
                    'schoolRegion' => $schoolRegion,
                ));
        if (!$created) {
            LogUtil::registerError($this->__('S\'ha produït un error en la creació del centre.'));
            return System::redirect(ModUtil::url('Books', 'admin', 'schoolsList'));
        }

        LogUtil::registerStatus($this->__('El centre ha estat creat correctament.'));
        return System::redirect(ModUtil::url('Books', 'admin', 'schoolsList'));
    }

}