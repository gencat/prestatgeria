<?php /* Smarty version 2.6.26, created on 2013-05-07 13:54:44
         compiled from user/view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'nocache', 'user/view.tpl', 1, false),array('insert', 'getstatusmsg', 'user/view.tpl', 2, false),array('function', 'pager', 'user/view.tpl', 12, false),)), $this); ?>
<?php $this->_cache_serials['ztemp/view_compiled/News/user/view--t_Shelf-l_ca.inc'] = '513d70253a3c07afe4f5c71bb6b46184'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:513d70253a3c07afe4f5c71bb6b46184#0}'; endif;$this->_tag_stack[] = array('nocache', array()); $_block_repeat=true;Zikula_View_Resource::block_nocache($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'user/menu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo Zikula_View_Resource::block_nocache($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); if ($this->caching && !$this->_cache_including): echo '{/nocache:513d70253a3c07afe4f5c71bb6b46184#0}'; endif;?>
<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getstatusmsg')), $this); ?>


<?php unset($this->_sections['newsview']);
$this->_sections['newsview']['name'] = 'newsview';
$this->_sections['newsview']['loop'] = is_array($_loop=$this->_tpl_vars['newsitems']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['newsview']['show'] = true;
$this->_sections['newsview']['max'] = $this->_sections['newsview']['loop'];
$this->_sections['newsview']['step'] = 1;
$this->_sections['newsview']['start'] = $this->_sections['newsview']['step'] > 0 ? 0 : $this->_sections['newsview']['loop']-1;
if ($this->_sections['newsview']['show']) {
    $this->_sections['newsview']['total'] = $this->_sections['newsview']['loop'];
    if ($this->_sections['newsview']['total'] == 0)
        $this->_sections['newsview']['show'] = false;
} else
    $this->_sections['newsview']['total'] = 0;
if ($this->_sections['newsview']['show']):

            for ($this->_sections['newsview']['index'] = $this->_sections['newsview']['start'], $this->_sections['newsview']['iteration'] = 1;
                 $this->_sections['newsview']['iteration'] <= $this->_sections['newsview']['total'];
                 $this->_sections['newsview']['index'] += $this->_sections['newsview']['step'], $this->_sections['newsview']['iteration']++):
$this->_sections['newsview']['rownum'] = $this->_sections['newsview']['iteration'];
$this->_sections['newsview']['index_prev'] = $this->_sections['newsview']['index'] - $this->_sections['newsview']['step'];
$this->_sections['newsview']['index_next'] = $this->_sections['newsview']['index'] + $this->_sections['newsview']['step'];
$this->_sections['newsview']['first']      = ($this->_sections['newsview']['iteration'] == 1);
$this->_sections['newsview']['last']       = ($this->_sections['newsview']['iteration'] == $this->_sections['newsview']['total']);
?>
    <?php echo $this->_tpl_vars['newsitems'][$this->_sections['newsview']['index']]; ?>

    <?php if ($this->_sections['newsview']['last'] != true): ?>
    <hr />
    <?php endif; ?>
<?php endfor; endif; ?>

<?php if ($this->_tpl_vars['newsitems']): ?>
<?php echo smarty_function_pager(array('display' => 'page','rowcount' => $this->_tpl_vars['pager']['numitems'],'limit' => $this->_tpl_vars['pager']['itemsperpage'],'posvar' => 'page','maxpages' => '10'), $this);?>

<?php endif; ?>