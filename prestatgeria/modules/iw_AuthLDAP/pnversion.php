<?php
/**
 * Zikula Application Framework
 * @copyright (c) 2001, Zikula Development Team
 * @link http://www.zikula.org
 * @version $Id: pnversion.php 25144 2008-12-23 19:09:29Z Guite $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package Zikula_System_Modules
 * @subpackage AuthLDAP
*/

$modversion['name']           = 'iw_AuthLDAP';
$modversion['displayname']    = _AUTHLDAP_DISPLAYNAME;
$modversion['description']    = _AUTHLDAP_DESCRIPTION;
$modversion['version']        = '0.1';
$modversion['credits']        = 'pndocs/credits.txt';
$modversion['help']           = 'pndocs/help.txt';
$modversion['install']        = 'pndocs/install.html';
$modversion['changelog']      = 'pndocs/changelog.txt';
$modversion['license']        = 'pndocs/license.txt';
$modversion['official']       = 0;
$modversion['author']         = 'Mike Goldfinger';
$modversion['contact']        = 'MikeGoldfinger@linuxmail.org';
$modversion['dependencies']    = array(array('modname'    => 'AuthPN', 
                                             'minversion' => '1.0',
                                             'maxversion' => '',
                                             'status'     => PNMODULE_DEPENDENCY_REQUIRED));
