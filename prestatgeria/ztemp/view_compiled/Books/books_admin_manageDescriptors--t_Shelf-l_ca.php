<?php /* Smarty version 2.6.26, created on 2013-05-07 11:35:50
         compiled from books_admin_manageDescriptors.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'img', 'books_admin_manageDescriptors.tpl', 4, false),array('function', 'gt', 'books_admin_manageDescriptors.tpl', 5, false),array('function', 'modurl', 'books_admin_manageDescriptors.tpl', 9, false),array('function', 'cycle', 'books_admin_manageDescriptors.tpl', 13, false),array('modifier', 'count', 'books_admin_manageDescriptors.tpl', 8, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "books_admin_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="z-admincontainer">
    <div class="z-adminpageicon">
        <?php echo smarty_function_img(array('modname' => 'core','src' => "configure.png",'set' => "icons/large"), $this);?>

        <h2><?php echo smarty_function_gt(array('text' => 'Administra els descriptors'), $this);?>
</h2>
    </div>
    <div class="descriptorsNumber">
        <?php echo smarty_function_gt(array('text' => 'Nombre total de descriptors'), $this);?>
: <?php echo count($this->_tpl_vars['descriptors']); ?>

        <a href="<?php echo smarty_function_modurl(array('modname' => 'Books','type' => 'admin','func' => 'purge'), $this);?>
">&nbsp;&nbsp;&nbsp;(<?php echo smarty_function_gt(array('text' => 'Purga els descriptors'), $this);?>
)</a>
    </div>
    <table cellpadding="5">
        <?php $_from = $this->_tpl_vars['descriptors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['descriptor']):
?>
        <tr bgcolor="<?php echo smarty_function_cycle(array('values' => '#ffffff, #eeeeee'), $this);?>
" id="row_<?php echo $this->_tpl_vars['descriptor']['did']; ?>
">
            <td>
                <div id="descriptor_<?php echo $this->_tpl_vars['descriptor']['did']; ?>
">
                    <?php echo $this->_tpl_vars['descriptor']['descriptor']; ?>

                </div>
            </td>
            <td>
                <?php echo $this->_tpl_vars['descriptor']['number']; ?>

            </td>
            <td>
                <a href="javascript:editDescriptor(<?php echo $this->_tpl_vars['descriptor']['did']; ?>
)">
                    <?php echo smarty_function_img(array('modname' => 'core','src' => "edit.png",'set' => "icons/extrasmall"), $this);?>

                </a>
                <a href="javascript:deleteDescriptor(<?php echo $this->_tpl_vars['descriptor']['did']; ?>
)">
                    <?php echo smarty_function_img(array('modname' => 'core','src' => "14_layer_deletelayer.png",'set' => "icons/extrasmall"), $this);?>

                </a>
            </td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
    </table>
</div>