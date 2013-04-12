<?php
function books_mybooksblock_init()
{
    pnSecAddSchema("books:mybooksblock:", "Block title::");
}

function books_mybooksblock_info()
{
	$dom = ZLanguage::getModuleDomain('Books');
	
    return array('text_type' => 'myBooks',
					'module' => 'books',
					'text_type_long' => __("Mostra els llibres de l'usuari/ària",$dom),
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
function books_mybooksblock_display($blockinfo)
{
	// Security check
	if (!pnSecAuthAction(0, "books:mybooksblock:", $blockinfo['title']."::", ACCESS_READ)) { 
		return; 
	} 

	// Check if the module is available
	if(!pnModAvailable('books')){
		return;
	}

	// Check if the user is logged in
	if(!pnUserLogin()){
		return;
	}

	$books = pnModAPIFunc('books','user','getAllBooks', array('init' => 0,
																'ipp' => 500,
																'order' => 'bookHits',
																'filter' => 'userBooks',
																'filterValue' => pnUserGetVar('uname'),
																'notJoin' => 1));

	// Check if the user is logged in
	if(!$books){
		return;
	}

	foreach($books as $book){
		$booksArray[] = array('bookTitle' => $book['bookTitle'],
						'bookId' => $book['bookId']);
	}

	// Create output object
	$pnRender = pnRender::getInstance('books',false);
	$pnRender -> assign('books',$booksArray);

	$s = $pnRender -> fetch('books_block_myBooks.htm');

	// Populate block info and pass to theme
	$blockinfo['content'] = $s;

	return themesideblock($blockinfo);
}
