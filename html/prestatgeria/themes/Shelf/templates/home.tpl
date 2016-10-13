<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{lang}" lang="{lang}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset={charset}" />
        <meta name="description" content="{$modvars.ZConfig.slogan}" />
        <meta name="keywords" content="{$metatags.keywords}" />
        <meta name="robots" content="index, follow" />
        <meta name="author" content="{$modvars.ZConfig.sitename}" />
        <meta name="copyright" content="Copyright (c) 2009 by {$modvars.ZConfig.sitename}" />
        <meta name="generator" content="Zikula - http://zikula.org" />
        <meta http-equiv="X-UA-Compatible" content="chrome=1" />
        <title>{pagegetvar name='title'}</title>
        <link rel="icon" type="image/x-icon" href="{$imagepath}/favicon.ico" /> {* W3C *}
        <link rel="shortcut icon" type="image/ico" href="{$imagepath}/favicon.ico" /> {* IE *}
        <link rel="stylesheet" href="{$themepath}/style/{$stylesheet}" type="text/css" />
    </head>

    <body>
        <div id="wrapper">
            <div id="header">
                <div id="minilogoleft">
                    <a href="http://www.gencat.cat/educacio/" target="_blank">
                        <img src="{$themepath}/images/logo2.png" alt="" title="" />
                    </a>
                </div>
                <div id="minilogoright">
                    <a href="http://www.xtec.cat" target="_blank">
                        <img src="{$themepath}/images/logo3.png" alt="" title="" />
                    </a>
                </div>
                <div id="logoleft">
                    <a href="index.php">
                        <img src="{$themepath}/images/logo4.png" alt="" title="" />
                    </a>
                </div>
                <div id="logoright">
                    <a href="index.php">
                        <img src="{$themepath}/images/logo1.png" alt="" title="" />
                    </a>
                </div>
                <div id="menu">
                    <span class="menuitems">
                        {blockposition name=menu}
                        {userloggedin assign="logged"}
                        <a href="index.php">Inici</a>&nbsp;|&nbsp;
                        <a href="{modurl modname='Pages' type='user' func='display' pageid='1'}">Condicions d'&uacute;s</a>&nbsp;|&nbsp;
                        {if not $logged}
                            <a href="{modurl modname='Users' type='user' func='loginscreen'}">Entra</a>
                        {else}
                            <a href="{modurl modname='Users' type='user' func='logout'}">Surt</a>
                        {/if}
                    </span>
                </div>
                <div id="menubar">
                </div>
            </div>
            <div id="contentwrapper">
                <div id="contentcolumn">
                    <div id="z-maincontent" class="innertube">
                        {blockposition name=center}
                        {$maincontent}		
                    </div>
                </div>
            </div>
            <div id="leftcolumn">
                <div class="innertube">
                    {blockposition name=left}
                </div>
            </div>
            <div id="rightcolumn">
                <div class="innertube">
                    {blockposition name=right}
                </div>
            </div>
        </div>
        <div id="themefooter">
            {$footmesg}

            <!-- Nacho: added google analytics -->
            <script>
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

                if (window.location.href.indexOf('preproduccio') > -1) {
                    ga('create', 'UA-80974524-4', 'auto');
                }
                if(window.location.href.indexOf('apliense.xtec.cat') > -1) {
                    ga('create', 'UA-80974524-3', 'auto');
                }

                ga('send', 'pageview');

            </script>
            <!-- End Nacho -->

        </div>
    </body>

</html>
