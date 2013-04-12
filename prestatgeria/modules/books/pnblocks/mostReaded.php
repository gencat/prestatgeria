<?php
function books_mostreadedblock_init()
{
    pnSecAddSchema("books:mostreadedblock:", "Block title::");
}

function books_mostreadedblock_info()
{
	$dom = ZLanguage::getModuleDomain('Books');
	
    return array('text_type' => 'mostReaded',
					'module' => 'books',
					'text_type_long' => __('Mostra els llibres més llegits',$dom),
					'allow_multiple' => true,
					'form_content' => false,
					'form_refresh' => false,
					'show_preview' => true );
}

/**
 * Show the list of forms for choosed categories
 * @autor:	Albert Pérez Monfort
 * return:	The list of forms
*/
function books_mostreadedblock_display($blockinfo)
{
	// Security check
	if (!pnSecAuthAction(0, "books:mostreadedblock:", $blockinfo['title']."::", ACCESS_READ)) { 
		return; 
	} 

	// Check if the module is available
	if(!pnModAvailable('books')){
		return;
	}

	$books = pnModAPIFunc('books','user','getAllBooks', array('init' => 0,
										'ipp' => 5,
										'order' => 'bookHits',
										'notJoin' => 1));
	foreach($books as $book){
		$booksArray[] = array('bookHits' => $book['bookHits'],
						'bookTitle' => $book['bookTitle'],
						'bookId' => $book['bookId']);
	}

	// Create output object
	$pnRender = pnRender::getInstance('books',false);
	$pnRender -> assign('books',$booksArray);

	$s = $pnRender -> fetch('books_block_mostReaded.htm');

	// Populate block info and pass to theme
	$blockinfo['content'] = $s;

	return themesideblock($blockinfo);
}
