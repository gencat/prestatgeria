<?php

/**
* Navigation Center eXtended
*/
class ncx {
	private $ncx; // Path on the server to the .ncx file
    private $version = '2005-1'; // Specifies the version of the DTD used in this instance
    private $xmlns = 'http://www.daisy.org/z3986/2005/ncx/'; // Specifies the default XML namespace for all elements in the NCX
    private $head; // Contains metadata
	private $docTitle; // The title of the document, presented as text and, optionally, in audio or image renderings, for presentation to the reader.
	private $navMap; // Container for primary navigation information
	
	private $playOrder = 1;
	
	public function getNcxPath(){return $this->ncx;}
	
	public function setNcxPath($path){$this->ncx = $path;}	
	public function setVersion($version){$this->version = $version;}	
	public function setXmlns($xmlns){$this->xmlns = $xmlns;}
	
	public function addMeta($name,$content){
		$meta = new meta();
		$meta->setName($name);
		$meta->setContent($content);
		$this->head[] = $meta;
	}
	
	public function setDocTitle($docTitle){$this->docTitle = $docTitle;}

	public function addNavPoint($id,$navLabel,$content,$innerNavPoints){
		$navPoint = new navPoint();
		$navPoint->setId($id);
		$navPoint->setPlayOrder($this->playOrder);
		$this->playOrder += 1;
		$navPoint->setNavLabel($navLabel);
		$navPoint->setContent($content);
		foreach ($innerNavPoints as $innerNavPoint){
			$navPoint->addInnerNavPoint($innerNavPoint->getId(), $innerNavPoint->getNavLabel(), $innerNavPoint->getContent(),$this->playOrder);
			$this->playOrder += 1;
		}
		$this->navMap[] = $navPoint;
	}
	
 	public function writeNCX(){
		foreach ($this->head as $meta) {
			$head .= $meta->writeMeta();
		}
		foreach ($this->navMap as $navPoint) {
			$navMap .=	$navPoint->writeNavPoint();
		}
		return	utf8_encode("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
				"<ncx xmlns=\"" . $this->xmlns . "\" version=\"" . $this->version . "\">\n" .
					"\t<head>\n" .
						$head .
					"\t</head>\n" .
					"\t<docTitle>\n" .
						"\t\t<text>" . $this->docTitle . "</text>\n" .
					"\t</docTitle>\n" .
					"\t<navMap>\n" .
						$navMap .
					"\t</navMap>\n" .
				"</ncx>\n")
				;
 	}		
}

/**
 * Contains metadata applicable to the NCX file
 */
class meta
{
    private $name;
    private $content;
	
	public function getName(){return $this->name;}	
	public function getContent(){return $this->content;}
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function setContent($content){
		$this->content = $content;
	}
	
 	public function writeMeta(){
 		return "\t\t<meta name=\"" . $this->getName() . "\" content=\"" . $this->getContent() . "\"/>\n";
 	}
}

/**
 * Contains description(s) of target and pointer to content.
 */
class navPoint
{
	private $id;
	private $playOrder;
	private $navLabel;
	private $content;
	private $innerNavPoints;
	
	public function getId(){return $this->id;}	
	public function getPlayOrder(){return $this->playOrder;}	
	public function getNavLabel(){return $this->navLabel;}
	public function getContent(){return $this->content;}
	
	public function setId($id){$this->id = $id;}
	public function setPlayOrder($playOrder){$this->playOrder = $playOrder;}
	public function setNavLabel($navLabel){$this->navLabel = $navLabel;}
	public function setContent($content){$this->content = $content;}
	
	public function addInnerNavPoint($id,$navLabel,$content,$playOrder){
		$navPoint = new navPoint();
		$navPoint->setId($id);
		$navPoint->setPlayOrder($playOrder);
		$navPoint->setNavLabel($navLabel);
		$navPoint->setContent($content);
		$this->innerNavPoints[] = $navPoint;
	}
	
	public function writeNavPoint(){
		foreach ($this->innerNavPoints as $navPoint) {
			$innerNavPoints .=	$navPoint->writeNavPoint();
		}
		return "\t\t<navPoint id=\"" . $this->getId() . "\" playOrder=\"" . $this->getPlayOrder() . "\">\n" .
					"\t\t\t<navLabel>\n" .
						"\t\t\t\t<text>" . $this->getNavLabel() . "</text>\n" .
					"\t\t\t</navLabel>\n" .
					"\t\t\t<content src=\"" . $this->getContent() . "\"/>\n" .
					$innerNavPoints .
				"\t\t</navPoint>\n"
				;
	}
}

?>