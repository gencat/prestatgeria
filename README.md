La Prestatgeria
===============

System based on MyScrapBook to allow teachers and students create simple books. Developed by the Ministry of Education of the Government of Catalonia.

There are three apps in La Prestatgeria
    
    A. Portal and book manager (Zikula)
    B. Book viewer and editor (MyScrapBook)
    C. FAQ system



Requirements
===============

    - Apache + PHP (4.3 o above) + MySQL 5.x

    - Apache mod_rewrite

    - PHP extensions:
       * gd, mbstring, tokenizer (Zikula)
       * zip, tidy, dom (Module Books in Zikula)
       * soap (Module XTEC Mailer in Zikula)
    
    - PHP configuration:
       * short_open_tag = On

Note: Zikula modules for Mail and LDAP are customized for XTEC servers needs and are likely not working in any other environment.



Installation
===============

1.- Copy files:

    Copy all files in branch master to the server. Directory html is public directory.


2.- Soft link creation:

    Create the following soft links:
	
	* $HOME/html/centres => $HOME/centres/
	* $HOME/html/prestatgeria/ztemp => $HOME/ztemp/
	* $HOME/html/pmf/templates_c => $HOME/templates_c/
        * $HOME/html/pmf/images => $HOME/images/
        * $HOME/html/rss => $HOME/rss/


3.- Change file system permissions		

    The following directories must be writeable by Apache

	* $HOME/centres/        - Books images
	* $HOME/ztemp/          - Zikula temporary files
	* $HOME/templates_c/	- FAQ temporary files
	* $HOME/images/         - FAQ images
	* $HOME/rss/            - Books RSS
	
	
4.-	Configuration

    * Rename $HOME/html/.htaccess-dist to $HOME/html/.htaccess and set the value of RewriteBase
    * Rename $HOME/html/env-config.php.dist to $HOME/html/env-config.php and set values


5.- Install CMS Zikula			

    * Execute html/prestatgeria/install.php to install Zikula. When finished, create blocks of module Books in side bars.



Production site
================

http://apliense.xtec.cat/prestatgeria 

Note: The production site content is only in catalan. Also, some parts of the code are not avalaible in any other language.


