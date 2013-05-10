<?php /* Smarty version 2.6.26, created on 2013-05-07 11:35:50
         compiled from admin_admin_ajaxAddCategory.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'img', 'admin_admin_ajaxAddCategory.tpl', 5, false),array('modifier', 'gt', 'admin_admin_ajaxAddCategory.tpl', 5, false),)), $this); ?>
<div id="ajaxNewCatHidden" class="z-hide">
    <form id="ajaxNewCatForm" class="z-clearfix" action="#">
        <div>
            <input type="text" class="ajaxNewCat" name="name" id="ajaxNewCat" />&nbsp;
            <a href="#" class="ajaxCatImage save"><?php echo smarty_function_img(array('modname' => 'core','src' => "button_ok.png",'set' => "icons/extrasmall",'alt' => ((is_array($_tmp='Save')) ? $this->_run_mod_handler('gt', true, $_tmp, $this->_tpl_vars['zikula_view']) : smarty_modifier_gt($_tmp, $this->_tpl_vars['zikula_view'])),'height' => '13'), $this);?>
</a>
            <a href="#" class="ajaxCatImage cancel"><?php echo smarty_function_img(array('modname' => 'core','src' => "button_cancel.png",'set' => "icons/extrasmall",'alt' => ((is_array($_tmp='Cancel')) ? $this->_run_mod_handler('gt', true, $_tmp, $this->_tpl_vars['zikula_view']) : smarty_modifier_gt($_tmp, $this->_tpl_vars['zikula_view'])),'height' => '13'), $this);?>
</a>
        </div>
    </form>
</div>