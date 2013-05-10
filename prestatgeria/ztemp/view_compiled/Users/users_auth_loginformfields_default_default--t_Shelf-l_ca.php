<?php /* Smarty version 2.6.26, created on 2013-05-07 13:54:48
         compiled from users_auth_loginformfields_default_default.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'gt', 'users_auth_loginformfields_default_default.tpl', 2, false),array('function', 'pageaddvar', 'users_auth_loginformfields_default_default.tpl', 4, false),array('block', 'pageaddvarblock', 'users_auth_loginformfields_default_default.tpl', 6, false),)), $this); ?>
<?php echo ''; ?><?php echo smarty_function_gt(array('text' => 'User account','assign' => 'legend_text'), $this);?><?php echo ''; ?><?php if (isset ( $this->_tpl_vars['change_password'] ) && ( $this->_tpl_vars['change_password'] == 1 ) && ( $this->_tpl_vars['modvars']['Users']['use_password_strength_meter'] == 1 )): ?><?php echo ''; ?><?php echo smarty_function_pageaddvar(array('name' => 'javascript','value' => 'prototype'), $this);?><?php echo ''; ?><?php echo smarty_function_pageaddvar(array('name' => 'javascript','value' => 'system/Users/javascript/Zikula.Users.PassMeter.js'), $this);?><?php echo ''; ?><?php $this->_tag_stack[] = array('pageaddvarblock', array()); $_block_repeat=true;smarty_block_pageaddvarblock($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php echo '<script type="text/javascript">'; ?><?php echo '
                var passmeter = null;
                document.observe("dom:loaded", function() {
                    passmeter = new Zikula.Users.PassMeter(\'users_login_newpass\', \'users_login_passmeter\', {
                        username:\'users_login_login_id\',
                        minLength: \''; ?><?php echo ''; ?><?php echo $this->_tpl_vars['modvars']['Users']['minpass']; ?><?php echo ''; ?><?php echo '\'
                    });
                });
            '; ?><?php echo '</script>'; ?><?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_pageaddvarblock($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?>


<?php if (isset ( $this->_tpl_vars['change_password'] ) && ( $this->_tpl_vars['change_password'] == 1 )): ?>
<p class="z-warningmsg"><?php echo smarty_function_gt(array('text' => "Important: For security reasons, you must change your password before you can log in. Thank you for your understanding."), $this);?>
</p>
<?php endif; ?>

<div class="z-formrow">
    <label for="users_login_login_id"><?php echo ''; ?><?php if ($this->_tpl_vars['authentication_method'] == 'email'): ?><?php echo ''; ?><?php echo smarty_function_gt(array('text' => 'E-mail address'), $this);?><?php echo ''; ?><?php else: ?><?php echo ''; ?><?php echo smarty_function_gt(array('text' => 'User name'), $this);?><?php echo ''; ?><?php endif; ?><?php echo ''; ?>
</label>
    <input id="users_login_login_id" type="text" name="authentication_info[login_id]" maxlength="64" value="<?php if (isset ( $this->_tpl_vars['authentication_info']['login_id'] )): ?><?php echo $this->_tpl_vars['authentication_info']['login_id']; ?>
<?php endif; ?>" />
</div>

<script type="text/javascript"><?php echo '
    function capLock(e) {
        kc = e.keyCode?e.keyCode:e.which;
        sk = e.shiftKey?e.shiftKey:((kc == 16)?true:false);
        if ((((kc >= 65 && kc <= 90) && !sk)||((kc >= 97 && kc <= 122) && sk)) && !Boolean(window.chrome) && !Boolean(window.webkit))
    	    document.getElementById(\'capsLok\').style.visibility = \'visible\';
        else
    	    document.getElementById(\'capsLok\').style.visibility = \'hidden\';
        }
'; ?>
</script>

<div class="z-formrow">
    <label for="users_login_pass"><?php if (isset ( $this->_tpl_vars['change_password'] ) && $this->_tpl_vars['change_password']): ?><?php echo smarty_function_gt(array('text' => 'Current password'), $this);?>
<?php else: ?><?php echo smarty_function_gt(array('text' => 'Password'), $this);?>
<?php endif; ?></label>
    <input id="users_login_pass" type="password" name="authentication_info[pass]" maxlength="25" onkeypress="capLock(event)" />
    <em class="z-formnote z-sub" id="capsLok" style="visibility:hidden"><?php echo smarty_function_gt(array('text' => 'Caps Lock is on!'), $this);?>
</em>
</div>

<?php if (isset ( $this->_tpl_vars['change_password'] ) && $this->_tpl_vars['change_password']): ?>
<div class="z-formrow">
    <label for="users_newpass"><?php echo smarty_function_gt(array('text' => 'New password'), $this);?>
</label>
    <input type="password" id="users_login_newpass" name="authentication_info[new_pass]" size="20" maxlength="20" value="" />
</div>
<?php if ($this->_tpl_vars['modvars']['Users']['use_password_strength_meter'] == 1): ?>
<div id="users_login_passmeter">
</div>
<?php endif; ?>

<div class="z-formrow">
    <label for="users_login_confirm_new_pass"><?php echo smarty_function_gt(array('text' => "New password (repeat for verification)"), $this);?>
</label>
    <input id="users_login_confirm_new_pass" type="password" name="authentication_info[confirm_new_pass]" size="20" maxlength="20" />
</div>

<div class="z-formrow">
    <label for="users_login_pass_reminder"><?php echo smarty_function_gt(array('text' => 'New password reminder'), $this);?>
</label>
    <input type="text" id="users_login_pass_reminder" name="authentication_info[pass_reminder]" value="" size="25" maxlength="128" />
    <div class="z-sub z-formnote"><?php echo smarty_function_gt(array('text' => "Enter a word or a phrase that will remind you of your password."), $this);?>
</div>
    <div class="z-formnote z-warningmsg"><?php echo smarty_function_gt(array('text' => "Notice: Do not use a word or phrase that will allow others to guess your password! Do not include your password or any part of your password here!"), $this);?>
</div>
</div>
<?php endif; ?>