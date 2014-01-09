<?php
function Books_pntables()
{

	// Initialise table array
	$pntable = array();
		
	// books table definition
	$pntable['books'] = DBUtil::getLimitedTablename('books');
	$pntable['books_column'] = array('bookId' => 'bookId',
										'schoolCode' => 'schoolCode',
										'bookTitle' => 'bookTitle',
										'bookLang' => 'bookLang',
										'bookAdminName' => 'bookAdminName',
                                        'newBookAdminName' => 'newBookAdminName',
										'bookHits' => 'bookHits',
										'bookLastVisit' => 'bookLastVisit',
										'bookDateInit' => 'bookDateInit',
										'bookState' => 'bookState',
										'bookDescript' => 'bookDescript',
										'collectionId' => 'collectionId',
										'bookActivationCode' => 'bookActivationCode',
										'lastEntry' => 'lastEntry',
										'bookPages' => 'bookPages');

	$pntable['books_column_def'] = array('bookId' => "INT(11) NOTNULL AUTOINCREMENT KEY",
											'schoolCode' => "VARCHAR(12) NOTNULL DEFAULT ''",
											'bookTitle' => "VARCHAR(100) NOTNULL DEFAULT ''",
											'bookLang' => "VARCHAR(2) NOTNULL",
											'bookAdminName' => "VARCHAR(12) NOTNULL",
                                            'newBookAdminName' => "VARCHAR(12) NOTNULL",
											'bookHits' => "INT(11) NOTNULL DEFAULT '0'",
											'bookLastVisit' => "VARCHAR(20) NOTNULL DEFAULT ''",
											'bookDateInit' => "VARCHAR(20) NOTNULL DEFAULT ''",
											'bookState' => "TINYINT(1) NOTNULL DEFAULT '-1'",
											'bookDescript' => "VARCHAR(255) NOTNULL DEFAULT '#'",
											'collectionId' => "INT(3) NOTNULL",
											'bookActivationCode' => "VARCHAR(40) NOTNULL",
											'lastEntry' => "VARCHAR(20) NOTNULL",
											'bookPages' => "INT(5) NOTNULL");

	//books_schools table definition
	$pntable['books_schools'] = DBUtil::getLimitedTablename('books_schools');
	$pntable['books_schools_column'] = array('schoolId' => 'schoolId',
												'schoolCode' => 'schoolCode',
												'schoolName' => 'schoolName',
												'schoolType' => 'schoolType',
												'schoolDateIns' => 'schoolDateIns',
												'schoolState' => 'schoolState',
												'schoolCity' => 'schoolCity',
												'schoolZipCode' => 'schoolZipCode',
												'schoolRegion' => 'schoolRegion');

	$pntable['books_schools_column_def'] = array('schoolId' => "INT(11) NOTNULL AUTOINCREMENT KEY",
													'schoolCode' => "VARCHAR(12) NOTNULL DEFAULT '' KEY UNIQUE",
													'schoolName' => "VARCHAR(200) NOTNULL DEFAULT ''",
													'schoolType' => "VARCHAR(50) NOTNULL DEFAULT ''",
													'schoolDateIns' => "VARCHAR(20) NOTNULL DEFAULT ''",
													'schoolState' => "TINYINT(1) NOTNULL DEFAULT '1'",
													'schoolCity' => "VARCHAR(100) NOTNULL",
													'schoolZipCode' => "VARCHAR(12) NOTNULL",
													'schoolRegion' => "VARCHAR(100) NOTNULL DEFAULT ''");

	//books_schools_info table definition
	$pntable['books_schools_info'] = DBUtil::getLimitedTablename('books_schools_info');
	$pntable['books_schools_info_column'] = array('schoolInfo' => 'schoolInfo',
													'schoolCode' => 'schoolCode',
													'schoolName' => 'schoolName',
													'schoolType' => 'schoolType',
													'schoolCity' => 'schoolCity',
													'schoolZipCode' => 'schoolZipCode',
													'schoolRegion' => 'schoolRegion');

	$pntable['books_schools_info_column_def'] = array('schoolInfo' => "INT(11) NOTNULL AUTOINCREMENT KEY",
														'schoolCode' => "VARCHAR(12) NOTNULL DEFAULT '' KEY UNIQUE",
														'schoolName' => "VARCHAR(200) NOTNULL DEFAULT ''",
														'schoolType' => "VARCHAR(50) NOTNULL DEFAULT ''",
														'schoolCity' => "VARCHAR(100) NOTNULL",
														'schoolZipCode' => "VARCHAR(12) NOTNULL",
														'schoolRegion' => "VARCHAR(100) NOTNULL DEFAULT ''");
	// books_descriptors table definition
	$pntable['books_descriptors'] = DBUtil::getLimitedTablename('books_descriptors');
	$pntable['books_descriptors_column'] = array('did' => 'did',
													'descriptor' => 'descriptor',
													'number' => 'number');

	$pntable['books_descriptors_column_def'] = array('did' => "INT(11) NOTNULL AUTOINCREMENT KEY",
														'descriptor' => "VARCHAR(50) NOTNULL DEFAULT ''",
														'number' => "INT(11) NOTNULL DEFAULT '0'");

	// books_bookcollections table definition
	$pntable['books_bookcollections'] = DBUtil::getLimitedTablename('books_bookcollections');
	$pntable['books_bookcollections_column'] = array('collectionId' => 'collectionId',
														'collectionName' => 'collectionName',
														'collectionState' => 'collectionState',
														'collectionAutoInit' => 'collectionAutoInit',
														'collectionAutoOut' => 'collectionAutoOut');

	$pntable['books_bookcollections_column_def'] = array('collectionId' => "INT(11) NOTNULL AUTOINCREMENT KEY",
															'collectionName' => "VARCHAR(50) NOTNULL DEFAULT ''",
															'collectionState' => "TINYINT(50) NOTNULL DEFAULT '0'",
															'collectionAutoInit' => "VARCHAR(20) NOTNULL DEFAULT ''",
															'collectionAutoOut' => "VARCHAR(20) NOTNULL DEFAULT ''");

	// books_userbooks table definition
	$pntable['books_userbooks'] = DBUtil::getLimitedTablename('books_userbooks');
	$pntable['books_userbooks_column'] = array('ubid' => 'ubid',
												'userName' => 'userName',
												'bookId' => 'bookId');

	$pntable['books_userbooks_column_def'] = array('ubid' => "INT(11) NOTNULL AUTOINCREMENT KEY",
													'userName' => "VARCHAR(12) NOTNULL DEFAULT ''",
													'bookId' => "INT(11) NOTNULL DEFAULT '0'");

	// books_anounces table definition
	$pntable['books_anounces'] = DBUtil::getLimitedTablename('books_anounces');
	$pntable['books_anounces_column'] = array('aid' => 'aid',
												'bookId' => 'bookId',
												'schoolCode' => 'schoolCode',
												'text' => 'text',
												'dateInit' => 'dateInit',
												'dateEnd' => 'dateEnd',
												'bookTitle' => 'bookTitle',
												'adminName' => 'adminName',
												'state' => 'state',
												'color' => 'color');

	$pntable['books_anounces_column_def'] = array('aid' => "INT(11) NOTNULL AUTOINCREMENT KEY",
													'bookId' => "INT(11) NOTNULL DEFAULT '0'",
													'schoolCode' => "VARCHAR(12) NOTNULL DEFAULT ''",
													'text' => "VARCHAR(225) NOTNULL DEFAULT ''",
													'dateInit' => "VARCHAR(20) NOTNULL DEFAULT ''",
													'dateEnd' => "VARCHAR(20) NOTNULL DEFAULT ''",
													'bookTitle' => "VARCHAR(100) NOTNULL DEFAULT ''",
													'adminName' => "VARCHAR(12) NOTNULL DEFAULT ''",
													'state' => "TINYINT(1) NOTNULL DEFAULT '1'",
													'color' => "TINYINT(1) NOTNULL DEFAULT '0'");

	// books_comment table definition
	$pntable['books_comment'] = DBUtil::getLimitedTablename('books_comment');
	$pntable['books_comment_column'] = array('cid' => 'cid',
												'bookId' => 'bookId',
												'userName' => 'userName',
												'date' => 'date',
												'text' => 'text');

	$pntable['books_comment_column_def'] = array('cid' => "INT(11) NOTNULL AUTOINCREMENT KEY",
													'bookId' => "INT(11) NOTNULL",
													'userName' => "VARCHAR(12) NOTNULL",
													'date' => "VARCHAR(20) NOTNULL",
													'text' => "TEXT NOTNULL");

	// books_nav table definition
	$pntable['books_nav'] = DBUtil::getLimitedTablename('books_nav');
	$pntable['books_nav_column'] = array('unid' => 'unid',
											'sessid' => 'sessid',
											'booksOrder' => 'booksOrder',
											'filter' => 'filter',
											'init' => 'init',
											'bookId' => 'bookId',
											'filterValue' => 'filterValue');

	$pntable['books_nav_column_def'] = array('unid' => "INT(11) NOTNULL AUTOINCREMENT KEY",
												'sessid' => "VARCHAR(50) NOTNULL DEFAULT ''",
												'booksOrder' => "VARCHAR(12) NOTNULL DEFAULT ''",
												'filter' => "VARCHAR(20) NOTNULL DEFAULT ''",
												'init' => "INT(11) NOTNULL DEFAULT '0'",
												'bookId' => "INT(11) NOTNULL DEFAULT '0'",
												'filterValue' => "VARCHAR(50) NOTNULL DEFAULT ''");

	// books_allowed table definition
	$pntable['books_allowed'] = DBUtil::getLimitedTablename('books_allowed');
	$pntable['books_allowed_column'] = array('aid' => 'aid',
												'userName' => 'userName',
												'schoolCode' => 'schoolCode');

	$pntable['books_allowed_column_def'] = array('aid' => "INT(11) NOTNULL AUTOINCREMENT KEY",
													'userName' => "VARCHAR(12) NOTNULL",
													'schoolCode' => "VARCHAR(12) NOTNULL");

	// Return the table information
	return $pntable;
}
