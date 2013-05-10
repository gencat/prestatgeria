<?php /* Smarty version 2.6.26, created on 2013-05-07 11:35:51
         compiled from books_block_menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'gt', 'books_block_menu.tpl', 6, false),array('function', 'userloggedin', 'books_block_menu.tpl', 38, false),array('function', 'modurl', 'books_block_menu.tpl', 41, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "books_user_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="blocContent">
    <?php if ($this->_tpl_vars['canAdmin']): ?>
    <div class="blocLink">
        <a href="admin.php">
            <?php echo smarty_function_gt(array('text' => 'Administració'), $this);?>

        </a>
    </div>
    <div style="clear:both;"></div>
    <?php endif; ?>
    <div class="blocLink">
        <a href="javascript:catalogue('lastEntry','',1,'',2)">
            <?php echo smarty_function_gt(array('text' => 'Catàleg de llibres'), $this);?>

        </a>
    </div>
    <div style="clear:both;"></div>
    <div class="blocLink">
        <a href="javascript:collections()">
            <?php echo smarty_function_gt(array('text' => 'Col·leccions'), $this);?>

        </a>
    </div>
    <?php if ($this->_tpl_vars['canAdminCreateBooks']): ?>
    <div style="clear:both;"></div>
    <div class="blocLink">
        <a href="javascript:manage()">
            <?php echo smarty_function_gt(array('text' => 'Gestiona els llibres'), $this);?>

        </a>

    </div>
    <?php endif; ?>
    <div style="clear:both;"></div>
    <div class="blocLink">
        <a href="index.php?module=IWwebbox&ref=pmf">
            <?php echo smarty_function_gt(array('text' => 'Preguntes més freqüents'), $this);?>

        </a>
    </div>
    <div style="clear:both;"></div>
    <?php echo smarty_function_userloggedin(array('assign' => 'userid'), $this);?>

    <?php if ($this->_tpl_vars['userid'] != ''): ?>
    <div class="blocLink">
        <a href="<?php echo smarty_function_modurl(array('modname' => 'books','type' => 'user','func' => 'newItem'), $this);?>
">
            <?php echo smarty_function_gt(array('text' => 'Crea un llibre nou'), $this);?>

        </a>
    </div>
    <?php endif; ?>
    <div style="clear:both;"></div>
    <?php if ($this->_tpl_vars['mustInscribe']): ?>
    <div class="blocLink">
        <a href="<?php echo smarty_function_modurl(array('modname' => 'books','type' => 'user','func' => 'inscribe'), $this);?>
">
            <?php echo smarty_function_gt(array('text' => 'Inscriure el centre'), $this);?>

        </a>
    </div>
    <div style="clear:both;"></div>
    <?php endif; ?>
    <div class="blocLink">
        <a href="<?php echo $this->_tpl_vars['bookSoftwareUrl']; ?>
/llibre.php?fisbn=llibres_1" target="_blank">
            Com funcionen els llibres?
        </a>
    </div>
    <div class="blocLink">
        <?php if ($this->_tpl_vars['userid'] != ''): ?>
        <a href="<?php echo smarty_function_modurl(array('modname' => 'Users','type' => 'user','func' => 'logout'), $this);?>
">
            <?php echo smarty_function_gt(array('text' => 'Surt'), $this);?>

        </a>
        <?php else: ?>
        <a href="<?php echo smarty_function_modurl(array('modname' => 'Users','type' => 'user','func' => 'loginscreen'), $this);?>
">
            <?php echo smarty_function_gt(array('text' => 'Entra'), $this);?>

        </a>
        <?php endif; ?>
    </div>
</div>
<div style="clear:both; padding-bottom: 20px;"></div>