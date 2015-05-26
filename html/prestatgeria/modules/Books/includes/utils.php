<?php

	/**
	 * 
	 * @author:	Francesc Bassas i Bullich
	 * @param:	
	 * @return:	
	*/
	function copydir($dirsource,$dirdest)
	{
            //XTEC ************ MODIFICAT - avoid  readdir throw a warning if null param given.It breaks exportation
            //2015.05.25 @author - Josep Caballero
            if(is_dir($dirsource)) {
		$dir_handle=opendir($dirsource);
            }else{
                mkdir($dirdest);
                $dir_handle = opendir($dirdest);
            }
            
            while($file=readdir($dir_handle)) {
                    if($file!="." && $file!="..") {
                            if(!is_dir($dirsource."/".$file)) copy ($dirsource."/".$file, $dirdest. "/" .$file);
                            else copydir($dirsource."/".$file, $dirdest."/".$file);
                    }
            } 
            closedir($dir_handle); 
            return true;
            //************ ORIGINAL
            /*
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
            */ 
            //************ FI
	}

?>