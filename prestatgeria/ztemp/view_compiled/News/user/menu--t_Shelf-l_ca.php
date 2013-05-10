<?php /* Smarty version 2.6.26, created on 2013-05-07 13:54:44
         compiled from user/menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'formutil_getpassedvalue', 'user/menu.tpl', 1, false),array('function', 'modgetname', 'user/menu.tpl', 5, false),array('function', 'servergetvar', 'user/menu.tpl', 8, false),array('function', 'pagesetvar', 'user/menu.tpl', 11, false),array('function', 'gt', 'user/menu.tpl', 18, false),array('function', 'modulelinks', 'user/menu.tpl', 20, false),array('modifier', 'replace', 'user/menu.tpl', 9, false),array('modifier', 'gt', 'user/menu.tpl', 11, false),array('modifier', 'default', 'user/menu.tpl', 13, false),)), $this); ?>
<?php echo smarty_function_formutil_getpassedvalue(array('name' => 'func','default' => 'main','noprocess' => true,'assign' => 'func'), $this);?>

<?php echo smarty_function_formutil_getpassedvalue(array('name' => 'theme','default' => '','noprocess' => true,'assign' => 'theme'), $this);?>


<?php echo smarty_function_modgetname(array('assign' => 'module'), $this);?>

<?php if ($this->_tpl_vars['module'] == 'News'): ?>
  <?php if ($this->_tpl_vars['func'] == 'main'): ?>
    <?php echo smarty_function_servergetvar(array('name' => 'REQUEST_URI','default' => '/','assign' => 'requesturi'), $this);?>

    <?php $this->assign('requesturi', ((is_array($_tmp=$this->_tpl_vars['requesturi'])) ? $this->_run_mod_handler('replace', true, $_tmp, $this->_tpl_vars['baseuri'], '') : smarty_modifier_replace($_tmp, $this->_tpl_vars['baseuri'], ''))); ?>
    <?php if ($this->_tpl_vars['requesturi'] != '/' && $this->_tpl_vars['requesturi'] != "/".($this->_tpl_vars['modvars']['ZConfig']['entrypoint'])): ?>
      <?php echo smarty_function_pagesetvar(array('name' => 'title','value' => ((is_array($_tmp='News')) ? $this->_run_mod_handler('gt', true, $_tmp, $this->_tpl_vars['zikula_view']) : smarty_modifier_gt($_tmp, $this->_tpl_vars['zikula_view']))), $this);?>

    <?php endif; ?>
  <?php elseif ($this->_tpl_vars['func'] == 'view' && ((is_array($_tmp=@$this->_tpl_vars['catname'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')) != ''): ?>
    <?php echo smarty_function_pagesetvar(array('name' => 'title','value' => $this->_tpl_vars['catname']), $this);?>

  <?php endif; ?>
<?php endif; ?>

<h2><?php echo smarty_function_gt(array('text' => 'News'), $this);?>
<?php if ($this->_tpl_vars['func'] == 'view' && ((is_array($_tmp=@$this->_tpl_vars['catname'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')) != ''): ?> &raquo; <?php echo $this->_tpl_vars['catname']; ?>
<?php endif; ?></h2>
<?php if ($this->_tpl_vars['theme'] != 'Printer'): ?>
<?php echo smarty_function_modulelinks(array('modname' => 'News','type' => 'user'), $this);?>

<?php endif; ?>