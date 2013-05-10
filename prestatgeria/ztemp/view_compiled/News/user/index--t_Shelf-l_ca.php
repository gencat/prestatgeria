<?php /* Smarty version 2.6.26, created on 2013-05-07 13:54:44
         compiled from user/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'safehtml', 'user/index.tpl', 2, false),array('modifier', 'dateformat', 'user/index.tpl', 3, false),array('modifier', 'notifyfilters', 'user/index.tpl', 15, false),array('function', 'gt', 'user/index.tpl', 3, false),array('function', 'modurl', 'user/index.tpl', 9, false),array('function', 'checkpermission', 'user/index.tpl', 36, false),)), $this); ?>
<div class="news_index">
    <h3 class="news_title"><?php echo ((is_array($_tmp=$this->_tpl_vars['preformat']['title'])) ? $this->_run_mod_handler('safehtml', true, $_tmp) : smarty_modifier_safehtml($_tmp)); ?>
</h3>
    <span class="news_meta z-sub"><?php echo smarty_function_gt(array('text' => 'Contributed'), $this);?>
 <?php echo smarty_function_gt(array('text' => 'by %1$s on %2$s','tag1' => $this->_tpl_vars['info']['contributor'],'tag2' => ((is_array($_tmp=$this->_tpl_vars['info']['from'])) ? $this->_run_mod_handler('dateformat', true, $_tmp, 'datetimebrief') : smarty_modifier_dateformat($_tmp, 'datetimebrief'))), $this);?>
</span>

    <div class="news_body">
        <?php if ($this->_tpl_vars['modvars']['News']['picupload_enabled'] && $this->_tpl_vars['info']['pictures'] > 0): ?>
        <div class="news_photoindex news_thumbsindex" style="float:<?php echo $this->_tpl_vars['modvars']['News']['picupload_index_float']; ?>
">
            <?php if ($this->_tpl_vars['modvars']['ZConfig']['shorturls']): ?>
                <a href="<?php echo smarty_function_modurl(array('modname' => 'News','type' => 'user','func' => 'display','sid' => $this->_tpl_vars['info']['sid'],'from' => $this->_tpl_vars['info']['from'],'urltitle' => $this->_tpl_vars['info']['urltitle']), $this);?>
"><img src="<?php echo $this->_tpl_vars['modvars']['News']['picupload_uploaddir']; ?>
/pic_sid<?php echo $this->_tpl_vars['info']['sid']; ?>
-0-thumb.jpg" alt="<?php echo smarty_function_gt(array('text' => 'Picture %1$s for %2$s','tag1' => '0','tag2' => $this->_tpl_vars['info']['title']), $this);?>
" /></a>
            <?php else: ?>
                <a href="<?php echo smarty_function_modurl(array('modname' => 'News','type' => 'user','func' => 'display','sid' => $this->_tpl_vars['info']['sid']), $this);?>
"><img src="<?php echo $this->_tpl_vars['modvars']['News']['picupload_uploaddir']; ?>
/pic_sid<?php echo $this->_tpl_vars['info']['sid']; ?>
-0-thumb.jpg" alt="<?php echo smarty_function_gt(array('text' => 'Picture %1$s for %2$s','tag1' => '0','tag2' => $this->_tpl_vars['info']['title']), $this);?>
" /></a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['preformat']['hometext'])) ? $this->_run_mod_handler('notifyfilters', true, $_tmp, 'news.hook.articlesfilter.ui.filter') : smarty_modifier_notifyfilters($_tmp, 'news.hook.articlesfilter.ui.filter')))) ? $this->_run_mod_handler('safehtml', true, $_tmp) : smarty_modifier_safehtml($_tmp)); ?>

    </div>

    <?php if ($this->_tpl_vars['preformat']['notes'] != ''): ?>
    <p class="news_meta"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['preformat']['notes'])) ? $this->_run_mod_handler('notifyfilters', true, $_tmp, 'news.hook.articlesfilter.ui.filter') : smarty_modifier_notifyfilters($_tmp, 'news.hook.articlesfilter.ui.filter')))) ? $this->_run_mod_handler('safehtml', true, $_tmp) : smarty_modifier_safehtml($_tmp)); ?>
</p>
    <?php endif; ?>

    <p class="news_footer">
        <?php if (! empty ( $this->_tpl_vars['info']['categories'] )): ?>
        <?php echo smarty_function_gt(array('text' => 'Filed under:'), $this);?>

        <?php $_from = $this->_tpl_vars['preformat']['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['categorylinks'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['categorylinks']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['categorylink']):
        $this->_foreach['categorylinks']['iteration']++;
?>
        <?php echo $this->_tpl_vars['categorylink']; ?>
<?php if (($this->_foreach['categorylinks']['iteration'] == $this->_foreach['categorylinks']['total']) != true): ?>,&nbsp;<?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
        <span class="text_separator">|</span>
        <?php endif; ?>
        <?php if (! empty ( $this->_tpl_vars['preformat']['readmore'] )): ?>
          <?php echo $this->_tpl_vars['preformat']['readmore']; ?>

          <span class="text_separator">|</span>
        <?php endif; ?>

        <?php echo $this->_tpl_vars['preformat']['print']; ?>

        <?php echo smarty_function_checkpermission(array('component' => "News::",'instance' => ".*",'level' => 'ACCESS_READ','assign' => 'readaccess'), $this);?>

        <?php if ($this->_tpl_vars['modvars']['News']['pdflink'] && $this->_tpl_vars['readaccess']): ?>
        <span class="text_separator">|</span>
        <a title="PDF" href="<?php echo smarty_function_modurl(array('modname' => 'News','type' => 'user','func' => 'displaypdf','sid' => $this->_tpl_vars['info']['sid']), $this);?>
" target="_blank">PDF <img src="modules/News/images/pdf.gif" width="16" height="16" alt="PDF" /></a>
        <?php endif; ?>
    </p>
</div>