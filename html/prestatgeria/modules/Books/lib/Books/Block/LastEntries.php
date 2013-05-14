<?php

class Books_Block_LastEntries extends Zikula_Controller_AbstractBlock {

    public function init() {
        SecurityUtil::registerPermissionSchema("Books:lastentriesblock:", "Block title::");
    }

    public function info() {
        return array('text_type' => 'LastEntries',
            'module' => 'Books',
            'text_type_long' => $this->__('Mostra els llibre que tenen entrades més recents'),
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
        if (!SecurityUtil::checkPermission("Books:lastentriesblock:", $blockinfo['title'] . "::", ACCESS_READ)) {
            return;
        }

        // Check if the module is available
        if (!ModUtil::available('Books'))
            return;

        $books = ModUtil::apiFunc('Books', 'user', 'getAllBooks', array('init' => 0,
                    'ipp' => 5,
                    'notJoin' => 1));
        foreach ($books as $book)
            $booksArray[] = array('bookPages' => $book['bookPages'],
                'bookTitle' => $book['bookTitle'],
                'bookId' => $book['bookId']);

        // Create output object
        $view = Zikula_View::getInstance('Books', false);
        $view->assign('books', $booksArray);

        $s = $view->fetch('books_block_lastEntries.tpl');

        // Populate block info and pass to theme
        $blockinfo['content'] = $s;

        return BlockUtil::themesideblock($blockinfo);
    }

}