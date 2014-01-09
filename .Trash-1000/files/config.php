<?php

global $PNConfig;

/** Integració **/
$PNConfig['DBInfo']['default']['dbhost'] = 'pdb-int';
$PNConfig['DBInfo']['default']['dbuname'] = 'presta';
$PNConfig['DBInfo']['default']['dbpass'] = 'presta';
$PNConfig['DBInfo']['default']['dbname'] = 'presta';
$PNConfig['DBInfo']['book']['dbhost'] = 'pdb-int';
$PNConfig['DBInfo']['book']['dbuname'] = 'presta';
$PNConfig['DBInfo']['book']['dbpass'] = 'presta';
$PNConfig['DBInfo']['book']['dbname'] = 'presta';

/** Acceptació **/
// $PNConfig['DBInfo']['default']['dbhost'] = 'pdb-acc';
// $PNConfig['DBInfo']['default']['dbuname'] = 'presta';
// $PNConfig['DBInfo']['default']['dbpass'] = '*****';
// $PNConfig['DBInfo']['default']['dbname'] = 'presta';
// $PNConfig['DBInfo']['book']['dbhost'] = 'pdb-acc';
// $PNConfig['DBInfo']['book']['dbuname'] = 'presta';
// $PNConfig['DBInfo']['book']['dbpass'] = '*****';
// $PNConfig['DBInfo']['book']['dbname'] = 'presta';

/** Producció **/
// $PNConfig['DBInfo']['default']['dbhost'] = 'mykonos1';
// $PNConfig['DBInfo']['default']['dbuname'] = 'presta';
// $PNConfig['DBInfo']['default']['dbpass'] = '*****';
// $PNConfig['DBInfo']['default']['dbname'] = 'presta';
// $PNConfig['DBInfo']['book']['dbhost'] = 'mykonos1';
// $PNConfig['DBInfo']['book']['dbuname'] = 'presta';
// $PNConfig['DBInfo']['book']['dbpass'] = '*****';
// $PNConfig['DBInfo']['book']['dbname'] = 'presta';

/**
 * Zikula Application Framework
 *
 * @copyright (c) 2002, Zikula Development Team
 * @link http://www.zikula.org
 * @version $Id: config.php 24342 2008-06-06 12:03:14Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 */
// ----------------------------------------------------------------------
// NOTICE
// Zikula includes an install script which can populate the database
// and write this config file automatically.  There is normally no need
// to manually edit this file!
// ----------------------------------------------------------------------

// ----------------------------------------------------------------------
// Database & System Config
//
//      dbtype:      type of database, can be mysql, mysqli, mssql, oci8, or oracle 
//      dbtabletype: type of table for MySQL database, MyISAM, INNODB
//      dbhost:      Database Hostname
//      dbuname:     Username
//      dbpass:      Password
//      dbname:      Database Name
//      encoded:     0 for username/password information plaintext
//                   1 for username/password information base64 encoded
//      pconnect:    0 use connect
//                   1 use pconnect
// ----------------------------------------------------------------------
//
// ----------------------------------------------------------------------
// The following define some global settings for the application
// ----------------------------------------------------------------------

$PNConfig['System']['installed'] = 1;         // installer will change this during installation
$PNConfig['System']['tabletype']   = 'myisam';  // installer will change this during installation
$PNConfig['System']['temp']        = 'pnTemp';  // installer will change this during installation
$PNConfig['System']['prefix'] = 'zk';      // installer will change this during installation
$PNConfig['System']['development'] = 0;         // should be set to 0/false when cutting a release for production use

// ----------------------------------------------------------------------
// This is the definition for the default Zikula system database.
// It *must* be named 'default'!
// ----------------------------------------------------------------------
$PNConfig['DBInfo']['default']['dbtype'] = 'mysql';
$PNConfig['DBInfo']['default']['encoded'] = 0;
$PNConfig['DBInfo']['default']['pconnect']    = 0;
$PNConfig['DBInfo']['default']['dbtabletype'] = 'myisam';
$PNConfig['DBInfo']['default']['dbcharset']   = 'utf8';	// will be changed to 'utf' after PN 0.8!

// ----------------------------------------------------------------------
// Please consult the MySQL documentation for valid character set names! 
// 'iso-8859-1' = 'latin1', 'UTF-8' = 'utf8' 
// when upgrade to PN 0.81, PN 0.9 etc please ensure that your DB is set to utf8!
// TIP: you can change the character set using phpMyAdmin!
// ----------------------------------------------------------------------

// ----------------------------------------------------------------------
// The following define the list of databases the system can access. You
// can define as many as you like provided you give each one a unique
// name (the key value following the DBInfo array element)
// ----------------------------------------------------------------------
$PNConfig['DBInfo']['book']['dbtype'] = 'mysql';	// sample value
$PNConfig['DBInfo']['book']['encoded'] = 0;
$PNConfig['DBInfo']['book']['pconnect']  = 0;
$PNConfig['DBInfo']['book']['dbtabletype'] = 'myisam';
$PNConfig['DBInfo']['book']['dbcharset']   = 'utf8';

