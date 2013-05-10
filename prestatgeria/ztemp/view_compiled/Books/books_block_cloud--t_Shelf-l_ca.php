<?php /* Smarty version 2.6.26, created on 2013-05-07 11:35:51
         compiled from books_block_cloud.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'gt', 'books_block_cloud.tpl', 10, false),)), $this); ?>
<div class="blocContent">
    <?php $_from = $this->_tpl_vars['cloud']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cloud']):
?>
    <a style="font-size:<?php echo $this->_tpl_vars['cloud']['size']; ?>
px" class="tag_cloud" href="#" onclick="javascript:catalogue('','descriptor',1,'<?php echo $this->_tpl_vars['cloud']['tag']; ?>
',4)" title="<?php echo $this->_tpl_vars['cloud']['tag']; ?>
 se n'han trobat <?php echo $this->_tpl_vars['cloud']['count']; ?>
">
        <?php echo $this->_tpl_vars['cloud']['tag']; ?>

    </a>
    <?php endforeach; endif; unset($_from); ?>
    <div style="clear: both;">&nbsp;</div>
    <div class="more">
        <a href="#" onclick="javascript:descriptors()">
            <?php echo smarty_function_gt(array('text' => 'Més...'), $this);?>

        </a>
    </div>
    <div style="clear: both;"></div>
</div>