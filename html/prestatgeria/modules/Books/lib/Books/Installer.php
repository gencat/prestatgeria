<?php

class Books_Installer extends Zikula_AbstractInstaller {

    /**
     * Initialise the dynamic user data  module
     * This function is only ever called once during the lifetime of a particular
     * module instance
     * @author Albert Pérez Monfort
     * @return bool true on success or false on failure
     */
    public function Install() {
        if (!DBUtil::createTable('books'))
            return false;
        if (!DBUtil::createTable('books_schools'))
            return false;
        if (!DBUtil::createTable('books_schools_info'))
            return false;
        if (!DBUtil::createTable('books_descriptors'))
            return false;
        if (!DBUtil::createTable('books_bookcollections'))
            return false;
        if (!DBUtil::createTable('books_userbooks'))
            return false;
        if (!DBUtil::createTable('books_anounces'))
            return false;
        if (!DBUtil::createTable('books_comment'))
            return false;
        if (!DBUtil::createTable('books_nav'))
            return false;
        if (!DBUtil::createTable('books_allowed'))
            return false;

        $this->setVar('bookSoftwareUrl', '')
                ->setVar('bookSoftwareUri', '')
                ->setVar('canCreateToOthers', 1)
                ->setVar('mailDomServer', '')
                ->setVar('bookSoftwareUrl', '')
                ->setVar('booksDatabase', '')
                ->setVar('serverImageFolder', '')
                ->setVar('everyBodyCanCreate', 0);

        // Initialisation successful
        return true;
    }

    /**
     * Delete the dyanmic user data module
     * This function is only ever called once during the lifetime of a particular
     * module instance
     * @author Albert Pérez Monfort
     * @return bool true on success or false on failure
     */
    public function Uninstall() {
        DBUtil::dropTable('books');
        DBUtil::dropTable('books_schools');
        DBUtil::dropTable('books_schools_info');
        DBUtil::dropTable('books_descriptors');
        DBUtil::dropTable('books_bookcollections');
        DBUtil::dropTable('books_userbooks');
        DBUtil::dropTable('books_anounces');
        DBUtil::dropTable('books_comment');
        DBUtil::dropTable('books_nav');
        DBUtil::dropTable('books_allowed');

        // Delete any module variables
        $this->delVar('bookSoftwareUrl')
                ->delVar('bookSoftwareUri')
                ->delVar('canCreateToOthers')
                ->delVar('bookSoftwareUrl')
                ->delVar('mailDomServer')
                ->delVar('booksDatabase')
                ->delVar('serverImageFolder')
                ->delVar('everyBodyCanCreate');

        // Deletion successful
        return true;
    }

    /**
     * Upgrade the dynamic user data module from an old version
     * This function can be called multiple times
     * @author Albert Pérez Monfort
     * @param int $oldversion version to upgrade from
     * @return bool true on success or false on failure
     */
    public function Upgrade($oldversion) {
        DBUtil::changeTable('books');
        // Update successful
        return true;
    }

}