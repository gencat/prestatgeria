<?php

class Books_Block_ActivationNotify extends Zikula_Controller_AbstractBlock {

    public function init() {
        SecurityUtil::registerPermissionSchema("Books:activationnotifyblock:", "Block title::");
    }

    public function info() {
        return array('text_type' => 'ActivationNotify',
            'module' => 'Books',
            'text_type_long' => $this->__("Bloc per a l'activació de llibres"),
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
        if (!SecurityUtil::checkPermission("Books:activationnotifyblock:", $blockinfo['title'] . "::", ACCESS_READ)) {
            return;
        }
        // Check if the module is available
        if (!ModUtil::available('Books'))
            return;

        // Check if the user is logged in
        if (!UserUtil::isLoggedIn())
            return;

        ModUtil::apiFunc('Books', 'user', 'deletedNotActived', array('days' => 15));
        $books = ModUtil::apiFunc('Books', 'user', 'getAllBooks', array('init' => 0,
                    'ipp' => 5,
                    'order' => 'bookHits',
                    'filter' => 'userBooks',
                    'filterValue' => UserUtil::getVar('uname'),
                    'bookState' => '-1',
                    'acceptEdit' => 1));
        if (!$books)
            return false;

        // Create output object
        $view = Zikula_View::getInstance('Books', false);
        $view->assign('books', $books);
        $view->assign('bookSoftwareUrl', ModUtil::getVar('Books', 'bookSoftwareUrl'));
        $s = $view->fetch('books_block_activationNotify.tpl');
        // Populate block info and pass to theme
        $blockinfo['content'] = $s;
        return BlockUtil::themesideblock($blockinfo);
    }

}