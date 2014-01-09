<?php

/**
 * Zikula Application Framework
 *
 * @package	XTEC advMailer
 * @author	Francesc Bassas i Bullich
 * @license	GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 */

$dom = ZLanguage::getModuleDomain('advMailer');

$modversion['name']           = 'advMailer';
$modversion['displayname']    = __('XTEC Advanced Mailer', $dom);
$modversion['description']    = __('XTEC Advanced Mailer: This module extends the regular zikula Mailer module with the XTEC mail system', $dom);
$modversion['version']        = '1.0.0';
$modversion['credits']        = 'pndocs/credits.txt';
$modversion['help']           = 'pndocs/help.txt';
$modversion['changelog']      = 'pndocs/changelog.txt';
$modversion['license']        = 'pndocs/license.txt';
$modversion['official']       = false;
$modversion['author']         = 'Francesc Bassas i Bullich';
$modversion['contact']        = '';
$modversion['securityschema'] = array('advMailer::' => '::');

// module dependencies
$modversion['dependencies'] = array(
    array(  'modname'    => 'Mailer',
            'minversion' => '2.0', 'maxversion' => '',
            'status'     => PNMODULE_DEPENDENCY_REQUIRED    )
    );