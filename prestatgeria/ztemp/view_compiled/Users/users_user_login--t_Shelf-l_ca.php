<?php /* Smarty version 2.6.26, created on 2013-05-07 13:54:48
         compiled from users_user_login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'ajaxheader', 'users_user_login.tpl', 5, false),array('function', 'gt', 'users_user_login.tpl', 8, false),array('function', 'modulelinks', 'users_user_login.tpl', 9, false),array('function', 'modurl', 'users_user_login.tpl', 17, false),array('function', 'authentication_method_selector', 'users_user_login.tpl', 23, false),array('function', 'login_form_fields', 'users_user_login.tpl', 30, false),array('function', 'notifyevent', 'users_user_login.tpl', 57, false),array('function', 'notifydisplayhooks', 'users_user_login.tpl', 67, false),array('function', 'button', 'users_user_login.tpl', 73, false),array('function', 'img', 'users_user_login.tpl', 79, false),array('modifier', 'cat', 'users_user_login.tpl', 5, false),array('modifier', 'default', 'users_user_login.tpl', 34, false),array('modifier', 'lower', 'users_user_login.tpl', 39, false),array('modifier', 'gt', 'users_user_login.tpl', 73, false),array('insert', 'csrftoken', 'users_user_login.tpl', 37, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['authentication_method_display_order']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['authentication_method_display_order'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['authentication_method_display_order']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['authentication_method']):
        $this->_foreach['authentication_method_display_order']['iteration']++;
?>
<?php if (( 'Users' != $this->_tpl_vars['authentication_method']['modname'] )): ?>
    <?php echo smarty_function_ajaxheader(array('modname' => $this->_tpl_vars['authentication_method']['modname'],'filename' => ((is_array($_tmp=$this->_tpl_vars['authentication_method']['modname'])) ? $this->_run_mod_handler('cat', true, $_tmp, '.Login.js') : smarty_modifier_cat($_tmp, '.Login.js'))), $this);?>

<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php echo smarty_function_gt(array('text' => 'User log-in','assign' => 'templatetitle'), $this);?>

<?php echo smarty_function_modulelinks(array('modname' => 'Users','type' => 'user'), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'users_user_menu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if (( count ( $this->_tpl_vars['authentication_method_display_order'] ) > 1 )): ?>
<div>
    <h5 id="users_login_h5_no_authentication_method"<?php if (! empty ( $this->_tpl_vars['selected_authentication_method'] )): ?> class="z-hide"<?php endif; ?>><?php echo smarty_function_gt(array('text' => "Choose how you would like to log in by clicking on one of the following..."), $this);?>
</h5>
    <h5 id="users_login_h5_authentication_method"<?php if (empty ( $this->_tpl_vars['selected_authentication_method'] )): ?> class="z-hide"<?php endif; ?>><?php echo smarty_function_gt(array('text' => "Log in below, or change how you would like to log in by clicking on one of the following..."), $this);?>
</h5>
    <h5 id="users_login_h5" class="z-hide"></h5>
    <div class="authentication_select_method_bigbutton">
    <?php echo smarty_function_modurl(array('modname' => 'Users','type' => 'user','func' => 'login','assign' => 'form_action'), $this);?>

    <?php $_from = $this->_tpl_vars['authentication_method_display_order']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['authentication_method_display_order'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['authentication_method_display_order']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['authentication_method']):
        $this->_foreach['authentication_method_display_order']['iteration']++;
?>
        <?php if ($this->_foreach['authentication_method_display_order']['iteration'] == 6): ?>
            </div>
            <div class="authentication_select_method_smallbutton z-clearer">
        <?php endif; ?>
        <?php echo smarty_function_authentication_method_selector(array('form_type' => 'loginscreen','form_action' => $this->_tpl_vars['form_action'],'authentication_method' => $this->_tpl_vars['authentication_method'],'selected_authentication_method' => $this->_tpl_vars['selected_authentication_method']), $this);?>

    <?php endforeach; endif; unset($_from); ?>
    </div>
</div>
<?php endif; ?>

<?php if (! empty ( $this->_tpl_vars['selected_authentication_method'] )): ?>
    <?php echo smarty_function_login_form_fields(array('form_type' => 'loginscreen','authentication_method' => $this->_tpl_vars['selected_authentication_method'],'assign' => 'login_form_fields'), $this);?>

<?php endif; ?>
<form id="users_login_login_form" class="z-form z-gap z-clearer<?php if (! isset ( $this->_tpl_vars['login_form_fields'] ) || empty ( $this->_tpl_vars['login_form_fields'] ) || ! isset ( $this->_tpl_vars['selected_authentication_method'] ) || empty ( $this->_tpl_vars['selected_authentication_method'] )): ?> z-hide<?php endif; ?>" action="<?php echo smarty_function_modurl(array('modname' => 'Users','type' => 'user','func' => 'login'), $this);?>
" method="post">
    <div>
        <input id="users_login_selected_authentication_module" type="hidden" name="authentication_method[modname]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['selected_authentication_method']['modname'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
" />
        <input id="users_login_selected_authentication_method" type="hidden" name="authentication_method[method]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['selected_authentication_method']['method'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
" />
        <input id="users_login_returnpage" type="hidden" name="returnpage" value="<?php echo $this->_tpl_vars['returnpage']; ?>
" />
        <input id="users_login_csrftoken" type="hidden" name="csrftoken" value="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'csrftoken')), $this); ?>
" />
        <input id="users_login_event_type" type="hidden" name="event_type" value="login_screen" />
        <?php if (( ((is_array($_tmp=$this->_tpl_vars['modvars']['ZConfig']['seclevel'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)) == 'high' )): ?>
        <input id="users_login_rememberme" type="hidden" name="rememberme" value="0" />
        <?php endif; ?>
        <fieldset>
            <div id="users_login_fields">
                <?php echo $this->_tpl_vars['login_form_fields']; ?>

            </div>
            <?php if (( ((is_array($_tmp=$this->_tpl_vars['modvars']['ZConfig']['seclevel'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)) != 'high' )): ?>
            <div class="z-formrow">
                <span class="z-formlist">
                    <input id="users_login_rememberme" type="checkbox" name="rememberme" value="1" />
                    <label for="users_login_rememberme"><?php echo smarty_function_gt(array('text' => 'Keep me logged in on this computer'), $this);?>
</label>
                </span>
            </div>
            <?php endif; ?>
        </fieldset>

        <?php if (isset ( $this->_tpl_vars['user_obj'] ) && ! empty ( $this->_tpl_vars['user_obj'] )): ?>
            <?php echo smarty_function_notifyevent(array('eventname' => 'module.users.ui.form_edit.login_screen','id' => $this->_tpl_vars['user_obj']['uid'],'eventsubject' => $this->_tpl_vars['user_obj'],'assign' => 'eventData'), $this);?>

        <?php else: ?>
            <?php echo smarty_function_notifyevent(array('eventname' => 'module.users.ui.form_edit.login_screen','assign' => 'eventData'), $this);?>

        <?php endif; ?>

        <?php $_from = $this->_tpl_vars['eventData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['eventDisplay']):
?>
            <?php echo $this->_tpl_vars['eventDisplay']; ?>

        <?php endforeach; endif; unset($_from); ?>
            
        <?php if (isset ( $this->_tpl_vars['user_obj'] ) && ! empty ( $this->_tpl_vars['user_obj'] )): ?>
            <?php echo smarty_function_notifydisplayhooks(array('eventname' => 'users.ui_hooks.login_block.form_edit','id' => $this->_tpl_vars['user_obj']['uid']), $this);?>

        <?php else: ?>
            <?php echo smarty_function_notifydisplayhooks(array('eventname' => 'users.ui_hooks.login_block.form_edit','id' => null), $this);?>

        <?php endif; ?>

        <div class="z-formbuttons z-buttons">
            <?php echo smarty_function_button(array('src' => 'button_ok.png','set' => 'icons/extrasmall','alt' => ((is_array($_tmp='Log in')) ? $this->_run_mod_handler('gt', true, $_tmp, $this->_tpl_vars['zikula_view']) : smarty_modifier_gt($_tmp, $this->_tpl_vars['zikula_view'])),'title' => ((is_array($_tmp='Log in')) ? $this->_run_mod_handler('gt', true, $_tmp, $this->_tpl_vars['zikula_view']) : smarty_modifier_gt($_tmp, $this->_tpl_vars['zikula_view'])),'text' => ((is_array($_tmp='Log in')) ? $this->_run_mod_handler('gt', true, $_tmp, $this->_tpl_vars['zikula_view']) : smarty_modifier_gt($_tmp, $this->_tpl_vars['zikula_view']))), $this);?>

        </div>
    </div>
</form>
<div id="users_login_waiting" class="z-form z-clearer z-gap z-hide">
    <fieldset>
        <p class="z-center z-gap"><?php echo smarty_function_img(array('modname' => 'core','set' => 'ajax','src' => 'large_fine_white.gif'), $this);?>
</p>
    </fieldset>
</div>
<div id="users_login_no_loginformfields" class="z-clearer z-gap<?php if (( isset ( $this->_tpl_vars['login_form_fields'] ) && ! empty ( $this->_tpl_vars['login_form_fields'] ) ) || ! isset ( $this->_tpl_vars['selected_authentication_method'] ) || empty ( $this->_tpl_vars['selected_authentication_method'] )): ?> z-hide<?php endif; ?>">
    <h5><?php if (isset ( $this->_tpl_vars['selected_authentication_method'] ) && $this->_tpl_vars['selected_authentication_method']): ?><?php echo ((is_array($_tmp=@$this->_tpl_vars['selected_authentication_method']['modname'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
<?php endif; ?></h5>
    <p class="z-errormsg">
        <?php echo smarty_function_gt(array('text' => 'The log-in option you chose is not available at the moment.'), $this);?>

        <?php if (count ( $this->_tpl_vars['authentication_method_display_order'] ) > 1): ?>
        <?php echo smarty_function_gt(array('text' => 'Please choose another or contact the site administrator for assistance.'), $this);?>

        <?php else: ?>
        <?php echo smarty_function_gt(array('text' => 'Please contact the site administrator for assistance.'), $this);?>

        <?php endif; ?>
    </p>
</div>
<script type="text/javascript" language="JavaScript"><?php echo '
document.getElementById("users_login_login_id").focus();
'; ?>
</script>