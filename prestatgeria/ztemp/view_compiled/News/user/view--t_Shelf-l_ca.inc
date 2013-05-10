<?php /* Smarty version 2.6.26, created on 2013-05-07 13:54:44
         compiled from user/view.tpl */

$this->_cache_serials['ztemp/view_compiled/News/user/view--t_Shelf-l_ca.inc'] = '513d70253a3c07afe4f5c71bb6b46184';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'nocache', 'user/view.tpl', 1, false),array('insert', 'getstatusmsg', 'user/view.tpl', 2, false),array('function', 'pager', 'user/view.tpl', 12, false),)), $this); ?>
<?php
function _smarty_tplfunc_513d70253a3c07afe4f5c71bb6b46184_0(&$_smarty)
{
$_smarty->_tag_stack[] = array('nocache', array()); $_block_repeat=true;Zikula_View_Resource::block_nocache($_smarty->_tag_stack[count($_smarty->_tag_stack)-1][1], null, $_smarty, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php $_smarty_tpl_vars = $_smarty->_tpl_vars;
$_smarty->_smarty_include(array('smarty_include_tpl_file' => 'user/menu.tpl', 'smarty_include_vars' => array()));
$_smarty->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo Zikula_View_Resource::block_nocache($_smarty->_tag_stack[count($_smarty->_tag_stack)-1][1], $_block_content, $_smarty, $_block_repeat); }  array_pop($_smarty->_tag_stack); 
}



?>
