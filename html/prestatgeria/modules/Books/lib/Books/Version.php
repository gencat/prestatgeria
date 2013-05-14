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
class Books_Version extends Zikula_AbstractVersion {

    public function getMetaData() {
        $meta = array();
        $meta['displayname'] = $this->__("Llibres");
        $meta['description'] = $this->__("Integració d'un sistema multiMyScrackBook a Zikula");
        $meta['url'] = $this->__("Books");
        $meta['version'] = '1.0.0';
        $meta['securityschema'] = array('Books::' => '::');
        return $meta;
    }
}