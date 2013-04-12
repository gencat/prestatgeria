<?php
/**
 * Zikula Application Framework
 * @copyright (c) 2001, Zikula Development Team
 * @link http://www.zikula.org
 * @version $Id: pninit.php 25144 2008-12-23 19:09:29Z Guite $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package Zikula_System_Modules
 * @subpackage AuthLDAP
*/

/**
 * Initialise the ldap auth module
 * This function is only ever called once during the lifetime of a particular
 * module instance
 * @author Mike Goldfinger <MikeGoldfinger@linuxmail.org>
 * @link http://authldap.ch.vu
 * @return bool true on success or false on failure
 */
function iw_authldap_init()
{
    pnModSetVar('iw_AuthLDAP', 'authldap_serveradr', '127.0.0.1');
    pnModSetVar('iw_AuthLDAP', 'authldap_basedn', 'dc=foo,dc=bar');
    pnModSetVar('iw_AuthLDAP', 'authldap_bindas', '');
    pnModSetVar('iw_AuthLDAP', 'authldap_bindpass', '');
    pnModSetVar('iw_AuthLDAP', 'authldap_searchdn', 'ou=users,dc=foo,dc=bar');
    pnModSetVar('iw_AuthLDAP', 'authldap_searchattr', 'uid');
    pnModSetVar('iw_AuthLDAP', 'authldap_protocol', '3');
    pnModSetVar('iw_AuthLDAP', 'previouslyCreated', '0');

    // Initialisation successful
    return true;
}

/**
 * Upgrade the AuthLDAP module from an old version
 * This function can be called multiple times
 * @author Mike Goldfinger <MikeGoldfinger@linuxmail.org>
 * @link http://authldap.ch.vu
 * @return bool true on success or false on failure
 */
function iw_authldap_upgrade($oldversion)
{
    // Update successful
    return true;
}

/**
 * delete the ldap auth module
 * This function is only ever called once during the lifetime of a particular
 * module instance
 * @author Mike Goldfinger <MikeGoldfinger@linuxmail.org>
 * @link http://authldap.ch.vu
 * @return bool true on success or false on failure
 */
function iw_authldap_delete()
{
    // Delete module variables
    pnModDelVar('iw_AuthLDAP');

    // Deletion successful
    return true;
}
