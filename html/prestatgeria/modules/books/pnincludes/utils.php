<?php

	/**
	 * 
	 * @author:	Francesc Bassas i Bullich
	 * @param:	
	 * @return:	
	*/
	function copydir($dirsource,$dirdest)
	{
		if(is_dir($dirsource)) {
			$dir_handle=opendir($dirsource);
		}
		
		mkdir($dirdest);
		
		while($file=readdir($dir_handle)) {
			if($file!="." && $file!="..") {
				if(!is_dir($dirsource."/".$file)) copy ($dirsource."/".$file, $dirdest. "/" .$file);
				else copydir($dirsource."/".$file, $dirdest."/".$file);
			}
		} 
		closedir($dir_handle); 
		return true; 
	}

?>