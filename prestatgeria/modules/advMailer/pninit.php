<?php

/**
 * Zikula Application Framework
 *
 * @package	XTEC advMailer
 * @author	Francesc Bassas i Bullich
 * @license	GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 */

/**
 * initialise the module
 *
 * @author Francesc Bassas i Bullich
 * @return bool true on success, false otherwise
 */
function advMailer_init()
{
    // Set default module variables
    pnModSetVar('advMailer', 'enabled', 1);
    pnModSetVar('advMailer', 'idApp', '');
    pnModSetVar('advMailer', 'replyAddress', '');
    pnModSetVar('advMailer', 'sender', '');
    pnModSetVar('advMailer', 'environment', '');
    pnModSetVar('advMailer', 'contenttype', 1);
    pnModSetVar('advMailer', 'log', 0);
    pnModSetVar('advMailer', 'debug', 0);
	pnModSetVar('advMailer', 'logpath', '');  
    
    // Initialisation successful
    return true;
}

/**
 * delete the module
 *
 * @author  Francesc Bassas i Bullich
 * @return  bool true if successful, false otherwise
 */
function advMailer_delete()
{
    // Delete all module variables
    pnModDelVar('advMailer');

    // Deletion successful
    return true;
}