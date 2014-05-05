<?php

/**
 * Copyright Zikula Foundation 2009 - Zikula Application Framework
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

/**
 * Listeners class.
 */
class AuthLDAP_Listeners {

    /**
     * Validate user via LDAP because the Zikula authentication has failed and create it if necessary
     * 
     * @author Albert Pérez Monfort
     * @author Toni Ginard
     * 
     * @return bool true if authentication is succesfull
     */
    public static function tryAuthLDAPListener(Zikula_Event $event) {
        $authentication_info = FormUtil::getPassedValue('authentication_info', isset($args['authentication_info']) ? $args['authentication_info'] : null, 'POST');

        // Argument check
        if ($authentication_info['login_id'] == '' || $authentication_info['pass'] == '') {
            return false;
        }

        $uname = $authentication_info['login_id'];
        $pass = $authentication_info['pass'];

        // define the attributes we want to get in our search
        $justthese = array('cn', 'uid', 'givenname', 'sn', 'mail');

        // connect to ldap server
        if (!$ldap_ds = ldap_connect(ModUtil::getVar('AuthLDAP', 'authldap_serveradr'))) {
            return false;
        }

        // Get configuration data
        $authldap_searchattr = ModUtil::getVar('AuthLDAP', 'authldap_searchattr');
        $authldap_basedn = ModUtil::getVar('AuthLDAP', 'authldap_basedn');
        $authldap_searchdn = ModUtil::getVar('AuthLDAP', 'authldap_searchdn');

        // XTEC LDAP server uses non-standar bind
        $ldaprdn = $authldap_searchattr . '=' . $uname . ',' . $authldap_basedn;    // ldap rdn or dn
        if (ldap_bind($ldap_ds, $ldaprdn, $pass) === false) {
            LogUtil::registerError('El nom d\'usuari/ària o la contrasenya no són correctes');
            return false;
        }

        // search the directory for the user
        if (!$ldap_sr = ldap_search($ldap_ds, $authldap_searchdn, $authldap_searchattr . '=' . DataUtil::formatForStore($uname), $justthese)) {
            LogUtil::registerError('No s\'ha trobat l\'usuari/ària en el servei LDAP i no podeu entrar a la Prestatgeria. Poseu-vos en contacte amb el SAU.');
            return false;
        }

        $info = ldap_get_entries($ldap_ds, $ldap_sr);

        // get the users from our search
        if (!$info || $info['count'] == 0) {
            LogUtil::registerError('No s\'han pogut obtenir les dades del servei LDAP. No podeu entrar. Poseu-vos en contacte amb el SAU.');
            return false;
        } else {
            if (!isset($info[0]['dn'])) {
                LogUtil::registerError('Les dades al servei LDAP no són correctes. No podeu entrar. Poseu-vos en contacte amb el SAU.');
                return false;
            }
        }

        // Disconnect from LDAP server
        ldap_unbind($ldap_ds);

        // Check if the user already exists in the Zikula database. If not, create it.
        $user = ModUtil::APIFunc('Users', 'user', 'get', array('uname' => $info[0]['uid'][0]));

        if (!empty($user) && isset($user['uid'])) {
            // Update password
            $uid = $user['uid'];
            $object = array(
                'uid' => $user['uid'],
                'pass' => '1$$' . md5($pass),
            );
            DBUtil::updateObject($object, 'users', '', 'uid');
        } else {
            // User doesn't exist. Create the user in Zikula users table
            $item = array('uname' => $info[0]['uid'][0],
                'email' => $info[0]['mail'][0],
                'user_regdate' => DateUtil::buildDatetime(date("Y"), date("m"), date("d"), date("H"), date("i"), date("s")),
                'approved_date' => DateUtil::buildDatetime(date("Y"), date("m"), date("d"), date("H"), date("i"), date("s")),
                'pass' => '1$$' . md5($pass),
                'activated' => 1,
                'approved_by' => 2,
            );

            $uid = DBUtil::insertObject($item, 'users', 'uid');

            if (!$uid) {
                return LogUtil::registerError('No s\'ha pogut crear l\'usuari/ària.');
            }

            // insert user in default group
            $defaultGroupId = ModUtil::getVar('Groups', 'defaultgroup');

            // User doesn't exist. Create the user in Zikula users table
            $item = array('uid' => $uid['uid'],
                'gid' => $defaultGroupId,
            );

            $groupMember = DBUtil::insertObject($item, 'group_membership');

            if (!$groupMember) {
                return LogUtil::registerError('No s\'ha pogut afegir l\'usuari/ària al grup per defecte.');
            }
            $uid = $uid['uid'];
        }

        LogUtil::getErrorMessages();

        UserUtil::setUserByUid($uid);
        return System::redirect('index.php');
    }

}
