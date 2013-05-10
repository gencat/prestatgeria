<?php /* Smarty version 2.6.26, created on 2013-05-07 11:35:51
         compiled from books_block_mostReaded.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'gt', 'books_block_mostReaded.tpl', 14, false),)), $this); ?>
<div class="blocContent">
    <?php $_from = $this->_tpl_vars['books']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['book']):
?>
    <div class="blocLink">
        <a href="#" onclick="javascript:showBookData(<?php echo $this->_tpl_vars['book']['bookId']; ?>
)">
            <?php echo $this->_tpl_vars['book']['bookTitle']; ?>

        </a>
    </div>
    <div class="blocValue">
        <?php echo $this->_tpl_vars['book']['bookHits']; ?>
 v.
    </div>
    <?php endforeach; endif; unset($_from); ?>
    <div class="more">
        <a href="#" onclick="javascript:catalogue('bookHits','',1,'',1)">
            <?php echo smarty_function_gt(array('text' => 'Més...'), $this);?>

        </a>
    </div>
    <div style="clear: both;"></div>
</div>