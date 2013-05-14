<?php

class Books_Block_MostReaded extends Zikula_Controller_AbstractBlock {

    public function init() {
        SecurityUtil::registerPermissionSchema("Books:mostreadedblock:", "Block title::");
    }

    public function info() {
        return array('text_type' => 'MostReaded',
            'module' => 'Books',
            'text_type_long' => $this->__('Mostra els llibres més llegits'),
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
        if (!SecurityUtil::checkPermission("Books:mostreadedblock:", $blockinfo['title'] . "::", ACCESS_READ)) {
            return;
        }

        // Check if the module is available
        if (!ModUtil::available('Books'))
            return;

        $books = ModUtil::apiFunc('Books', 'user', 'getAllBooks', array('init' => 0,
                    'ipp' => 5,
                    'order' => 'bookHits',
                    'notJoin' => 1));
        
        foreach ($books as $book) {
            $booksArray[] = array('bookHits' => $book['bookHits'],
                'bookTitle' => $book['bookTitle'],
                'bookId' => $book['bookId']);
        }

        // Create output object
        $view = Zikula_View::getInstance('Books', false);
        $view->assign('books', $booksArray);

        $s = $view->fetch('books_block_mostReaded.tpl');

        // Populate block info and pass to theme
        $blockinfo['content'] = $s;

        return BlockUtil::themesideblock($blockinfo);
    }

}