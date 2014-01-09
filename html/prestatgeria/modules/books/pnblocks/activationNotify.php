<?php
function books_activationnotifyblock_init()
{
    pnSecAddSchema("books:activationnotifyblock:", "Block title::");
}

function books_activationnotifyblock_info()
{
	
	$dom = ZLanguage::getModuleDomain('Books');
	
    return array('text_type' => 'activationNotify',
					'module' => 'books',
					'text_type_long' => __("Bloc per a l'activació de llibres",$dom),
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
function books_activationnotifyblock_display($blockinfo)
{
	// Security check
	if (!pnSecAuthAction(0, "books:activationnotifyblock:", $blockinfo['title']."::", ACCESS_READ)) { 
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
	pnModAPIFunc('books', 'user', 'deletedNotActived', array('days' => 15));
	$books = pnModAPIFunc('books','user','getAllBooks', array('init' => 0,
																'ipp' => 5,
																'order' => 'bookHits',
																'filter' => 'userBooks',
																'filterValue' => pnUserGetVar('uname'),
																'bookState' => '-1',
                                                                'acceptEdit' => 1));
	if(!$books){
		return false;
	}
	// Create output object
	$pnRender = pnRender::getInstance('books',false);
	$pnRender -> assign('books', $books);
	$pnRender -> assign('bookSoftwareUrl', pnModGetVar('books', 'bookSoftwareUrl'));
	$s = $pnRender -> fetch('books_block_activationNotify.htm');
	// Populate block info and pass to theme
	$blockinfo['content'] = $s;
	return themesideblock($blockinfo);
}
