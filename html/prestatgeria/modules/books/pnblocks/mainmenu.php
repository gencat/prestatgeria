<?php
function books_mainmenublock_init()
{
    pnSecAddSchema("books:mainmenublock:", "Block title::");
}

function books_mainmenublock_info()
{
	
	$dom = ZLanguage::getModuleDomain('Books');
	
    return array('text_type' => 'mainMenu',
					'module' => 'books',
					'text_type_long' => __('Menú principal de navegació',$dom),
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
function books_mainmenublock_display($blockinfo)
{
	// Security check
	if (!pnSecAuthAction(0, "books:mainmenublock:", $blockinfo['title']."::", ACCESS_READ)) { 
		return; 
	} 
	// Check if the module is available
	if(!pnModAvailable('books')){
		return;
	}
    if(pnUserLogin()){
    	setcookie('zkllibres',$GLOBALS['_PNSession']['obj']['sessid'],0,'/');
    }
	$pnRender = pnRender::getInstance('books',false);

	//Check if user can create books
	$creator = pnModFunc('books', 'user', 'canCreate', array('userName' => pnUserGetVar('uname')));
		
	if ($creator != '') {
		$pnRender -> assign('canAdd', true);
	}

	//Check if user can create books
	if ($creator == pnUserGetVar('uname') && pnUserGetVar('uname') != '') {
		$pnRender -> assign('canAdminCreateBooks', true);
	}

	//Check if user is administrator
	if (SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		$pnRender -> assign('canAdmin', true);
	}
    if(pnUserLogin()){
        //check if the user is a school, CRP or something like this
        $uname = str_replace('a','0',pnUserGetVar('uname'));
        $uname = str_replace('b','1',$uname);
        $uname = str_replace('c','2',$uname);
        $uname = str_replace('e','4',$uname);
        $schoolInfo = pnModAPIFunc('books','user','getSchoolInfo', array('schoolCode' => $uname));
        // if user is a school but can create books it can subscribe into the shell
        if($schoolInfo && !$creator){
            $pnRender -> assign('mustInscribe', true);
        }
    }
    
	$pnRender -> assign('bookSoftwareUrl', pnModGetVar('books', 'bookSoftwareUrl'));
	
	$s = $pnRender -> fetch('books_block_menu.htm');

	// Populate block info and pass to theme
	$blockinfo['content'] = $s;

	return themesideblock($blockinfo);
}
