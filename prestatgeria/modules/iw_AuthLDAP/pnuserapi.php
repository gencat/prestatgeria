<?php
/**
 * Zikula Application Framework
 * @copyright (c) 2001, Zikula Development Team
 * @link http://www.zikula.org
 * @version $Id: pnuserapi.php 25144 2008-12-23 19:09:29Z Guite $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package Zikula_System_Modules
 * @subpackage iw_AuthLDAP
*/

/**
 * This is a standard function called when a user logs into PN
 * @author Mike Goldfinger <MikeGoldfinger@linuxmail.org>
 * @link http://iw_AuthLDAP.ch.vu
 * @param 'uname' the username to authenticate
 * @param 'pass' the password to autheticate the user with
 * @return bool true authetication succesful
 * @todo use user creation and group membership API calls.
*/
function iw_AuthLDAP_userapi_login($args)
{

    // Argument check
    if (!isset($args['uname']) || !isset($args['pass'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }
    
    // define the attributes we want to get in our search
    $justthese = array('dn', 'modifyTimestamp', 'uid', 'cn', 'mail', 'l', 'userpassword');
    // connect to ldap server
    if (!$ldap_ds = ldap_connect(pnModGetVar('iw_AuthLDAP', 'authldap_serveradr'))) {
        return false;
    }
    // set protocol version
    $ldap_protocol = (int) pnModGetVar('iw_AuthLDAP', 'authldap_protocol', 3);
    if (!ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, $ldap_protocol)) {
        return false;
    }
    $ldaprdn  = 'uid='.$args['uname'].','.pnModGetVar('iw_AuthLDAP', 'authldap_basedn');    // ldap rdn or dn
    $ldappass = $args['pass'];  // associated password
    ldap_bind($ldap_ds, $ldaprdn, $ldappass);
    
    // search the directory for our user
    if (!$ldap_sr = ldap_search($ldap_ds, pnModGetVar('iw_AuthLDAP', 'authldap_basedn'), pnModGetVar('iw_AuthLDAP', 'authldap_searchattr') . '=' . DataUtil::formatForStore($args['uname']), $justthese)) {
        //die('entra');
        return false;
    }
    // get the users from our search
    if ((!$info = ldap_get_entries($ldap_ds, $ldap_sr)) || ($info['count'] == 0)) {
        return false;
    } else {
        if (!isset($info[0]['dn'])) {
            return false;
        }
    }
    // we're now finished with ldap itself so we don't need the connection anymore
    @ldap_unbind($ldap_ds);

    // check if the user already exists in the PN database
    $pnuser = pnModAPIFunc('Users', 'user', 'get', array('uname' => $args['uname']));

    if (!empty($pnuser) && isset($pnuser['uid'])) {
        $uid = $pnuser['uid'];
    } else {
		// in case the user have to be created before the login
		if(pnModGetVar('iw_AuthLDAP','previouslyCreated') == 1){
		    LogUtil::registerError (_AUTHLDAP_NOTAUTH);
		    header('location:index.php?module=Usuaris&func=loginscreen');
		    exit;
		}
	    // set defaults - location may not be set in directory
	    $location = (isset($info[0]['l'][0])) ? $info[0]['l'][0] : '';
	    $realpass = $args['pass'];
	    $dynadata = array('_UREALNAME' => $info[0]['cn'][0],
	                      '_YLOCATION' => $location);
	    // now lets create the user in PN
	    $uid = pnModAPIFunc('Users', 'user', 'finishnewuser', array('uname' => $args['uname'],
	                                                                'email' => $args['uname'] . pnModGetVar('books','mailDomServer'),
	                                                                'pass' => md5($realpass),
	                                                                'moderated' => true,
	                                                                'dynadata' => $dynadata));
		//******* Prestatgeria adaption *******
		//check if the user is a school, CRP or something like this
		$uname = str_replace('a','0',$args['uname']);
		$uname = str_replace('b','1',$uname);
		$uname = str_replace('c','2',$uname);
		$uname = str_replace('e','4',$uname);
		$schoolInfo = pnModAPIFunc('books','user','getSchoolInfo', array('schoolCode' => $uname));
		//if school is an school insert record in schools table
		if($schoolInfo){
			$items = array('schoolCode' => $args['uname'],
							'schoolName' => $schoolInfo['schoolName'],
							'schoolType' => $schoolInfo['schoolType'],
							'schoolDateIns' => time(),
							'schoolCity' => $schoolInfo['schoolCity'],
							'schoolZipCode' => $schoolInfo['schoolZipCode'],
							'schoolRegion' => $schoolInfo['schoolRegion']);
			$created = pnModAPIFunc('books','user','createSchool', array('items' => $items));
		}else{
			if(pnModGetVar('books','canCreateToOthers') == 0){
				$items = array('schoolCode' => $args['uname'],
								'schoolName' => $args['uname'],
								'schoolDateIns' => time());
				//every user can create books, so he/she is inserted in schools table
				$created = pnModAPIFunc('books','user','createSchool', array('items' => $items));
			}
		}
		//******* finish *******
	}
    $user = pnUserGetVars($uid);
    if($user['pass'] != md5($realpass)){
        // change the user pass
        $pntable = pnDBGetTables();
	    $c = $pntable['users_column'];
	    $where = "$c[uname] = '" . $args['uname'] . "'";
        $items = array('pass' => md5($args['pass']));
	    DBUTil::updateObject ($items, 'users', $where);
    }
    // Storing Last Login date
    if (pnModGetVar('Users', 'savelastlogindate')) {
		if (!pnUserSetVar('lastlogin', date("Y-m-d H:i:s", time()), $uid)) {
		    return false;
		}
    }
    // return the user id
    return $uid;
}

/**
 * This is a standard function called when a user logs into PN
 * @author Mark West
 * @link http://www.markwest.me.uk
 * @return bool true authetication succesful
 * @todo use user creation and group membership API calls.
 */
function iw_AuthLDAP_userapi_logout($args)
{
    return true;
}
