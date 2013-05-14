<?php
/**********************************************************************
						 Php Textfile DB Access API
						Copyright 2002 by c-worker.ch
						  http://www.c-worker.ch
***********************************************************************/
/**********************************************************************
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
***********************************************************************/

/***********************************
		 	Debug Mode 
************************************/

$DEBUG=0;	// 0=Debug disabled, 1=Debug enabled


/***********************************
		 	Constants
************************************/

// Version
define("TXT_DB_API_VERSION","0.1.1c");

// General
define("DEBUG",$DEBUG);
define("NOT_FOUND",-1);

// File parsing
define("TABLE_FILE_ESCAPE_CHAR","%"); 	// Char to Escape # in the Table Files
define("RECORD_MAX_SIZE",8000); 		// Max size of a Record in the File 
										// (including the # char's)
// Timeouts
define("OPEN_TIMEOUT",10); 		// Timeout in seconds to try opening a still locked Table
define("LOCK_TIMEOUT",10); 		// Timeout in seconds to try locking a still locked Table
define("LOCKFILE_TIMEOUT",30); 	// Timeout for the maximum time a lockfile can exist

// Order Types
define("ORDER_ASC",1);
define("ORDER_DESC",2);

// Column Types
define("COL_TYPE_INC","inc");
define("COL_TYPE_INT","int");
define("COL_TYPE_STRING","str");

// File Extensions
define("TABLE_FILE_EXT",".txt");
define("LOCK_FILE_EXT",".lock");

?>