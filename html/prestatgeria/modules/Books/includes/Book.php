<?php

class Book {

    private $bookId;
    private $schoolCode;
    private $bookTitle;
    private $overview;
    private $image;
    private $about;
    private $adminEmail;
    private $showSearch;
    private $lang;
    private $theme;
    private $htmlEditor;
    private $descriptors;
    private $chapters = array();

    function __construct($bookId, $schoolCode, $bookTitle, $overview, $image, $about, $adminEmail, $showSearch, $lang, $theme, $htmlEditor, $descriptors) {
        $this->bookId = $bookId;
        $this->schoolCode = $schoolCode;
        $this->bookTitle = $bookTitle;
        $this->overview = $overview;
        $this->image = $image;
        $this->about = $about;
        $this->adminEmail = $adminEmail;
        $this->showSearch = $showSearch;
        $this->lang = $lang;
        $this->theme = $theme;
        $this->htmlEditor = $htmlEditor;
        $this->descriptors = $descriptors;
    }

    /**
     * creates a book object from a xml file
     * @author:	Francesc Bassas i Bullich
     * @param:	filename	path to the xml file
     * @return:	book object on success or false on failure
     */
    public static function xml2book($filename) {
        $doc = new DOMDocument();

        if (!$doc->load($filename)) {
            return LogUtil::registerError('No s\'ha pogut carregar el fitxer ' . $filename . '.');
        }

        // Validates the document
        if (!$doc->schemaValidate('modules/Books/includes/book.xsd')) {
            return LogUtil::registerError('El fitxer ' . $filename . ' no és vàlid.');
        }

        $bookNode = $doc->getElementsByTagName('book')->item(0);

        // Creates the book
        return Book::DOMNode2Book($bookNode);
    }

    /**
     * creates a book object from a DOMNode instance
     * @author:	Francesc Bassas i Bullich
     * @param:	bookNode	DOMNode instance of the book
     * @return:	book object
     */
    private static function DOMNode2book($bookNode) {
        $book = new Book();

        // id
        $nodes = $bookNode->getElementsByTagName('id');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $book->setBookId($value);

        // schoolCode
        $nodes = $bookNode->getElementsByTagName('schoolCode');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $book->setSchoolCode($value);

        // bookTitle
        $nodes = $bookNode->getElementsByTagName('bookTitle');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $book->setBookTitle($value);

        // overview
        $nodes = $bookNode->getElementsByTagName('overview');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $book->setOverview($value);

        // image
        $nodes = $bookNode->getElementsByTagName('image');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $book->setImage($value);

        // about
        $nodes = $bookNode->getElementsByTagName('about');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $book->setAbout($value);

        // adminEmail
        $nodes = $bookNode->getElementsByTagName('adminEmail');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $book->setAdminEmail($value);

        // showSearch
        $nodes = $bookNode->getElementsByTagName('showSearch');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $book->setShowSearch($value);

        // lang
        $nodes = $bookNode->getElementsByTagName('lang');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $book->setLang($value);

        // theme
        $nodes = $bookNode->getElementsByTagName('theme');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $book->setTheme($value);

        // htmlEditor
        $nodes = $bookNode->getElementsByTagName('htmlEditor');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $book->setHtmlEditor($value);

        // descriptors
        $nodes = $bookNode->getElementsByTagName('descriptors');
        $node = $nodes->item(0);
        $value = $node->nodeValue;

        $book->setDescriptors($value);

        // chapters
        $chaptersNode = $bookNode->getElementsByTagName('chapters')->item(0);

        // chapter
        $chapterNodes = $chaptersNode->getElementsByTagName('chapter');
        foreach ($chapterNodes as $chapterNode) {

            Loader::RequireOnce("modules/Books/includes/Chapter.php");

            $chapter = new Chapter();

            $chapter->DOMNode2chapter($chapterNode);

            $book->pushChapter($chapter);
        }

        return $book;
    }

    public function getBookId() {
        return $this->bookId;
    }

    public function getSchoolCode() {
        return $this->schoolCode;
    }

    public function getBookTitle() {
        return $this->bookTitle;
    }

    public function getOverview() {
        return $this->overview;
    }

    public function getImage() {
        return $this->image;
    }

    public function getAbout() {
        return $this->about;
    }

    public function getAdminEmail() {
        return $this->adminEmail;
    }

