<?php
/**
 * Zikula Application Framework
 *
 * @copyright (c) 2001, Zikula Development Team
 * @link http://www.zikula.org
 * @version $Id: print.php 24342 2008-06-06 12:03:14Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @deprecated
 * @note This file is only need for news module users upgrading from .7x
 */

include 'includes/pnAPI.php';
pnInit();

// get story id from input
$sid = FormUtil::getPassedValue('sid', '', 'GETPOST');

if (empty($sid)  || !is_numeric($sid) || !pnModAvailable('News')) {
    header('HTTP/1.0 404 Not Found');
    include 'header.php';
    echo _MODARGSERROR;
    include 'footer.php';
    pnShutDown();
}

if (!pnLocalReferer() && pnConfigGetVar('refereronprint')) {
    Header('HTTP/1.1 301 Moved Permanently');
    pnRedirect(pnModURL('News', 'user', 'display', array('sid' => $sid)));
    pnShutDown();
} else  {
    pnRedirect(pnModURL('News', 'user', 'display', array('sid' => $sid, 'theme' => 'Printer')));
    pnShutDown();
}
