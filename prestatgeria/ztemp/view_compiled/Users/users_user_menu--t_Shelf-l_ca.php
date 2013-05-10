<?php /* Smarty version 2.6.26, created on 2013-05-07 13:54:48
         compiled from users_user_menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'users_user_menu.tpl', 1, false),array('function', 'gt', 'users_user_menu.tpl', 2, false),array('function', 'pagesetvar', 'users_user_menu.tpl', 4, false),array('insert', 'getstatusmsg', 'users_user_menu.tpl', 8, false),)), $this); ?>
<?php if (((is_array($_tmp=@$this->_tpl_vars['templatetitle'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')) == ''): ?>
    <?php echo smarty_function_gt(array('text' => 'My account','assign' => 'templatetitle'), $this);?>

<?php endif; ?>
<?php echo smarty_function_pagesetvar(array('name' => 'title','value' => $this->_tpl_vars['templatetitle']), $this);?>


<h2><?php echo $this->_tpl_vars['templatetitle']; ?>
</h2>

<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getstatusmsg')), $this); ?>
