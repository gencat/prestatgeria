<?php /* Smarty version 2.6.26, created on 2013-05-07 11:35:51
         compiled from master.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'master.tpl', 2, false),array('function', 'charset', 'master.tpl', 4, false),array('function', 'pagegetvar', 'master.tpl', 10, false),array('function', 'blockposition', 'master.tpl', 45, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo smarty_function_lang(array(), $this);?>
" lang="<?php echo smarty_function_lang(array(), $this);?>
">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo smarty_function_charset(array(), $this);?>
" />
        <meta name="description" content="<?php echo $this->_tpl_vars['modvars']['ZConfig']['slogan']; ?>
" />
        <meta name="robots" content="index, follow" />
        <meta name="author" content="<?php echo $this->_tpl_vars['modvars']['ZConfig']['sitename']; ?>
" />
        <meta name="copyright" content="Copyright (c) 2009 by <?php echo $this->_tpl_vars['modvars']['ZConfig']['sitename']; ?>
" />
        <meta name="generator" content="Zikula <?php echo $this->_tpl_vars['coredata']['version_num']; ?>
 - http://zikula.org" />
        <title><?php echo smarty_function_pagegetvar(array('name' => 'title'), $this);?>
</title>
        <link rel="icon" type="image/x-icon" href="<?php echo $this->_tpl_vars['imagepath']; ?>
/favicon.ico" />         <link rel="shortcut icon" type="image/ico" href="<?php echo $this->_tpl_vars['imagepath']; ?>
/favicon.ico" />         <link rel="stylesheet" href="<?php echo $this->_tpl_vars['themepath']; ?>
/style/<?php echo $this->_tpl_vars['stylesheet']; ?>
" type="text/css" />

        <style type="text/css"><?php echo '

        '; ?>
</style>
    </head>

    <body>
        <div id="wrapper">
            <div id="header">
                <div id="minilogoleft">
                    <a href="http://www.gencat.cat/educacio/" target="_blank">
                        <img src="<?php echo $this->_tpl_vars['themepath']; ?>
/images/logo2.png" alt="" title="" />
                    </a>
                </div>
                <div id="minilogoright">
                    <a href="http://www.xtec.cat" target="_blank">
                        <img src="<?php echo $this->_tpl_vars['themepath']; ?>
/images/logo3.png" alt="" title="" />
                    </a>
                </div>
                <div id="logoleft">
                    <a href="index.php">
                        <img src="<?php echo $this->_tpl_vars['themepath']; ?>
/images/logo4.png" alt="" title="" />
                    </a>
                </div>
                <div id="logoright">
                    <a href="index.php">
                        <img src="<?php echo $this->_tpl_vars['themepath']; ?>
/images/logo1.png" alt="" title="" />
                    </a>
                </div>
                <div id="menu">
                    <span class="menuitems">
                        <?php echo smarty_function_blockposition(array('name' => 'menu'), $this);?>

                        <a href="index.php">Inici</a>&nbsp;|&nbsp;
                        <a href="index.php?module=Pages&func=display&pageid=1">Condicions d'&uacute;s</a>&nbsp;|&nbsp;
                        <a href="http://phobos.xtec.cat/forum/viewforum.php?f=43" target="_blank">F&ograve;rum</a>
                    </span>
                </div>
                <div id="menubar">
                </div>
            </div>
            <div id="contentwrapper">
                <div id="contentcolumn">
                    <div class="innertube" id="theme_content">
                        <?php echo $this->_tpl_vars['maincontent']; ?>
		
                    </div>
                </div>
            </div>
            <div id="leftcolumn">
                <div class="innertube">
                    <?php echo smarty_function_blockposition(array('name' => 'left'), $this);?>

                </div>
            </div>
            <div id="rightcolumn">
                <div class="innertube">
                    <?php echo smarty_function_blockposition(array('name' => 'right'), $this);?>

                </div>
            </div>
        </div>
        <div id="themefooter">
            <?php echo $this->_tpl_vars['footmesg']; ?>

        </div>
    </body>

</html>