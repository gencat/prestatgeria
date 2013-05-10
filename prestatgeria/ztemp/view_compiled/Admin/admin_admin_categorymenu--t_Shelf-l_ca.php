<?php /* Smarty version 2.6.26, created on 2013-05-07 11:35:50
         compiled from admin_admin_categorymenu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'ajaxheader', 'admin_admin_categorymenu.tpl', 1, false),array('function', 'gt', 'admin_admin_categorymenu.tpl', 4, false),array('function', 'modurl', 'admin_admin_categorymenu.tpl', 5, false),array('function', 'helplink', 'admin_admin_categorymenu.tpl', 52, false),array('modifier', 'safetext', 'admin_admin_categorymenu.tpl', 9, false),array('modifier', 'json_encode', 'admin_admin_categorymenu.tpl', 37, false),array('modifier', 'escape', 'admin_admin_categorymenu.tpl', 37, false),array('insert', 'getstatusmsg', 'admin_admin_categorymenu.tpl', 36, false),)), $this); ?>
<?php echo smarty_function_ajaxheader(array('modname' => 'Admin','filename' => 'admin_admin_ajax.js','ui' => true), $this);?>


<div class="z-admin-breadcrumbs">
    <span class="z-sub"><?php echo smarty_function_gt(array('text' => 'You are in:'), $this);?>
</span>
    <span class="z-breadcrumb"><a href="<?php echo smarty_function_modurl(array('modname' => 'Admin','type' => 'admin','func' => 'adminpanel'), $this);?>
"><?php echo smarty_function_gt(array('text' => 'Administration'), $this);?>
</a></span>

    <span class="z-sub">&raquo;</span>
    <?php if ($this->_tpl_vars['func'] != 'adminpanel'): ?>
        <span class="z-breadcrumb"><a href="<?php echo smarty_function_modurl(array('modname' => 'Admin','type' => 'admin','func' => 'adminpanel','acid' => $this->_tpl_vars['currentcat']), $this);?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['menuoptions'][$this->_tpl_vars['currentcat']]['title'])) ? $this->_run_mod_handler('safetext', true, $_tmp) : smarty_modifier_safetext($_tmp)); ?>
</a></span>
    <?php else: ?>
        <span class="z-breadcrumb"><?php echo ((is_array($_tmp=$this->_tpl_vars['menuoptions'][$this->_tpl_vars['currentcat']]['title'])) ? $this->_run_mod_handler('safetext', true, $_tmp) : smarty_modifier_safetext($_tmp)); ?>
</span>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['func'] != 'adminpanel'): ?>
        <span class="z-sub">&raquo;</span>
        <?php $_from = $this->_tpl_vars['menuoptions'][$this->_tpl_vars['currentcat']]['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['moditem']):
?>
            <?php if ($this->_tpl_vars['toplevelmodule'] == $this->_tpl_vars['moditem']['modname']): ?>
                <span class="z-breadcrumb"><a href="<?php echo smarty_function_modurl(array('modname' => $this->_tpl_vars['toplevelmodule'],'type' => 'admin','func' => 'main'), $this);?>
" class="z-admin-pagemodule"><?php echo ((is_array($_tmp=$this->_tpl_vars['moditem']['menutext'])) ? $this->_run_mod_handler('safetext', true, $_tmp) : smarty_modifier_safetext($_tmp)); ?>
</a></span>
                <?php break; ?>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>

        <?php if ($this->_tpl_vars['func'] != 'main'): ?>
            <span class="z-sub">&raquo;</span>
            <span class="z-breadcrumb z-admin-pagefunc"><?php echo ((is_array($_tmp=$this->_tpl_vars['func'])) ? $this->_run_mod_handler('safetext', true, $_tmp) : smarty_modifier_safetext($_tmp)); ?>
</span>
        <?php endif; ?>
    <?php endif; ?>
</div>

<div id="admin-systemnotices">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_admin_securityanalyzer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_admin_developernotices.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_admin_updatechecker.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>

<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getstatusmsg')), $this); ?>

<input type="hidden" name="admintabs-menuoptions" id="admintabs-menuoptions" value="<?php echo ((is_array($_tmp=json_encode($this->_tpl_vars['menuoptions']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
<div class="admintabs-container" id="admintabs-container">
    <ul id="admintabs" class="z-clearfix">
        <?php $_from = $this->_tpl_vars['menuoptions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['menuoption'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menuoption']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['menuoption']):
        $this->_foreach['menuoption']['iteration']++;
?>
        <li id="admintab_<?php echo $this->_tpl_vars['menuoption']['cid']; ?>
" class="admintab <?php if ($this->_tpl_vars['currentcat'] == $this->_tpl_vars['menuoption']['cid']): ?> active<?php endif; ?>" style="z-index:0;">
            <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['menuoption']['url'])) ? $this->_run_mod_handler('safetext', true, $_tmp) : smarty_modifier_safetext($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['menuoption']['description'])) ? $this->_run_mod_handler('safetext', true, $_tmp) : smarty_modifier_safetext($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['menuoption']['title'])) ? $this->_run_mod_handler('safetext', true, $_tmp) : smarty_modifier_safetext($_tmp)); ?>
</a>
            <span class="z-admindrop">&nbsp;</span>
        </li>
        <?php endforeach; endif; unset($_from); ?>
        <li id="addcat">
            <a id="addcatlink" href="<?php echo smarty_function_modurl(array('modname' => 'Admin','type' => 'admin','func' => 'new'), $this);?>
" title="<?php echo smarty_function_gt(array('text' => 'New module category'), $this);?>
">&nbsp;</a>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_admin_ajaxAddCategory.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </li>
    </ul>

    <?php echo smarty_function_helplink(array(), $this);?>

</div>

<div class="z-hide" id="admintabs-none"></div>