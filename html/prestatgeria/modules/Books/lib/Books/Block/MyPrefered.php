<?php

class Books_Block_MyPrefered extends Zikula_Controller_AbstractBlock {

    public function init() {
        SecurityUtil::registerPermissionSchema("Books:mypreferedblock:", "Block title::");
    }

    public function info() {
        return array('text_type' => 'MyPrefered',
            'module' => 'Books',
            'text_type_long' => $this->__("Mostra els llibres preferits de l'usuari/ària"),
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
        if (!SecurityUtil::checkPermission("Books:mypreferedblock:", $blockinfo['title'] . "::", ACCESS_READ)) {
            return;
        }

        // Check if the module is available
        if (!ModUtil::available('Books'))
            return;

        // Check if the user is logged in
        if (!UserUtil::isLoggedIn())
            return;
        
        $booksArray = array();

        $prefered = ModUtil::apiFunc('Books', 'user', 'getPrefered');

        if ($prefered) {
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
        }

        // Create output object
        $view = Zikula_View::getInstance('Books', false);
        $view->assign('books', $booksArray);

        $s = $view->fetch('books_block_myPrefered.tpl');

        // Populate block info and pass to theme
        $blockinfo['content'] = $s;

        return BlockUtil::themesideblock($blockinfo);
    }

}