<?php
function books_admin_main($args){
	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	// Create output object
	$pnRender = pnRender::getInstance('books',false);
	return $pnRender->fetch('books_admin_main.htm');
}

function books_admin_config($args){
	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$pnRender = pnRender::getInstance('books',false);
	$pnRender->assign('canCreateToOthers', pnModGetVar('books','canCreateToOthers'));
	$pnRender->assign('mailDomServer', pnModGetVar('books','mailDomServer'));
	$pnRender->assign('bookSoftwareUrl', pnModGetVar('books','bookSoftwareUrl'));
	$pnRender->assign('bookSoftwareUri', pnModGetVar('books','bookSoftwareUri'));
	$pnRender->assign('booksDatabase', pnModGetVar('books','booksDatabase'));
	$pnRender->assign('serverImageFolder', pnModGetVar('books','serverImageFolder'));
	return $pnRender->fetch('books_admin_config.htm');
}

function books_admin_update_conf($args){
	
	$dom = ZLanguage::getThemeDomain('Books');
	
	$canCreateToOthers = FormUtil::getPassedValue('canCreateToOthers', isset($args['canCreateToOthers']) ? $args['canCreateToOthers'] : null, 'POST');
	$mailDomServer = FormUtil::getPassedValue('mailDomServer', isset($args['mailDomServer']) ? $args['mailDomServer'] : null, 'POST');
	$bookSoftwareUrl = FormUtil::getPassedValue('bookSoftwareUrl', isset($args['bookSoftwareUrl']) ? $args['bookSoftwareUrl'] : null, 'POST');
	$bookSoftwareUri = FormUtil::getPassedValue('bookSoftwareUri', isset($args['bookSoftwareUri']) ? $args['bookSoftwareUri'] : null, 'POST');
	$booksDatabase = FormUtil::getPassedValue('booksDatabase', isset($args['booksDatabase']) ? $args['booksDatabase'] : null, 'POST');
	$serverImageFolder = FormUtil::getPassedValue('serverImageFolder', isset($args['serverImageFolder']) ? $args['serverImageFolder'] : null, 'POST');
	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
    // confirm authorisation code
    if (!SecurityUtil::confirmAuthKey()) {
        return LogUtil::registerAuthidError (pnModURL('books', 'admin', 'config'));
    }
    LogUtil::registerStatus (__('La configuració ha estat modificada',$dom));
	pnModSetVar('books','canCreateToOthers', $canCreateToOthers);
	pnModSetVar('books','mailDomServer', $mailDomServer);
	pnModSetVar('books','bookSoftwareUrl', $bookSoftwareUrl);
	pnModSetVar('books','bookSoftwareUri', $bookSoftwareUri);
	pnModSetVar('books','booksDatabase', $booksDatabase);
	pnModSetVar('books','serverImageFolder', $serverImageFolder);
	return pnRedirect(pnModURL('books', 'admin', 'config'));
}
function books_admin_manageDescriptors(){
	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$descriptors = pnModAPIFunc('books', 'user', 'getAllDescriptors', array('order' => 'descriptor'));
	$pnRender = pnRender::getInstance('books',false);
	$pnRender->assign('descriptors', $descriptors);
	return $pnRender->fetch('books_admin_manageDescriptors.htm');
}
function books_admin_descriptorRowContent($args){
	$did = FormUtil::getPassedValue('did', isset($args['did']) ? $args['did'] : null, 'POST');
	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$descriptor = pnModAPIFunc('books', 'user', 'getDescriptor', array('did' => $did));
	$pnRender = pnRender::getInstance('books',false);
	$pnRender->assign('descriptor', $descriptor);
	return $pnRender->fetch('books_admin_descriptorRowContent.htm');
}

function books_admin_purge(){
	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	// get all descriptors
	$descriptors = pnModAPIFunc('books', 'user', 'getAllDescriptors', array('order' => 'descriptor'));
	foreach($descriptors as $descriptor){
		// recalc descriptors number
		$number = pnModAPIFunc('books', 'user', 'getAllBooks', array('init' => 0,
																		'rpp' => 1,
																		'notJoin' => 1,
																		'filter' => 'descriptor',
																		'onlyNumber' => 1,
																		'filterValue' => $descriptor['descriptor']));
		if($number == 0){
			// delete descriptor
			pnModAPIFunc('books','admin','deleteDescriptor', array('did' => $descriptor['did']));
		}
	}
	return pnRedirect(pnModURL('books', 'admin', 'manageDescriptors'));
}

function books_admin_schoolsList($args){
	$schoolsInfo = FormUtil::getPassedValue('schoolsInfo', isset($args['schoolsInfo']) ? $args['schoolsInfo'] : 0, 'GET');
	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	$schools = pnModAPIFunc('books', 'admin', 'getAllSchoolInfo', array('schoolsInfo' => $schoolsInfo));

	$pnRender = pnRender::getInstance('books',false);
	$pnRender->assign('schools', $schools);
	return $pnRender->fetch('books_admin_schoolsList.htm');
}

function books_admin_newSchool(){
	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}
	
	$pnRender = pnRender::getInstance('books',false);
	return $pnRender->fetch('books_admin_newSchool.htm');
}

function books_admin_createSchool($args){
	$schoolCode = FormUtil::getPassedValue('schoolCode', isset($args['schoolCode']) ? $args['schoolCode'] : null, 'POST');
	$schoolType = FormUtil::getPassedValue('schoolType', isset($args['schoolType']) ? $args['schoolType'] : null, 'POST');
	$schoolName = FormUtil::getPassedValue('schoolName', isset($args['schoolName']) ? $args['schoolName'] : null, 'POST');
	$schoolCity = FormUtil::getPassedValue('schoolCity', isset($args['schoolCity']) ? $args['schoolCity'] : null, 'POST');
	$schoolZipCode = FormUtil::getPassedValue('schoolZipCode', isset($args['schoolZipCode']) ? $args['schoolZipCode'] : null, 'POST');
	$schoolRegion = FormUtil::getPassedValue('schoolRegion', isset($args['schoolRegion']) ? $args['schoolRegion'] : null, 'POST');

	// Security check
	if (!SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		return LogUtil::registerError(_MODULENOAUTH, 403);
	}

	$created = pnModAPIFunc('books', 'admin', 'createSchool', array('schoolCode' => $schoolCode,
				'schoolType' => $schoolType,
				'schoolName' => $schoolName,
				'schoolCity' => $schoolCity,
				'schoolZipCode' => $schoolZipCode,
				'schoolRegion' => $schoolRegion,
				));
	if (!$created) {
		LogUtil::registerError (__('S\'ha produït un error en la creació del centre.', $dom));
		return pnRedirect(pnModURL('books', 'admin', 'schoolsList'));
	}

	LogUtil::registerStatus (__('El centre ha estat creat correctament.', $dom));
	return pnRedirect(pnModURL('books', 'admin', 'schoolsList'));
}



