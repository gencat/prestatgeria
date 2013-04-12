<?php
/**
 * Zikula Application Framework
 *
 * @copyright (c) 2002, Zikula Development Team
 * @link http://www.zikula.org
 * @version $Id: pnversion.php 24736 2008-10-17 14:45:47Z Guite $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package Zikula_System_Modules
 * @subpackage Books
 */

$dom = ZLanguage::getThemeDomain('Books');

$modversion['name']           = 'Books';
$modversion['displayname']    = __('Llibres',$dom);
$modversion['description']    = __("Integració d'un sistema multiMyScrackBook a Zikula",$dom);
$modversion['version']        = '1.0';
$modversion['credits']        = 'pndocs/credits.txt';
$modversion['help']           = 'pndocs/help.txt';
$modversion['changelog']      = 'pndocs/changelog.txt';
$modversion['license']        = 'pndocs/license.txt';
$modversion['official']       = false;
$modversion['author']         = 'Albert Pérez Monfort & Francesc Bassas';
$modversion['contact']        = 'http://phobos.xtec.cat/llibres';
$modversion['admin']		  = true;
$modversion['securityschema'] = array('Books::' => '::');