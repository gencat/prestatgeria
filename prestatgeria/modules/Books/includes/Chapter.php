<?php

class Chapter {

    private $chapterId;
    private $name;
    private $description;
    private $image;
    private $permission;
    private $notifyEmail;
    private $entriesPage;
    private $showName;
    private $showEmail;
    private $showUrl;
    private $showImage;
    private $formatPage;
    private $pages = array();
    private $unnaproved = array();

    function __construct($chapterId, $name, $description, $image, $permission, $notifyEmail, $entriesPage, $showName, $showEmail, $showUrl, $showImage, $formatPage) {
        $this->chapterId = $chapterId;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->permission = $permission;
        $this->notifyEmail = $notifyEmail;
        $this->entriesPage = $entriesPage;
        $this->showName = $showName;
        $this->showEmail = $showEmail;
        $this->showUrl = $showUrl;
        $this->showImage = $showImage;
        $this->formatPage = $formatPage;
    }

    function getChapterId() {
        return $this->chapterId;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getImage() {
        return $this->image;
    }

    function getPermission() {
        return $this->permission;
    }

    function getNotifyEmail() {
        return $this->notifyEmail;
    }

    function getEntriesPage() {
        return $this->entriesPage;
    }

    function getShowName() {
        return $this->showName;
    }

    function getShowEmail() {
        return $this->showEmail;
    }

    function getShowUrl() {
        return $this->showUrl;
    }

    function getShowImage() {
        return $this->showImage;
    }

    function getFormatPage() {
        return $this->formatPage;
    }

    function getPages() {
        return $this->pages;
    }

    function getUnnaproved() {
        return $this->unnaproved;
    }

    function countPages() {
        return count($this->pages);
    }

    function setChapterId($chapterId) {
        return $this->chapterId = $chapterId;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setPermission($permission) {
        return $this->permission = $permission;
    }

    function setNotifyEmail($notifyEmail) {
        return $this->notifyEmail = $notifyEmail;
    }

    function setEntriesPage($entriesPage) {
        return $this->entriesPage = $entriesPage;
    }

    function setShowName($showName) {
        return $this->showName = $showName;
    }

    function setShowEmail($showEmail) {
        return $this->showEmail = $showEmail;
    }

    function setShowUrl($showUrl) {
        return $this->showUrl = $showUrl;
    }

    function setShowImage($showImage) {
        return $this->showImage = $showImage;
    }

    function setFormatPage($formatPage) {
        return $this->formatPage = $formatPage;
    }

    function addPage($page) {
        array_push($this->pages, $page);
    }

    function delPage($page) {
        array_pop($this->pages);
    }

    function addUnnaproved($unnaproved) {
        array_push($this->unnaproved, $unnaproved);
    }

    function delUnnaproved($unnaproved) {
        array_pop($this->unnaproved);
    }

    function setPage($i, $page) {
        array_splice($this->pages, $i, 1, array($page));
    }

    function setUnnaproved($i, $unnaproved) {
        array_splice($this->unnaproved, $i, 1, array($unnaproved));
    }

    /**
     * creates a DOMNode instance of the chapter
     * @author:	Francesc Bassas i Bullich
     * @param:	dom	DOMDocument instance
     * @return:	returns a DOMNode instance of the chapter
     */
    function chapter2DOMNode($dom) {
        $chapter = $dom->createElement('chapter');

        // id
        $item = $dom->createElement('id');
        $chapter->appendChild($item);

        $data = $dom->createTextNode($this->chapterId);
        $item->appendChild($data);

        // name
        $item = $dom->createElement('name');
        $chapter->appendChild($item);

        $data = $dom->createCDATASection($this->name);
        $item->appendChild($data);

        // description
        $item = $dom->createElement('description');
        $chapter->appendChild($item);

        $data = $dom->createCDATASection($this->description);
        $item->appendChild($data);

        // image
        $item = $dom->createElement('image');
        $chapter->appendChild($item);

        $data = $dom->createCDATASection($this->image);
        $item->appendChild($data);

        // permission
        $item = $dom->createElement('permission');
        $chapter->appendChild($item);

        $data = $dom->createTextNode($this->permission);
        $item->appendChild($data);

        // notifyEmail
        $item = $dom->createElement('notifyEmail');
        $chapter->appendChild($item);

        $data = $dom->createTextNode($this->notifyEmail);
        $item->appendChild($data);

        // entriesPage
        $item = $dom->createElement('entriesPage');
        $chapter->appendChild($item);

        $data = $dom->createTextNode($this->entriesPage);
        $item->appendChild($data);

        // showName
        $item = $dom->createElement('showName');
        $chapter->appendChild($item);

        $data = $dom->createTextNode($this->showName);
        $item->appendChild($data);

        // showEmail
        $item = $dom->createElement('showEmail');
        $chapter->appendChild($item);

        $data = $dom->createTextNode($this->showEmail);
        $item->appendChild($data);

        // showUrl
        $item = $dom->createElement('showUrl');
        $chapter->appendChild($item);

        $data = $dom->createTextNode($this->showUrl);
        $item->appendChild($data);

        // showImage
        $item = $dom->createElement('showImage');
        $chapter->appendChild($item);

        $data = $dom->createTextNode($this->showImage);
        $item->appendChild($data);

        // formatPage
        $item = $dom->createElement('formatPage');
        $chapter->appendChild($item);

        $data = $dom->createTextNode($this->formatPage);
        $item->appendChild($data);

        // pages
        $pages = $dom->createElement('pages');
        $chapter->appendChild($pages);

        foreach ($this->getPages() as $page) {
            $pages->appendChild($page->page2DOMNode($dom));
        }

        // unnaproved
        $unnaproved = $dom->createElement('unnaproved');
        $chapter->appendChild($unnaproved);

        foreach ($this->getUnnaproved() as $page) {
            $unnaproved->appendChild($page->page2DOMNode($dom));
        }

        return $chapter;
    }

    /**
     * import a chapter from a DOMNode instance of the chapter
     * @author:	Francesc Bassas i Bullich
     * @param:	chapterNode	DOMNode instance of the chapter
     * @return:	
     */
    function DOMNode2chapter($chapterNode) {
        // id
        $nodes = $chapterNode->getElementsByTagName('id');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $this->setChapterId($value);

        // name
        $nodes = $chapterNode->getElementsByTagName('name');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $this->setName($value);

        // description
        $nodes = $chapterNode->getElementsByTagName('description');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $this->setDescription($value);

        // image
        $nodes = $chapterNode->getElementsByTagName('image');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $this->setImage($value);

        // permission
        $nodes = $chapterNode->getElementsByTagName('permission');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $this->setPermission($value);

        // notifyEmail
        $nodes = $chapterNode->getElementsByTagName('notifyEmail');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $this->setNotifyEmail($value);

        // entriesPage
        $nodes = $chapterNode->getElementsByTagName('entriesPage');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $this->setEntriesPage($value);

        // showName
        $nodes = $chapterNode->getElementsByTagName('showName');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $this->setShowName($value);

        // showEmail
        $nodes = $chapterNode->getElementsByTagName('showEmail');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $this->setShowEmail($value);

        // showUrl
        $nodes = $chapterNode->getElementsByTagName('showUrl');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $this->setShowUrl($value);

        // showImage
        $nodes = $chapterNode->getElementsByTagName('showImage');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $this->setShowImage($value);

        // formatPage
        $nodes = $chapterNode->getElementsByTagName('formatPage');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $this->setFormatPage($value);

        // pages
        $pagesNode = $chapterNode->getElementsByTagName('pages')->item(0);

        // page
        $pageNodes = $pagesNode->getElementsByTagName('page');
        foreach ($pageNodes as $pageNode) {

            Loader::RequireOnce("modules/books/includes/Page.php");

            $page = new Page();

            $page->DOMNode2page($pageNode);

            $this->addPage($page);
        }

        // unnaproved
        $unnaprovedNode = $chapterNode->getElementsByTagName('unnaproved')->item(0);

        // page
        $pageNodes = $unnaprovedNode->getElementsByTagName('page');
        foreach ($pageNodes as $pageNode) {

            Loader::RequireOnce('modules/books/includes/Page.php');

            $page = new Page();

            $page->DOMNode2page($pageNode);

            $this->addUnnaproved($page);
        }
    }

    /**
     * 
     * @author:	Francesc Bassas i Bullich
     * @param:	
     * @return:	
     */
    public function replaceImageFolder($original_folder, $new_folder) {
        foreach ($this->pages as $i => $page) {
            $page->replaceImageFolder($original_folder, $new_folder);
            $this->setPage($i, $page);
        }
        foreach ($this->unnaproved as $i => $unnaproved) {
            $unnaproved->replaceImageFolder($original_folder, $new_folder);
            $this->setUnnaproved($i, $unnaproved);
        }
    }

}

?>
