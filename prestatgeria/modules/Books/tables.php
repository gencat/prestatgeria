<?php

function Books_tables() {

    // Initialise table array
    $table = array();

    // books table definition
    $table['books'] = DBUtil::getLimitedTablename('books');
    $table['books_column'] = array('bookId' => 'bookId',
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

    $table['books_column_def'] = array('bookId' => "I(11) NOTNULL AUTO PRIMARY",
        'schoolCode' => "C(12) NOTNULL DEFAULT ''",
        'bookTitle' => "C(100) NOTNULL DEFAULT ''",
        'bookLang' => "C(2) NOTNULL",
        'bookAdminName' => "C(12) NOTNULL",
        'newBookAdminName' => "C(12) NOTNULL",
        'bookHits' => "I(11) NOTNULL DEFAULT '0'",
        'bookLastVisit' => "C(20) NOTNULL DEFAULT ''",
        'bookDateInit' => "C(20) NOTNULL DEFAULT ''",
        'bookState' => "I(1) NOTNULL DEFAULT '-1'",
        'bookDescript' => "C(255) NOTNULL DEFAULT '#'",
        'collectionId' => "I(3) NOTNULL",
        'bookActivationCode' => "C(40) NOTNULL",
        'lastEntry' => "C(20) NOTNULL",
        'bookPages' => "I(5) NOTNULL");

    //books_schools table definition
    $table['books_schools'] = DBUtil::getLimitedTablename('books_schools');
    $table['books_schools_column'] = array('schoolId' => 'schoolId',
        'schoolCode' => 'schoolCode',
        'schoolName' => 'schoolName',
        'schoolType' => 'schoolType',
        'schoolDateIns' => 'schoolDateIns',
        'schoolState' => 'schoolState',
        'schoolCity' => 'schoolCity',
        'schoolZipCode' => 'schoolZipCode',
        'schoolRegion' => 'schoolRegion');

    $table['books_schools_column_def'] = array('schoolId' => "I(11) NOTNULL AUTO PRIMARY",
        'schoolCode' => "C(12) NOTNULL DEFAULT '' KEY UNIQUE",
        'schoolName' => "C(200) NOTNULL DEFAULT ''",
        'schoolType' => "C(50) NOTNULL DEFAULT ''",
        'schoolDateIns' => "C(20) NOTNULL DEFAULT ''",
        'schoolState' => "I(1) NOTNULL DEFAULT '1'",
        'schoolCity' => "C(100) NOTNULL",
        'schoolZipCode' => "C(12) NOTNULL",
        'schoolRegion' => "C(100) NOTNULL DEFAULT ''");

    //books_schools_info table definition
    $table['books_schools_info'] = DBUtil::getLimitedTablename('books_schools_info');
    $table['books_schools_info_column'] = array('schoolInfo' => 'schoolInfo',
        'schoolCode' => 'schoolCode',
        'schoolName' => 'schoolName',
        'schoolType' => 'schoolType',
        'schoolCity' => 'schoolCity',
        'schoolZipCode' => 'schoolZipCode',
        'schoolRegion' => 'schoolRegion');

    $table['books_schools_info_column_def'] = array('schoolInfo' => "I(11) NOTNULL AUTO PRIMARY",
        'schoolCode' => "C(12) NOTNULL DEFAULT '' KEY UNIQUE",
        'schoolName' => "C(200) NOTNULL DEFAULT ''",
        'schoolType' => "C(50) NOTNULL DEFAULT ''",
        'schoolCity' => "C(100) NOTNULL",
        'schoolZipCode' => "C(12) NOTNULL",
        'schoolRegion' => "C(100) NOTNULL DEFAULT ''");
    // books_descriptors table definition
    $table['books_descriptors'] = DBUtil::getLimitedTablename('books_descriptors');
    $table['books_descriptors_column'] = array('did' => 'did',
        'descriptor' => 'descriptor',
        'number' => 'number');

    $table['books_descriptors_column_def'] = array('did' => "I(11) NOTNULL AUTO PRIMARY",
        'descriptor' => "C(50) NOTNULL DEFAULT ''",
        'number' => "I(11) NOTNULL DEFAULT '0'");

    // books_bookcollections table definition
    $table['books_bookcollections'] = DBUtil::getLimitedTablename('books_bookcollections');
    $table['books_bookcollections_column'] = array('collectionId' => 'collectionId',
        'collectionName' => 'collectionName',
        'collectionState' => 'collectionState',
        'collectionAutoInit' => 'collectionAutoInit',
        'collectionAutoOut' => 'collectionAutoOut');

    $table['books_bookcollections_column_def'] = array('collectionId' => "I(11) NOTNULL AUTO PRIMARY",
        'collectionName' => "C(50) NOTNULL DEFAULT ''",
        'collectionState' => "I(50) NOTNULL DEFAULT '0'",
        'collectionAutoInit' => "C(20) NOTNULL DEFAULT ''",
        'collectionAutoOut' => "C(20) NOTNULL DEFAULT ''");

    // books_userbooks table definition
    $table['books_userbooks'] = DBUtil::getLimitedTablename('books_userbooks');
    $table['books_userbooks_column'] = array('ubid' => 'ubid',
        'userName' => 'userName',
        'bookId' => 'bookId');

    $table['books_userbooks_column_def'] = array('ubid' => "I(11) NOTNULL AUTO PRIMARY",
        'userName' => "C(12) NOTNULL DEFAULT ''",
        'bookId' => "I(11) NOTNULL DEFAULT '0'");

    // books_anounces table definition
    $table['books_anounces'] = DBUtil::getLimitedTablename('books_anounces');
    $table['books_anounces_column'] = array('aid' => 'aid',
        'bookId' => 'bookId',
        'schoolCode' => 'schoolCode',
        'text' => 'text',
        'dateInit' => 'dateInit',
        'dateEnd' => 'dateEnd',
        'bookTitle' => 'bookTitle',
        'adminName' => 'adminName',
        'state' => 'state',
        'color' => 'color');

    $table['books_anounces_column_def'] = array('aid' => "I(11) NOTNULL AUTO PRIMARY",
        'bookId' => "I(11) NOTNULL DEFAULT '0'",
        'schoolCode' => "C(12) NOTNULL DEFAULT ''",
        'text' => "C(225) NOTNULL DEFAULT ''",
        'dateInit' => "C(20) NOTNULL DEFAULT ''",
        'dateEnd' => "C(20) NOTNULL DEFAULT ''",
        'bookTitle' => "C(100) NOTNULL DEFAULT ''",
        'adminName' => "C(12) NOTNULL DEFAULT ''",
        'state' => "I(1) NOTNULL DEFAULT '1'",
        'color' => "I(1) NOTNULL DEFAULT '0'");

    // books_comment table definition
    $table['books_comment'] = DBUtil::getLimitedTablename('books_comment');
    $table['books_comment_column'] = array('cid' => 'cid',
        'bookId' => 'bookId',
        'userName' => 'userName',
        'date' => 'date',
        'text' => 'text');

    $table['books_comment_column_def'] = array('cid' => "I(11) NOTNULL AUTO PRIMARY",
        'bookId' => "I(11) NOTNULL",
        'userName' => "C(12) NOTNULL",
        'date' => "C(20) NOTNULL",
        'text' => "X NOTNULL");

    // books_nav table definition
    $table['books_nav'] = DBUtil::getLimitedTablename('books_nav');
    $table['books_nav_column'] = array('unid' => 'unid',
        'sessid' => 'sessid',
        'booksOrder' => 'booksOrder',
        'filter' => 'filter',
        'init' => 'init',
        'bookId' => 'bookId',
        'filterValue' => 'filterValue');

    $table['books_nav_column_def'] = array('unid' => "I(11) NOTNULL AUTO PRIMARY",
        'sessid' => "C(50) NOTNULL DEFAULT ''",
        'booksOrder' => "C(12) NOTNULL DEFAULT ''",
        'filter' => "C(20) NOTNULL DEFAULT ''",
        'init' => "I(11) NOTNULL DEFAULT '0'",
        'bookId' => "I(11) NOTNULL DEFAULT '0'",
        'filterValue' => "C(50) NOTNULL DEFAULT ''");

    // books_allowed table definition
    $table['books_allowed'] = DBUtil::getLimitedTablename('books_allowed');
    $table['books_allowed_column'] = array('aid' => 'aid',
        'userName' => 'userName',
        'schoolCode' => 'schoolCode');

    $table['books_allowed_column_def'] = array('aid' => "I(11) NOTNULL AUTO PRIMARY",
        'userName' => "C(12) NOTNULL",
        'schoolCode' => "C(12) NOTNULL");

    // Return the table information
    return $table;
}
