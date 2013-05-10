<?php /* Smarty version 2.6.26, created on 2013-05-07 11:35:51
         compiled from profile_block_membersonline.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'profilelinkbyuname', 'profile_block_membersonline.tpl', 5, false),array('modifier', 'safehtml', 'profile_block_membersonline.tpl', 8, false),array('modifier', 'gt', 'profile_block_membersonline.tpl', 10, false),array('function', 'modurl', 'profile_block_membersonline.tpl', 6, false),array('function', 'gt', 'profile_block_membersonline.tpl', 8, false),array('function', 'img', 'profile_block_membersonline.tpl', 10, false),)), $this); ?>
<?php if ($this->_tpl_vars['usersonline']): ?>
<ul>
    <?php $_from = $this->_tpl_vars['usersonline']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>
    <li>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['user']['uname'])) ? $this->_run_mod_handler('profilelinkbyuname', true, $_tmp, '', '', $this->_tpl_vars['maxLength']) : smarty_modifier_profilelinkbyuname($_tmp, '', '', $this->_tpl_vars['maxLength'])); ?>

        <?php if ($this->_tpl_vars['msgmodule']): ?><?php echo smarty_function_modurl(array('modname' => $this->_tpl_vars['msgmodule'],'type' => 'user','func' => 'inbox','assign' => 'messageslink'), $this);?>

        <?php if ($this->_tpl_vars['user']['uid'] == $this->_tpl_vars['uid']): ?>
        (<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['messageslink'])) ? $this->_run_mod_handler('safehtml', true, $_tmp) : smarty_modifier_safehtml($_tmp)); ?>
" title="<?php echo smarty_function_gt(array('text' => 'unread'), $this);?>
"><?php echo $this->_tpl_vars['messages']['unread']; ?>
</a> | <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['messageslink'])) ? $this->_run_mod_handler('safehtml', true, $_tmp) : smarty_modifier_safehtml($_tmp)); ?>
" title="<?php echo smarty_function_gt(array('text' => 'total'), $this);?>
"><?php echo $this->_tpl_vars['messages']['totalin']; ?>
</a>)
        <?php else: ?>
        <a href="<?php echo smarty_function_modurl(array('modname' => $this->_tpl_vars['msgmodule'],'type' => 'user','func' => 'newpm','uid' => $this->_tpl_vars['user']['uid']), $this);?>
" title="<?php echo smarty_function_gt(array('text' => 'Send private message'), $this);?>
&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['user']['uname'])) ? $this->_run_mod_handler('safehtml', true, $_tmp) : smarty_modifier_safehtml($_tmp)); ?>
"><?php echo smarty_function_img(array('modname' => 'core','set' => 'icons/extrasmall','src' => 'mail_new.png','alt' => ((is_array($_tmp='Send private message')) ? $this->_run_mod_handler('gt', true, $_tmp, $this->_tpl_vars['zikula_view']) : smarty_modifier_gt($_tmp, $this->_tpl_vars['zikula_view'])),'style' => 'vertical-align:middle; margin-left:2px;'), $this);?>
</a>
        <?php endif; ?>
        <?php endif; ?>
    </li>
    <?php endforeach; endif; unset($_from); ?>
</ul>
<?php endif; ?>
<p>
    <?php if ($this->_tpl_vars['anononline'] == 0): ?>
    <?php echo smarty_function_gt(array('text' => '%s registered user','plural' => '%s registered users','count' => $this->_tpl_vars['membonline'],'tag1' => $this->_tpl_vars['membonline'],'assign' => 'blockstring'), $this);?>

    <?php echo smarty_function_gt(array('text' => '%s on-line.','tag1' => $this->_tpl_vars['blockstring']), $this);?>

    <?php elseif ($this->_tpl_vars['membonline'] == 0): ?>
    <?php echo smarty_function_gt(array('text' => '%s anonymous guest','plural' => '%s anonymous guests','count' => $this->_tpl_vars['anononline'],'tag1' => $this->_tpl_vars['anononline'],'assign' => 'blockstring'), $this);?>

    <?php echo smarty_function_gt(array('text' => '%s on-line.','tag1' => $this->_tpl_vars['blockstring']), $this);?>

    <?php else: ?>
    <?php echo smarty_function_gt(array('text' => '%s registered user','plural' => '%s registered users','count' => $this->_tpl_vars['membonline'],'tag1' => $this->_tpl_vars['membonline'],'assign' => 'nummeb'), $this);?>

    <?php echo smarty_function_gt(array('text' => '%s anonymous guest','plural' => '%s anonymous guests','count' => $this->_tpl_vars['anononline'],'tag1' => $this->_tpl_vars['anononline'],'assign' => 'numanon'), $this);?>

    <?php echo smarty_function_gt(array('text' => '%1$s and %2$s online.','tag1' => $this->_tpl_vars['nummeb'],'tag2' => $this->_tpl_vars['numanon']), $this);?>

    <?php endif; ?>
</p>