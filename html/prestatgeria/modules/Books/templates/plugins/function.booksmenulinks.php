<?php
function smarty_function_booksmenulinks()
{
	$dom = ZLanguage::getModuleDomain('Books');
	
	// set some defaults
	if (!isset($params['start'])) {
		$params['start'] = '[';
	}
	if (!isset($params['end'])) {
		$params['end'] = ']';
	}
	if (!isset($params['seperator'])) {
		$params['seperator'] = '|';
	}
	if (!isset($params['class'])) {
		$params['class'] = 'z-menuitem-title';
	}

	$booksmenulinks = "<span class=\"" . $params['class'] . "\">" . $params['start'] . " ";

	if (SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
		$booksmenulinks .= " <a href=\"" . DataUtil::formatForDisplayHTML(ModUtil::url('books', 'admin', 'manageDescriptors')) . "\">" . __('Administra els descriptors',$dom) . "</a> " . $params['seperator'];
		$booksmenulinks .= " <a href=\"" . DataUtil::formatForDisplayHTML(ModUtil::url('books', 'admin', 'schoolsList', array('schoolsInfo' => 0))) . "\">" . __('Llista de centres',$dom) . "</a> " . $params['seperator'];
		$booksmenulinks .= " <a href=\"" . DataUtil::formatForDisplayHTML(ModUtil::url('books', 'admin', 'schoolsList', array('schoolsInfo' => 1))) . "\">" . __('Informació de centres',$dom) . "</a> " . $params['seperator'];
		$booksmenulinks .= " <a href=\"" . DataUtil::formatForDisplayHTML(ModUtil::url('books', 'admin', 'newSchool')) . "\">" . __('Crea un centre',$dom) . "</a> " . $params['seperator'];
		$booksmenulinks .= " <a href=\"" . DataUtil::formatForDisplayHTML(ModUtil::url('books', 'admin', 'config')) . "\">" . __('Configura el mòdul',$dom) . "</a> ";
	}

	$booksmenulinks .= $params['end'] . "</span>\n";

	return $booksmenulinks;
}