    public function getShowSearch() {
        return $this->showSearch;
    }

    public function getLang() {
        return $this->lang;
    }

    public function getTheme() {
        return $this->theme;
    }

    public function getHtmlEditor() {
        return $this->htmlEditor;
    }

    public function getDescriptors() {
        return $this->descriptors;
    }

    public function getChapters() {
        return $this->chapters;
    }

    // cal utilitzar variables globals
    public function getImageFolder() {
        return '/centres/' . $this->schoolCode . '_' . $this->bookId . '/';
    }

    public function countChapters() {
        return count($this->chapters);
    }

    public function countPages() {
        foreach ($this->chapters as $chapter) {
            $count += $chapter->countPages();
        }
        return $count;
    }

    public function setBookId($bookId) {
        $this->bookId = $bookId;
    }

    public function setSchoolCode($schoolCode) {
        $this->schoolCode = $schoolCode;
    }

    public function setBookTitle($bookTitle) {
        $this->bookTitle = $bookTitle;
    }

    public function setOverview($overview) {
        $this->overview = $overview;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setAbout($about) {
        $this->about = $about;
    }

    public function setAdminEmail($adminEmail) {
        $this->adminEmail = $adminEmail;
    }

    public function setShowSearch($showSearch) {
        $this->showSearch = $showSearch;
    }

    public function setLang($lang) {
        $this->lang = $lang;
    }

    public function setTheme($theme) {
        $this->theme = $theme;
    }

    public function setHtmlEditor($htmlEditor) {
        $this->htmlEditor = $htmlEditor;
    }

    public function setDescriptors($descriptors) {
        $this->descriptors = $descriptors;
    }

    public function pushChapter($chapter) {
        array_push($this->chapters, $chapter);
    }

    public function setChapter($i, $chapter) {
        array_splice($this->chapters, $i, 1, array($chapter));
    }

    public function removeChapter($i) {
        array_splice($this->chapters, $i, 1);
    }

    public function addPage($numchapter, $page) {
        $this->chapters[$numchapter]->addPage($page);
    }

    /**
     * saves the book object as html structure in the specified folder
     * @author:	Francesc Bassas i Bullich
     * @param:	bookpath	path to the destination folder
     * @return:	true on success or false on failure
     */
    public function book2html($bookpath) {
        if (!mkdir($bookpath)) {
            return false;
        }

        $index .= '<ul>';

        // book overview
        if ($this->overview) {
            $index .= "<li><a href=descripcio.html target=\"right\">" . $this->bookTitle . "</a></li>";
            $fp = fopen($bookpath . 'descripcio.html', 'wb');  // 'overview.html'
            fwrite($fp, '<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/></head>');
            if ($this->getImage()) {
                fwrite($fp, '<img src="' . 'book_images/' . $this->getImage() . '"/>'); // 'images/'
            }
            fwrite($fp, $this->overview);
            fclose($fp);
        }

        $index .= '<ul>';

        // chapters
        foreach ($this->chapters as $i => $chapter) {

            // chapter overview
            $index .= "<li><a href=\"capitol" . ($i + 1) . "-descripcio.html\" target=\"right\">" . $chapter->getName() . '</a></li>';
            $fp = fopen($bookpath . 'capitol' . ($i + 1) . '-descripcio.html', 'wb'); // 'overview.html'
            fwrite($fp, '<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/></head>');
            fwrite($fp, '<h4>' . $chapter->getName() . '</h4>');
            if ($chapter->getImage()) {
                fwrite($fp, '<img src="' . 'book_images/' . $chapter->getImage() . '"/>');  // '../images/'
            }
            fwrite($fp, $chapter->getDescription());
            fclose($fp);

            $index .= '<ul>';

            // pages
            foreach ($chapter->getPages() as $j => $page) {

                // page
                $index .= "<li><a href=\"capitol" . ($i + 1) . "-pagina" . ($j + 1) . ".html\" target=\"right\">" . $page->getTitle() . '</a></li>';
                $fp = fopen($bookpath . 'capitol' . ($i + 1) . '-pagina' . ($j + 1) . '.html', 'wb');
                fwrite($fp, '<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/></head>');
                fwrite($fp, '<h4>' . $page->getTitle() . '</h4>');
                if ($page->getImage()) {
                    fwrite($fp, '<img src="' . 'book_images/' . $page->getImage() . '"/>');
                }
                fwrite($fp, $page->getText());
                fclose($fp);
            }

            $index .= '</ul>';
        }

        $index .= '</ul>';
        $index .= '</ul>';

        include_once 'utils.php';

        // images
        copydir(ModUtil::getVar('books', 'serverImageFolder') . '/' . $this->schoolCode . '_' . $this->bookId, $bookpath . 'book_images'); // 'images'
        // table of contents
        $fp = fopen($bookpath . 'toc.html', 'wb');
        fwrite($fp, '<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/></head>');
        fwrite($fp, $index);
        fclose($fp);

        // index
        $fp = fopen($bookpath . 'index.html', 'wb');
        fwrite($fp, '<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/></head>');
        fwrite($fp, '<frameset rows="*"');
        fwrite($fp, '<frameset cols="400,*"');

        fwrite($fp, '<frame src="toc.html" name="left" scrolling="auto" border="0" marginheight="20" marginwidth="0" NORESIZE>');
        fwrite($fp, '<frame src="descripcio.html" name="right" scrolling="auto" border="0" marginheight="20" marginwidth="20" NORESIZE>');

        fwrite($fp, '</frameset></frameset>');
        fclose($fp);

        return true;
    }

    /**
     * saves the book object as xml file in the specified path
     * @author:	Francesc Bassas i Bullich
     * @param:	filename	path to the file
     * @return:	returns true on success or false on failure
     */
    public function book2xml($filename) {
        $dom = new DOMDocument('1.0', 'UTF-8');

        $dom->formatOutput = true;

        $dom->appendChild($this->book2DOMNode($dom));

        if (!$dom->save($filename)) {
            return LogUtil::registerError('No s\'ha pogut generar el fitxer xml.');
        }

        return true;
    }

    /**
     * saves the book object as epub file in the specified path
     * @author:	Francesc Bassas i Bullich
     * @param:	
     * @return:	returns true on success or false on failure
     */
    public function book2epub($filename) {
        if (!mkdir($filename)) {
            return false;
        }

        Loader::RequireOnce("modules/Books/includes/eBookLib/ebook.php");
        $ebook = new ebook();
        $ebook->setDcTitle($this->bookTitle);
        $ebook->setDcCreator($this->getAdminEmail());
        $ebook->setDcCreatorAttrib('Role', 'aut');
        $ebook->setDcLanguage($this->lang);
        $ebook->setDcIdentifier('laprestatgeria_' . $this->getBookId());

        // book overview
        if ($this->overview) {
            $fp = fopen($filename . 'overview.xhtml', 'wb');
            $config = array('indent' => TRUE, 'output-xhtml' => TRUE, 'wrap' => 200);
            $strimg = '';
            if ($this->getImage()) {
                $strimg = '<img src="' . 'images/' . $this->getImage() . '"/>';
            }
            $tidy = tidy_parse_string($strimg .
                    $this->getOverview(), $config, 'UTF8');
            $tidy->cleanRepair();
            fwrite($fp, $tidy);
            fclose($fp);
            $ebook->addContentFile($filename . 'overview.xhtml', 'overview', 'application/xhtml+xml');
            $ebook->addTocElement('overview', $this->bookTitle, 'overview.xhtml');
            $spine[] = 'overview';
        }

        // chapters
        foreach ($this->chapters as $i => $chapter) {
            $chapterpath = $filename . 'chapter' . ($i + 1) . '/';
            mkdir($chapterpath);

            // chapter overview
            $fp = fopen($chapterpath . ($i + 1) . '.xhtml', 'wb');
            $config = array('indent' => TRUE, 'output-xhtml' => TRUE, 'wrap' => 200);
            $strimg = '';
            if ($chapter->getImage()) {
                $strimg = '<img src="' . 'images/' . $chapter->getImage() . '"/>';
            }
            $tidy = tidy_parse_string('<h3>' . $chapter->getName() . '</h4>' .
                    $strimg .
                    $chapter->getDescription(), $config, 'UTF8');
            $tidy->cleanRepair();
            fwrite($fp, $tidy);
            fclose($fp);

            $ebook->addContentFile($chapterpath . ($i + 1) . '.xhtml', 'chapter' . ($i + 1), 'application/xhtml+xml');
            $spine[] = 'chapter' . ($i + 1);

            foreach ($chapter->getPages() as $j => $page) {
                $fp = fopen($chapterpath . ($i + 1) . ($j + 1) . '.xhtml', 'wb');
                $config = array('indent' => TRUE, 'output-xhtml' => TRUE, 'wrap' => 200);
                $strimg = '';
                if ($page->getImage()) {
                    $strimg = '<img src="' . 'images/' . $page->getImage() . '"/>';
                }
                $tidy = tidy_parse_string('<h4>' . $page->getTitle() . '</h4>' .
                        $strimg .
                        $page->getText(), $config, 'UTF8');
                $tidy->cleanRepair();
                fwrite($fp, $tidy);
                fclose($fp);

                $ebook->addContentFile($chapterpath . ($i + 1) . ($j + 1) . '.xhtml', 'page' . ($i + 1) . ($j + 1), 'application/xhtml+xml');
                $navPoint = new navPoint();
                $navPoint->setId('page' . ($i + 1) . ($j + 1));
                $navPoint->setNavLabel($page->getTitle());
                $navPoint->setContent(($i + 1) . ($j + 1) . '.xhtml');
                $innerTocElements[] = $navPoint;
                $spine[] = 'page' . ($i + 1) . ($j + 1);
            }
            $ebook->addTocElement('chapter' . ($i + 1), ($i + 1) . '. ' . $chapter->getName(), ($i + 1) . '.xhtml', $innerTocElements);
            $innerTocElements = '';
        }
        $ebook->setSpine($spine);

        Loader::RequireOnce('modules/Books/includes/utils.php');
        // images
        copydir(ModUtil::getVar('books', 'serverImageFolder') . '/' . $this->schoolCode . '_' . $this->bookId, $ebook->getContentLoc() . 'images');

        $ebook->buildEPUB('book.' . $this->bookId, $filename);

        return ($filename . 'book.' . $this->bookId . '.epub');
    }

    /**
     * saves the book object as SCORM file in the specified path
     * @author:	Francesc Bassas i Bullich
     * @param:	
     * @return:	returns true on success or false on failure
     */
    public function book2scorm($path, $filename) {
        // imsmanifest.xml
        $entry = $this->book2imsmanifest($path, 'imsmanifest.xml');
        // metadata.xml
        $this->book2metadata($path, 'metadata.xml', $entry);

        $this->book2html($path . 'llibre/');

        Loader::RequireOnce("modules/Books/includes/pclzip.lib.php");
        $file = new PclZip($path . $filename);

        $v_list = $file->add($path . 'llibre/', PCLZIP_OPT_REMOVE_PATH, $path);
        if ($v_list == 0) {
            return LogUtil::registerError('Error : ' . $file->errorInfo(true));
        }

        $zip = new ZipArchive;
        if ($zip->open($path . $filename, ZIPARCHIVE::CREATE) === TRUE) {
            $zip->addFile($path . 'imsmanifest.xml', 'imsmanifest.xml');
            $zip->addFile($path . 'metadata.xml', 'metadata.xml');
            $zip->close();
        } else {
            return LogUtil::registerError('Error al crear el zip.');
        }

        unlink($path . 'imsmanifest.xml');
        unlink($path . 'metadata.xml');
        Loader::loadClass('FileUtil');
        FileUtil::deldir($path . 'llibre/');

        return $entry;
    }

    /**
     * 
     * @author:	Francesc Bassas i Bullich
     * @param:	
     * @return:	
     */
    private function book2imsmanifest($path, $filename) {
        $dom = new DOMDocument('1.0', 'UTF-8');

        $dom->formatOutput = true;

        $random = time();

        // manifest
        $manifest = $dom->createElement('manifest');
        $dom->appendChild($manifest);

        // attributes
        // identifier
        $manifest->setAttribute('identifier', 'llibres_' . $this->getBookId() . '_xtec' . $random++);

        // xmlns
        $manifest->setAttribute('xmlns', 'http://www.imsglobal.org/xsd/imscp_v1p1');

        // xmlns:adlcp
        $manifest->setAttribute('xmlns:adlcp', 'http://www.adlnet.org/xsd/adlcp_v1p3');

        // xmlns:xsi
        $manifest->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');

        // xsi:schemaLocation
        $manifest->setAttribute('xsi:schemaLocation', 'http://www.imsglobal.org/xsd/imscp_v1p1 schema/imscp_v1p1.xsd http://www.adlnet.org/xsd/adlcp_v1p3 schema/adlcp_v1p3.xsd');

        // metadata
        $metadata = $dom->createElement('metadata');
        $manifest->appendChild($metadata);

        // schema
        $item = $dom->createElement('schema', 'ADL SCORM');
        $metadata->appendChild($item);

        // schemaversion
        $item = $dom->createElement('schemaversion', '2004 4th Edition');
        $metadata->appendChild($item);

        // adlcp:location
        $item = $dom->createElement('adlcp:location', 'metadata.xml');
        $metadata->appendChild($item);

        // organizations
        $organizations = $dom->createElement('organizations');
        $manifest->appendChild($organizations);

        $organizationidentifier = 'llibres_' . $this->getBookId() . '_xtec' . $random++;

        // attributes
        // default
        $organizations->setAttribute('default', $organizationidentifier);

        // organization
        $organization = $dom->createElement('organization');
        $organizations->appendChild($organization);

        // attributes
        // identifier
        $organization->setAttribute('identifier', $organizationidentifier);

        // structure
        $organization->setAttribute('structure', 'hierarchical');

        // title
        $item = $dom->createElement('title', $this->getBookTitle());
        $organization->appendChild($item);

        // resources
        $resources = $dom->createElement('resources');
        $manifest->appendChild($resources);

        // item
        $itembook = $dom->createElement('item');
        $organization->appendChild($itembook);

        // attributes
        // identifier
        $itembook->setAttribute('identifier', 'ITEM-' . 'llibres_' . $this->getBookId() . '_xtec' . $random);

        // isvisible
        $itembook->setAttribute('isvisible', 'true');

        // identifierref
        $indentifierref = 'RES-' . 'llibres_' . $this->getBookId() . '_xtec' . $random++;

        $itembook->setAttribute('identifierref', $indentifierref);

        // title
        $item = $dom->createElement('title', $this->getBookTitle());
        $itembook->appendChild($item);

        // resource
        $resource = $dom->createElement('resource');
        $resources->appendChild($resource);

        // attributes
        // identifier
        $resource->setAttribute('identifier', $indentifierref);

        // type
        $resource->setAttribute('type', 'webcontent');

        // adlcp:scormtype
        $resource->setAttribute('adlcp:scormtype', 'asset');

        // href
        $resource->setAttribute('href', 'llibre/descripcio.html');

        // file
        $file = $dom->createElement('file');
        $resource->appendChild($file);

        // attributes
        // href
        $file->setAttribute('href', 'llibre/descripcio.html');

        // FOR EACH CHAPTER

        foreach ($this->chapters as $i => $chapter) {

            // item
            $itemchapter = $dom->createElement('item');
            $itembook->appendChild($itemchapter);

            // attributes
            // identifier
            $itemchapter->setAttribute('identifier', 'ITEM-' . 'llibres_' . $this->getBookId() . '_xtec' . $random);

            // isvisible
            $itemchapter->setAttribute('isvisible', 'true');

            // identifierref
            $indentifierref = 'RES-' . 'llibres_' . $this->getBookId() . '_xtec' . $random++;

            $itemchapter->setAttribute('identifierref', $indentifierref);

            // title
            $item = $dom->createElement('title', $chapter->getName());
            $itemchapter->appendChild($item);

            // resource
            $resource = $dom->createElement('resource');
            $resources->appendChild($resource);

            // attributes
            // identifier
            $resource->setAttribute('identifier', $indentifierref);

            // type
            $resource->setAttribute('type', 'webcontent');

            // adlcp:scormtype
            $resource->setAttribute('adlcp:scormtype', 'asset');

            // href
            $resource->setAttribute('href', 'llibre/capitol' . ($i + 1) . '-descripcio.html');

            // file
            $file = $dom->createElement('file');
            $resource->appendChild($file);

            // attributes
            // href
            $file->setAttribute('href', 'llibre/capitol' . ($i + 1) . '-descripcio.html');


            // FOR EACH PAGE
            foreach ($chapter->getPages() as $j => $page) {

                // item
                $itempage = $dom->createElement('item');
                $itemchapter->appendChild($itempage);

                // attributes
                // identifier
                $itempage->setAttribute('identifier', 'ITEM-' . 'llibres_' . $this->getBookId() . '_xtec' . $random);

                // isvisible
                $itempage->setAttribute('isvisible', 'true');

                // identifierref
                $indentifierref = 'RES-' . 'llibres_' . $this->getBookId() . '_xtec' . $random++;

                $itempage->setAttribute('identifierref', $indentifierref);

                // title
                $item = $dom->createElement('title', $page->getTitle());
                $itempage->appendChild($item);

                // resource
                $resource = $dom->createElement('resource');
                $resources->appendChild($resource);

                // attributes
                // identifier
                $resource->setAttribute('identifier', $indentifierref);

                // type
                $resource->setAttribute('type', 'webcontent');

                // adlcp:scormtype
                $resource->setAttribute('adlcp:scormtype', 'asset');

                // href
                $resource->setAttribute('href', 'llibre/capitol' . ($i + 1) . '-pagina' . ($j + 1) . '.html');

                // file
                $file = $dom->createElement('file');
                $resource->appendChild($file);

                // attributes
                // href
                $file->setAttribute('href', 'llibre/capitol' . ($i + 1) . '-pagina' . ($j + 1) . '.html');
            }
        }

        if (!$dom->save($path . $filename)) {
            return LogUtil::registerError('No s\'ha pogut generar el fitxer xml.');
        }

        return $organizationidentifier;
    }

    /**
     * 
     * @author:	Francesc Bassas i Bullich
     * @param:	
     * @return:	
     */
    private function book2metadata($path, $filename, $entry) {
        $dom = new DOMDocument('1.0', 'UTF-8');

        $dom->formatOutput = true;

        $random = time();

        // lom
        $lom = $dom->createElement('lom');
        $dom->appendChild($lom);

        // attributes
        // xmlns
        $lom->setAttribute('xmlns', 'http://ltsc.ieee.org/xsd/LOM');

        // xmlns:xsi
        $lom->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');

        // xsi:schemaLocation
        $lom->setAttribute('xsi:schemaLocation', 'http://ltsc.ieee.org/xsd/LOM schema/lom.xsd');

        // general
        $general = $dom->createElement('general');
        $lom->appendChild($general);

        // identifier
        $identifier = $dom->createElement('identifier');
        $general->appendChild($identifier);

        // catalog
        $item = $dom->createElement('catalog', 'PRESTATGERIA_XTEC');
        $identifier->appendChild($item);

        // entry
        $item = $dom->createElement('entry', $entry);
        $identifier->appendChild($item);

        // title
        $title = $dom->createElement('title');
        $general->appendChild($title);

        // string
        $item = $dom->createElement('string', $this->getBookTitle());
        $title->appendChild($item);

        // attributes
        // language
        $item->setAttribute('language', $this->getLang());

        // language
        $item = $dom->createElement('language', $this->getLang());
        $general->appendChild($item);

        // description
        $description = $dom->createElement('description');
        $general->appendChild($description);

        // string
        $item = $dom->createElement('string', $this->getAbout());
        $description->appendChild($item);

        // attributes
        // language
        $item->setAttribute('language', $this->getLang());

        // lifeCycle
        $lifeCycle = $dom->createElement('lifeCycle');
        $lom->appendChild($lifeCycle);

        // status
        $status = $dom->createElement('status');
        $lifeCycle->appendChild($status);

        // source
        $item = $dom->createElement('source', 'LOMv1.0');
        $status->appendChild($item);

        // value
        $item = $dom->createElement('value', 'final');
        $status->appendChild($item);

        // contribute
        $contribute = $dom->createElement('contribute');
        $lifeCycle->appendChild($contribute);

        // role
        $role = $dom->createElement('role');
        $contribute->appendChild($role);

        // source
        $item = $dom->createElement('source', 'LOMv1.0');
        $role->appendChild($item);

        // value
        $item = $dom->createElement('value', 'author');
        $role->appendChild($item);

        // entity
        //$item = $dom->createElement('entity', 'BEGIN:VCARD VERSION:3.0 FN: ' .            . ' EMAIL;TYPE=INTERNET: ' . $this->getAdminEmail() . ' ORG:Departament d\'Educació END:VCARD');
        //$contribute->appendChild($item);
        // date
        //$date = $dom->createElement('date');
        //$contribute->appendChild($date);
        // dateTime
        //$item = $dom->createElement('dateTime',          );
        //$date->appendChild($item);
        // contribute
        $contribute = $dom->createElement('contribute');
        $lifeCycle->appendChild($contribute);

        // role
        $role = $dom->createElement('role');
        $contribute->appendChild($role);

        // source
        $item = $dom->createElement('source', 'LOMv1.0');
        $role->appendChild($item);

        // value
        $item = $dom->createElement('value', 'publisher');
        $role->appendChild($item);

        // entity
        //$item = $dom->createElement('entity', 'BEGIN:VCARD VERSION:3.0 FN: ' .            . ' EMAIL;TYPE=INTERNET: ' . $this->getAdminEmail() . ' ORG:Departament d\'Educació END:VCARD');
        //$contribute->appendChild($item);
        // date
        //$date = $dom->createElement('date');
        //$contribute->appendChild($date);
        // dateTime
        //$item = $dom->createElement('dateTime',          );
        //$date->appendChild($item);
        // metaMetadata
        $metaMetadata = $dom->createElement('metaMetadata');
        $lom->appendChild($metaMetadata);

        // identifier
        $identifier = $dom->createElement('identifier');
        $metaMetadata->appendChild($identifier);

        // catalog
        $item = $dom->createElement('catalog', 'PRESTATGERIA_XTEC');
        $identifier->appendChild($item);

        // entry
        $item = $dom->createElement('entry', $entry);
        $identifier->appendChild($item);

        // contribute
        $contribute = $dom->createElement('contribute');
        $metaMetadata->appendChild($contribute);

        // role
        $role = $dom->createElement('role');
        $contribute->appendChild($role);

        // source
        $item = $dom->createElement('source', 'LOMv1.0');
        $role->appendChild($item);

        // value
        $item = $dom->createElement('value', 'creator');
        $role->appendChild($item);

        // entity
        //$item = $dom->createElement('entity', 'BEGIN:VCARD VERSION:3.0 FN: ' .            . ' EMAIL;TYPE=INTERNET: ' . $this->getAdminEmail() . ' ORG:Departament d\'Educació END:VCARD');
        //$contribute->appendChild($item);
        // date
        //$date = $dom->createElement('date');
        //$contribute->appendChild($date);
        // dateTime
        //$item = $dom->createElement('dateTime',          );
        //$date->appendChild($item);
        // language
        $item = $dom->createElement('language', $this->getLang());
        $metaMetadata->appendChild($item);

        // thecnical
        $thecnical = $dom->createElement('thecnical');
        $lom->appendChild($thecnical);

        // format
        $item = $dom->createElement('format', 'text/html');
        $thecnical->appendChild($item);

        // location
        //$item = $dom->createElement('location',        );
        //$thecnical->appendChild($item);
        // educational
        $educational = $dom->createElement('educational');
        $lom->appendChild($educational);

        // learningResourceType
        $learningResourceType = $dom->createElement('learningResourceType');
        $educational->appendChild($learningResourceType);

        // source
        $item = $dom->createElement('source', 'LOMv1.0');
        $learningResourceType->appendChild($item);

        // value
        $item = $dom->createElement('value', 'lecture');
        $learningResourceType->appendChild($item);

        // intendedEndUserRole
        $intendedEndUserRole = $dom->createElement('intendedEndUserRole');
        $educational->appendChild($intendedEndUserRole);

        // source
        $item = $dom->createElement('source', 'LOMv1.0');
        $intendedEndUserRole->appendChild($item);

        // value
        $item = $dom->createElement('value', 'learner');
        $intendedEndUserRole->appendChild($item);

        // context
        $context = $dom->createElement('context');
        $educational->appendChild($context);

        // source
        $item = $dom->createElement('source', 'LOMv1.0');
        $context->appendChild($item);

        // value
        $item = $dom->createElement('value', 'school');
        $context->appendChild($item);

        // rights
        $rights = $dom->createElement('rights');
        $lom->appendChild($rights);

        // cost
        $cost = $dom->createElement('cost');
        $rights->appendChild($cost);

        // source
        $item = $dom->createElement('source', 'LOMv1.0');
        $cost->appendChild($item);

        // value
        $item = $dom->createElement('value', 'no');
        $cost->appendChild($item);

        // copyrightAndOtherRestrictions
        $copyrightAndOtherRestrictions = $dom->createElement('copyrightAndOtherRestrictions');
        $rights->appendChild($copyrightAndOtherRestrictions);

        // source
        $item = $dom->createElement('source', 'LOMv1.0');
        $copyrightAndOtherRestrictions->appendChild($item);

        // value
        $item = $dom->createElement('value', 'yes');
        $copyrightAndOtherRestrictions->appendChild($item);

        // description
        $description = $dom->createElement('description');
        $rights->appendChild($description);

        // string
        $item = $dom->createElement('string', 'No es permet un ús comercial de l\'obra original ni de les possibles obres derivades, la distribució de les quals s\'ha de fer amb una llicència igual a la que regula l\'obra original.');
        $description->appendChild($item);

        // attributes
        // language
        $item->setAttribute('language', 'ca');

        // string
        $item = $dom->createElement('string', 'CC: Reconeixement - NoComercial - CompartirIgual (by-nc-sa)');
        $description->appendChild($item);

        // attributes
        // language
        $item->setAttribute('language', 'x-t-cc');

        // string
        $item = $dom->createElement('string', 'http://creativecommons.org/licenses/by-nc-sa/2.5/es/deed.ca');
        $description->appendChild($item);

        // attributes
        // language
        $item->setAttribute('language', 'x-t-cc-url');


        if (!$dom->save($path . $filename)) {
            return LogUtil::registerError('No s\'ha pogut generar el fitxer xml.');
        }
    }

    /**
     * creates a DOMNode instance of the book object
     * @author:	Francesc Bassas i Bullich
     * @param:	dom		DOMDocument instance
     * @return:	returns a DOMNode instance of the book
     */
    private function book2DOMNode($dom) {
        $bookNode = $dom->createElement('book');

        // bookId
        $item = $dom->createElement('id');
        $bookNode->appendChild($item);

        $data = $dom->createTextNode($this->bookId);
        $item->appendChild($data);

        // schoolCode
        $item = $dom->createElement('schoolCode');
        $bookNode->appendChild($item);

        $data = $dom->createTextNode($this->schoolCode);
        $item->appendChild($data);

        // bookTitle
        $item = $dom->createElement('bookTitle');
        $bookNode->appendChild($item);

        $data = $dom->createCDATASection($this->bookTitle);
        $item->appendChild($data);

        // overview
        $item = $dom->createElement('overview');
        $bookNode->appendChild($item);

        $data = $dom->createCDATASection($this->overview);
        $item->appendChild($data);

        // image
        $item = $dom->createElement('image');
        $bookNode->appendChild($item);

        $data = $dom->createTextNode($this->image);
        $item->appendChild($data);

        // about
        $item = $dom->createElement('about');
        $bookNode->appendChild($item);

        $data = $dom->createCDATASection(($this->about));
        $item->appendChild($data);

        // adminEmail
        $item = $dom->createElement('adminEmail');
        $bookNode->appendChild($item);

        $data = $dom->createTextNode($this->adminEmail);
        $item->appendChild($data);

        // showSearch
        $item = $dom->createElement('showSearch');
        $bookNode->appendChild($item);

        $data = $dom->createTextNode($this->showSearch);
        $item->appendChild($data);

        // lang
        $item = $dom->createElement('lang');
        $bookNode->appendChild($item);

        $data = $dom->createTextNode($this->lang);
        $item->appendChild($data);

        // theme
        $item = $dom->createElement('theme');
        $bookNode->appendChild($item);

        $data = $dom->createTextNode($this->theme);
        $item->appendChild($data);

        // htmlEditor
        $item = $dom->createElement('htmlEditor');
        $bookNode->appendChild($item);

        $data = $dom->createTextNode($this->htmlEditor);
        $item->appendChild($data);

        // descriptors
        $item = $dom->createElement('descriptors');
        $bookNode->appendChild($item);

        $data = $dom->createCDATASection($this->descriptors);
        $item->appendChild($data);

        // chapters
        $chapters = $dom->createElement('chapters');
        $bookNode->appendChild($chapters);

        foreach ($this->getChapters() as $chapter) {
            $chapters->appendChild($chapter->chapter2DOMNode($dom));
        }

        return $bookNode;
    }

    /**
     * 
     * @author:	Francesc Bassas i Bullich
     * @param:	
     * @return:	
     */
    public function replaceImageFolder($original_folder, $new_folder) {
        foreach ($this->chapters as $i => $chapter) {
            $chapter->replaceImageFolder($original_folder, $new_folder);
            $this->setChapter($i, $chapter);
        }
    }

}

?>
