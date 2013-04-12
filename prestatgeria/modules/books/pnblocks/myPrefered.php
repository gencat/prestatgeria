<?php
function books_mypreferedblock_init()
{
    pnSecAddSchema("books:mypreferedblock:", "Block title::");
}

function books_mypreferedblock_info()
{
	$dom = ZLanguage::getModuleDomain('Books');
	
    return array('text_type' => 'myPrefered',
					'module' => 'books',
					'text_type_long' => __("Mostra els llibres preferits de l'usuari/ària",$dom),
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
function books_mypreferedblock_display($blockinfo)
{
	// Security check
	if (!pnSecAuthAction(0, "books:mypreferedblock:", $blockinfo['title']."::", ACCESS_READ)) { 
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

	$prefered = pnModAPIFunc('books', 'user', 'getPrefered');

	if($prefered){
		$books = pnModAPIFunc('books','user','getAllBooks', array('init' => 0,
																	'ipp' => 1000000,
																	'order' => 'bookHits',
																	'filter' => 'prefered',
																	'filterValue' => $prefered,
																	'notJoin' => 1));

		foreach($books as $book){
			$booksArray[] = array('bookTitle' => $book['bookTitle'],
							'bookId' => $book['bookId']);
		}
	}

	// Create output object
	$pnRender = pnRender::getInstance('books',false);
	$pnRender -> assign('books',$booksArray);

	$s = $pnRender -> fetch('books_block_myPrefered.htm');

	// Populate block info and pass to theme
	$blockinfo['content'] = $s;

	return themesideblock($blockinfo);
}
