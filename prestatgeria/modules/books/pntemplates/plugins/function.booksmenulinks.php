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
		$params['class'] = 'pn-menuitem-title';
	}

	$booksmenulinks = "<span class=\"" . $params['class'] . "\">" . $params['start'] . " ";

	if (SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
//		$booksmenulinks .= "<a href=\"" . DataUtil::formatForDisplayHTML(pnModURL('iw_main', 'admin', 'main')) . "\">" . _IWMAINCRON . "</a> " . $params['seperator'];
//		$booksmenulinks .= " <a href=\"" . DataUtil::formatForDisplayHTML(pnModURL('iw_main', 'admin', 'conf')) . "\">" . _IWMAINCONFIG . "</a> " . $params['seperator'];
		$booksmenulinks .= " <a href=\"" . DataUtil::formatForDisplayHTML(pnModURL('books', 'admin', 'manageDescriptors')) . "\">" . __('Administra els descriptors',$dom) . "</a> " . $params['seperator'];
		$booksmenulinks .= " <a href=\"" . DataUtil::formatForDisplayHTML(pnModURL('books', 'admin', 'config')) . "\">" . __('Configura el mòdul',$dom) . "</a> ";
	}

	$booksmenulinks .= $params['end'] . "</span>\n";

	return $booksmenulinks;
}