// ----------------------------------------------------------------------
// Debugging/Tracing settings
// ----------------------------------------------------------------------
$PNConfig['Debug']['debug']          = 0;   //
$PNConfig['Debug']['pagerendertime'] = 0;   // display page render time, 0 to disable
$PNConfig['Debug']['sql_adodb']      = 0;   // adodb debug flag, generates lots of print output
$PNConfig['Debug']['sql_count']      = 0;   // count sql statements, 0 to disable
$PNConfig['Debug']['sql_time']       = 0;   // time sql statements, 0 to disable
$PNConfig['Debug']['sql_detail']     = 0;   // collect executed sql statements, 0 to disable
$PNConfig['Debug']['sql_data']       = 0;   // collect selected data, 0 to disable
$PNConfig['Debug']['sql_user']       = 0;   // user filter, 0 for all, any other number is a user-id, can also be an array

// ----------------------------------------------------------------------
// Error Reporting
// ----------------------------------------------------------------------
$PNConfig['Debug']['error_reporting_development'] = E_ALL;                           // preconfigured level
$PNConfig['Debug']['error_reporting_production']  = E_ALL & ~E_NOTICE & ~E_WARNING;  // preconfigured level
$PNConfig['Debug']['debug_key']                   = ($PNConfig['System']['development'] ? 'error_reporting_development' : 'error_reporting_production');
error_reporting($PNConfig['Debug'][$PNConfig['Debug']['debug_key']]);                // now set the appropriate level

// ----------------------------------------------------------------------
// Logging Settings
// ----------------------------------------------------------------------
$PNConfig['Log']['log_enabled']          = 0;                                                      // global logging to on/off switch for 'log_dest' (0=off, 1=on)
$PNConfig['Log']['log_dest']             = 'FILE';                                                 // the default logging destination. Can be "FILE", "PRINT", "EMAIL" or "DB".
$PNConfig['Log']['log_dir']              = $PNConfig['System']['temp'] . '/error_logs/';           // the directory containing all log files
$PNConfig['Log']['log_file']             = $PNConfig['Log']['log_dir'] . 'zikula-%s.log';        // %s is where todays date will go
$PNConfig['Log']['log_file_uid']         = 0;                                                      // wether or not a separate log file is used for each user. The filename is derived from $PNConfig['Log']['log_file']
$PNConfig['Log']['log_file_date_format'] = 'Ymd';                                                  // dateformat to be used for the generated log filename
$PNConfig['Log']['log_maxsize']          = 1.0;                                                    // value in MB. Decimal is OK. (Use 0 for no limit)
$PNConfig['Log']['log_user']             = 0;                                                      // user filter for logging, 0 for all, can also be an array
$PNConfig['Log']['log_levels']           = array('CORE', 'DB', 'DEFAULT', 'WARNING', 'FATAL', 'STRICT');     // User defined. To get everything use: $log_level = array("All");
$PNConfig['Log']['log_show_errors']      = true;                                                   // Show php logging errors on screen (Use while developing only)
$PNConfig['Log']['log_date_format']      = "Y-m-d H:i:s";                                          // 2006-07-19 18:41:50
$PNConfig['Log']['log_level_dest']       = array('DB' => 'PRINT');                                 // array of level-specific log destinations
$PNConfig['Log']['log_level_files']      = array('DB' => $PNConfig['System']['temp'] . '/error_logs/zikula-sql-%s.log'); // array of level-specific log files (only used if destination=="FILE")
$PNConfig['Log']['log_keep_days']        = 30;                                                     // amount of days to keep log files for (older files will be erased)

// ----------------------------------------------------------------------
// The following define some data layer settings
// ----------------------------------------------------------------------
$PNConfig['System']['PN_CONFIG_USE_OBJECT_ATTRIBUTION']    = 0;   // enable universal attribution layer, 0 to turn off
$PNConfig['System']['PN_CONFIG_USE_OBJECT_CATEGORIZATION'] = 1;   // categorization/filtering services, 0 to turn off
$PNConfig['System']['PN_CONFIG_USE_OBJECT_LOGGING']        = 0;   // object audit trail logging, 0 to turn off
$PNConfig['System']['PN_CONFIG_USE_OBJECT_META']           = 0;   // meta-data services, 0 to turn off
$PNConfig['System']['PN_CONFIG_USE_TRANSACTIONS']          = 0;   // run request as a transaction, 0 to turn off

// ----------------------------------------------------------------------
// Initialize runtime variables to sane defaults
// ----------------------------------------------------------------------
global $PNRuntime;
$PNRuntime['sql']               = array();
$PNRuntime['sql_count_request'] = 0;
$PNRuntime['sql_time_request']  = 0;

// ----------------------------------------------------------------------
// if there is a personal_config.php in the folder where is config.php
// we add it. (This HAS to be at the end, after all initialization.)
// ----------------------------------------------------------------------
if (file_exists('config/personal_config.php')) {
    require_once 'config/personal_config.php';
}

// ----------------------------------------------------------------------
// Make config file backwards compatible (deprecated)
// ----------------------------------------------------------------------
extract($PNConfig, EXTR_OVERWRITE);
