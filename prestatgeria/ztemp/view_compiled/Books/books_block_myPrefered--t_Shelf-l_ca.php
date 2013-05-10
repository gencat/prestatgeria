<?php /* Smarty version 2.6.26, created on 2013-05-07 11:35:51
         compiled from books_block_myPrefered.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'gt', 'books_block_myPrefered.tpl', 12, false),array('function', 'img', 'books_block_myPrefered.tpl', 13, false),)), $this); ?>
<div id="prefered">
    <div class="blocContent">
        <?php $_from = $this->_tpl_vars['books']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['book']):
?>
        <div id="bookPrefered_<?php echo $this->_tpl_vars['book']['bookId']; ?>
" style="clear:both; width: 100%">
            <div class="blocLink">
                <a href="#" onclick="javascript:showBookData(<?php echo $this->_tpl_vars['book']['bookId']; ?>
)">
                    <?php echo $this->_tpl_vars['book']['bookTitle']; ?>

                </a>
            </div>
            <div class="blocValue">
                <a href="javascript:delPrefer(<?php echo $this->_tpl_vars['book']['bookId']; ?>
)">
                    <?php echo smarty_function_gt(array('text' => 'Esborra de la llista de preferits','assign' => 'alt'), $this);?>

                    <?php echo smarty_function_img(array('modname' => 'Books','src' => "close.png",'altml' => true,'titleml' => true,'alt' => $this->_tpl_vars['alt'],'title' => $this->_tpl_vars['alt']), $this);?>

                </a>
            </div>
        </div>
        <?php endforeach; else: ?>
        <div><?php echo smarty_function_gt(array('text' => 'No tens llibres preferits'), $this);?>
</div>
        <?php endif; unset($_from); ?>
        <div style="clear:both;"></div>
    </div>
</div>