<?php
/**
 * Zikula Application Framework
 *
 * @copyright (c) 2001, Zikula Development Team
 * @link http://www.zikula.org
 * @version $Id: theme.php 24342 2008-06-06 12:03:14Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 */

$bgcolor1 = '#ffffff';
$bgcolor2 = '#cccccc';
$bgcolor3 = '#ffffff';
$bgcolor4 = '#eeeeee';
$bgcolor5 = '#000000';
$sepcolor = '#ffffff';
$textcolor1 = '#ffffff';
$textcolor2 = '#000000';

$postnuke_theme = true;

function OpenTable()
{
?>
  <div class="opentable">
<?php
}

function OpenTable2()
{
?>
  <div class="opentable2">
<?php
}

function CloseTable()
{
?>
  </div>
<?php
}

function CloseTable2()
{
?>
  </div>
<?php
}

function themeheader()
{
    $sitename = pnConfigGetVar('sitename');
    $banners = pnConfigGetVar('banners');
?>
  </head>
  <body>
  <div id="themesearch">
    <form method="post" action="index.php?module=Search&amp;type=user&amp;func=search">
      <div>
      <label for="theme_search"><?php echo _SEARCH?></label>
      <input id="theme_search" name="q" type="text" onblur="if (this.value=='')this.value='<?php echo _SEARCH ?>';" onclick="if (this.value=='<?php echo _SEARCH ?>'){this.value=''}" value="<?php echo _SEARCH?>" />
      </div>
    </form>
  </div>
  <div id="themelogo">
    <a href="index.php"><img src="images/logo.gif" alt= "" title="<?php echo pnML('_THEMEWELCOMETO', array('sitename' => $sitename));?>" /></a>
  </div>
  <div id="outer_wrapper">
    <div id="wrapper">
      <div id="container">
        <div id="content">
          <div id="left">
             <!-- Left Block Start -->
             <?php blocks('left');?>
             <!-- Left Block End -->
          </div>
          <div id="main">
<?php
        $module = FormUtil::getPassedValue('module', null, 'REQUEST');
        $name   = FormUtil::getPassedValue('name', null, 'REQUEST');
        if (!$module && !$name) {
          blocks('center');
        }
}

function themefooter()
{
?>
            </div>
          </div>
        </div>
        <div id="sidebar">
          <?php blocks('right');?>
        </div>
        <div class="clearing">&nbsp;</div>
      </div>
      <div id="themefooter">
        <div style="font-size:smaller"><?php echo _CMSHOMELINK; ?></div>
      </div>
    </div>
<?php
}

function themesidebox($block)
{
  if ($block['position'] == 'c' || $block['position'] == 'center') {
        if (!empty($block['title'])) {
    ?>
    <div class="centerblock"><strong><?php echo $block['title'];?></strong></div>
        <?php } ?>
    <div class="centerblock"><?php echo $block['content'];?></div>
    <br />
    <?php
  } else {
        if (!empty($block['title'])) {
    ?>
    <div class="sideblock"><strong><?php echo $block['title'].'&nbsp;&nbsp;'.$block['minbox'];?></strong></div>
        <?php } ?>
    <div class="sideblock"><?php echo $block['content'];?></div>
    <br />
    <?php
  }
}
