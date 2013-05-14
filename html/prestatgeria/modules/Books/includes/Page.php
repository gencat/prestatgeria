<?php

class Page
{
	private $title;
	private $text;
	private $author;
	private $email;
	private $webAddress;
	private $webName;
	private $updated;
	private $image;
	private $imageAlign;
	
	function __construct($title,$text,$author,$email,$webAddress,$webName,$updated,$image,$imageAlign) {
	    $this->title = $title;
	    $this->text = $text;
		$this->author = $author;
		$this->email = $email;
		$this->webAddress = $webAddress;
		$this->webName = $webName;
		$this->updated = $updated;
		$this->image = $image;
		$this->imageAlign = $imageAlign;
	}
	
	function getTitle() {return $this->title;}
	function getText() {return $this->text;}
	function getAuthor() {return $this->author;}
	function getEmail() {return $this->email;}
	function getWebAddress() {return $this->webAddress;}
	function getWebName() {return $this->webName;}
	function getUpdated() {return $this->updated;}
	function getApproved() {return $this->approved;}
	function getImage() {return $this->image;}
	function getImageAlign() {return $this->imageAlign;}

	function setTitle($title) {$this->title = $title;}
	function setText($text) {$this->text = $text;}
	function setAuthor($author) {$this->author = $author;}
	function setEmail($email) {$this->email = $email;}
	function setWebAddress($webAddress) {$this->webAddress = $webAddress;}
	function setWebName($webName) {$this->webName = $webName;}
	function setUpdated($updated) {$this->updated = $updated;}
	function setApproved($approved) {$this->approved = $approved;}
	function setImage($image) {$this->image = $image;}
	function setImageAlign($imageAlign) {$this->imageAlign = $imageAlign;}
	
	/**
	 * creates a DOMNode instance of the page
	 * @author:	Francesc Bassas i Bullich
	 * @param:	dom	DOMDocument instance
	 * @return:	returns a DOMNode instance of the page
	*/
	function page2DOMNode($dom)
	{

		$page = $dom->createElement('page');		

		// title
		$item = $dom->createElement('title');
		$page->appendChild($item);
		
		$data = $dom->createCDATASection($this->title);
		$item->appendChild($data);

		// text
		$item = $dom->createElement('text');
		$page->appendChild($item);

		$data = $dom->createCDATASection($this->text);
		$item->appendChild($data);
		
		// author
		$item = $dom->createElement('author');
		$page->appendChild($item);
		
		$data = $dom->createTextNode($this->author);
		$item->appendChild($data);
		
		// email
		$item = $dom->createElement('email');
		$page->appendChild($item);
		
		$data = $dom->createTextNode($this->email);
		$item->appendChild($data);
		
		// webAddress
		$item = $dom->createElement('webAddress');
		$page->appendChild($item);
		
		$data = $dom->createTextNode($this->webAddress);
		$item->appendChild($data);
		
		// webName
		$item = $dom->createElement('webName');
		$page->appendChild($item);
		
		$data = $dom->createTextNode($this->webName);
		$item->appendChild($data);
		
		// updated
		$item = $dom->createElement('updated');
		$page->appendChild($item);
		
		$data = $dom->createTextNode($this->updated);
		$item->appendChild($data);
		
		// image
		$item = $dom->createElement('image');
		$page->appendChild($item);
		
		$data = $dom->createTextNode($this->image);
		$item->appendChild($data);
		
		// imageAlign
		$item = $dom->createElement('imageAlign');
		$page->appendChild($item);
		
		$data = $dom->createTextNode($this->imageAlign);
		$item->appendChild($data);
		
		return $page;
	}
	
	/**
	 * import a page from a DOMNode instance of the page
	 * @author:	Francesc Bassas i Bullich
	 * @param:	pageNode	DOMNode instance of the page
	 * @return:	
	*/	
	function DOMNode2page($pageNode)
	{
		// title
		$nodes = $pageNode->getElementsByTagName('title');
		$node = $nodes->item(0);
		$value = $node->nodeValue;
		
		$this->setTitle($value);
		
		// text
		$nodes = $pageNode->getElementsByTagName('text');
		$node = $nodes->item(0);
		$value = $node->nodeValue;
		
		$this->setText($value);
		
		// author
		$nodes = $pageNode->getElementsByTagName('author');
		$node = $nodes->item(0);
		$value = $node->nodeValue;
		
		$this->setAuthor($value);
		
		// email
		$nodes = $pageNode->getElementsByTagName('email');
		$node = $nodes->item(0);
		$value = $node->nodeValue;
		
		$this->setEmail($value);
		
		// webAddress
		$nodes = $pageNode->getElementsByTagName('webAddress');
		$node = $nodes->item(0);
		$value = $node->nodeValue;
		
		$this->setWebAddress($value);

		// webName
		$nodes = $pageNode->getElementsByTagName('webName');
		$node = $nodes->item(0);
		$value = $node->nodeValue;
		
		$this->setWebName($value);

		// updated
		$nodes = $pageNode->getElementsByTagName('updated');
		$node = $nodes->item(0);
		$value = $node->nodeValue;
		
		$this->setUpdated($value);
		
		// image
		$nodes = $pageNode->getElementsByTagName('image');
		$node = $nodes->item(0);
		$value = $node->nodeValue;
		
		$this->setImage($value);
		
		// imageAlign
		$nodes = $pageNode->getElementsByTagName('imageAlign');
		$node = $nodes->item(0);
		$value = $node->nodeValue;
		
		$this->setImageAlign($value);		
	}

	/**
	 * 
	 * @author:	Francesc Bassas i Bullich
	 * @param:	
	 * @return:	
	*/
	public function replaceImageFolder($original_folder,$new_folder)
	{
		$text = str_replace($original_folder,$new_folder,$this->text);	// '../images/'));
		$this->setText($text);
		
	}

}

?>
