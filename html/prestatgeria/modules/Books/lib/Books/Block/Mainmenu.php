<?php

class Books_Block_Mainmenu extends Zikula_Controller_AbstractBlock {

    public function init() {
        SecurityUtil::registerPermissionSchema("Books:mainmenublock:", "Block title::");
    }

    function info() {
        return array('text_type' => 'MainMenu',
            'module' => 'Books',
            'text_type_long' => $this->__('Menú principal de navegació'),
            'allow_multiple' => true,
            'form_content' => false,
            'form_refresh' => false,
            'show_preview' => true);
    }

    /**
     * Show the list of forms for choosed categories
     * @autor:	Albert Pérez Monfort
     * return:	The list of forms
     */
    public function display($blockinfo) {
        // Security check
        if (!SecurityUtil::checkPermission("Books:mainmenublock:", $blockinfo['title'] . "::", ACCESS_READ)) {
            return;
        }
        // Check if the module is available
        if (!ModUtil::available('Books'))
            return;

        if (UserUtil::isLoggedIn()) {
            setcookie('zkllibres', $GLOBALS['_ZSession']['obj']['sessid'], 0, '/');
        }

        $view = Zikula_View::getInstance('Books', false);

        //Check if user can create books
        $creator = ModUtil::func('Books', 'user', 'canCreate', array('userName' => UserUtil::getVar('uname')));

        $canAdd = false;
        if ($creator != '') {
            $canAdd = true;
        }

        //Check if user can create books
        $canAdminCreateBooks = false;
        if ($creator == UserUtil::getVar('uname') && UserUtil::getVar('uname') != '')
            $canAdminCreateBooks = true;


        //Check if user is administrator
        $canAdmin = false;
        if (SecurityUtil::checkPermission('Books::', "::", ACCESS_ADMIN)) {
            $canAdmin = true;
        }

        $mustInscribe = false;
        if (UserUtil::isLoggedIn()) {
            //check if the user is a school, CRP or something like this
            $uname = str_replace('a', '0', UserUtil::getVar('uname'));
            $uname = str_replace('b', '1', $uname);
            $uname = str_replace('c', '2', $uname);
            $uname = str_replace('e', '4', $uname);
            $schoolInfo = ModUtil::apiFunc('Books', 'user', 'getSchoolInfo', array('schoolCode' => $uname));
            // if user is a school but can create books it can subscribe into the shell
            if ($schoolInfo && !$creator) {
                $mustInscribe = true;
            }
        }

        $view->assign('bookSoftwareUrl', ModUtil::getVar('Books', 'bookSoftwareUrl'));
        $view->assign('canAdd', $canAdd);
        $view->assign('canAdminCreateBooks', $canAdminCreateBooks);
        $view->assign('canAdmin', $canAdmin);
        $view->assign('mustInscribe', $mustInscribe);
        $s = $view->fetch('books_block_menu.tpl');

        // Populate block info and pass to theme
        $blockinfo['content'] = $s;

        return BlockUtil::themesideblock($blockinfo);
    }

}