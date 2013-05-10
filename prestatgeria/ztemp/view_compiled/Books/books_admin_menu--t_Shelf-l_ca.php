<?php /* Smarty version 2.6.26, created on 2013-05-07 11:35:50
         compiled from books_admin_menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'admincategorymenu', 'books_admin_menu.tpl', 1, false),array('function', 'gt', 'books_admin_menu.tpl', 3, false),array('function', 'booksmenulinks', 'books_admin_menu.tpl', 5, false),)), $this); ?>
<?php echo smarty_function_admincategorymenu(array(), $this);?>

<div class="z-adminbox">
    <h1><?php echo smarty_function_gt(array('text' => 'Llibres'), $this);?>
</h1>
    <div class="z-menu">
        <?php echo smarty_function_booksmenulinks(array(), $this);?>

    </div>
</div>