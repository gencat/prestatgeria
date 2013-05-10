<?php /* Smarty version 2.6.26, created on 2013-05-07 13:55:04
         compiled from books_user_bookData.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'gt', 'books_user_bookData.tpl', 5, false),array('function', 'userloggedin', 'books_user_bookData.tpl', 18, false),array('function', 'img', 'books_user_bookData.tpl', 22, false),array('function', 'modurl', 'books_user_bookData.tpl', 32, false),array('function', 'getDateFormat', 'books_user_bookData.tpl', 111, false),array('modifier', 'nl2br', 'books_user_bookData.tpl', 101, false),array('modifier', 'count', 'books_user_bookData.tpl', 105, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "books_user_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="return">
    <a href="#" onclick="catalogue('','','','',2)">
        <?php echo smarty_function_gt(array('text' => 'Torna al catàleg de llibres'), $this);?>

    </a>
</div>

<div class="field">
    <div class="fieldBookFisbn"><a href="<?php echo $this->_tpl_vars['bookSoftwareUrl']; ?>
/<?php echo $this->_tpl_vars['bookInfoBook']['schoolCode']; ?>
_<?php echo $this->_tpl_vars['bookInfoBook']['bookId']; ?>
/llibre" target="_blank"><?php echo $this->_tpl_vars['bookInfoBook']['schoolCode']; ?>
_<?php echo $this->_tpl_vars['bookInfoBook']['bookId']; ?>
</a></div>
    <div class="fieldBookTitle">
        <a href="<?php echo $this->_tpl_vars['bookSoftwareUrl']; ?>
/<?php echo $this->_tpl_vars['bookInfoBook']['schoolCode']; ?>
_<?php echo $this->_tpl_vars['bookInfoBook']['bookId']; ?>
/llibre" target="_blank"><?php echo $this->_tpl_vars['bookInfoBook']['bookTitle']; ?>
</a>
    </div>
    <div class="fieldIcons">
        <?php if ($this->_tpl_vars['bookInfoBook']['bookCollectionName'] != ''): ?>
        <div class="collectionNameField"><?php echo smarty_function_gt(array('text' => 'Col·lecció'), $this);?>
: <?php echo $this->_tpl_vars['bookInfoBook']['bookCollectionName']; ?>
</div>
        <?php endif; ?>
        <?php echo smarty_function_userloggedin(array('assign' => 'userid'), $this);?>

        <?php if ($this->_tpl_vars['userid'] != ''): ?>
        <a href="javascript:addPrefer(<?php echo $this->_tpl_vars['bookInfoBook']['bookId']; ?>
)">
            <?php echo smarty_function_gt(array('text' => 'Afegeix als llibres preferits','assign' => 'alt'), $this);?>

            <?php echo smarty_function_img(array('modname' => 'Books','src' => "prefer.gif",'altml' => true,'titleml' => true,'alt' => $this->_tpl_vars['alt'],'title' => $this->_tpl_vars['alt']), $this);?>

        </a>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['canComment']): ?>
        <a href="#" onClick="addComment('<?php echo $this->_tpl_vars['bookInfoBook']['bookId']; ?>
',3)">
            <?php echo smarty_function_gt(array('text' => 'Afegeix un comentari','assign' => 'alt'), $this);?>

            <?php echo smarty_function_img(array('modname' => 'Books','src' => "comment.gif",'altml' => true,'titleml' => true,'alt' => $this->_tpl_vars['alt'],'title' => $this->_tpl_vars['alt']), $this);?>

        </a>
        <?php if ($this->_tpl_vars['bookInfoBook']['bookAdminName'] == $this->_tpl_vars['userName'] || $this->_tpl_vars['userName'] == $this->_tpl_vars['bookInfoBook']['schoolCode']): ?>
        <a href="<?php echo smarty_function_modurl(array('modname' => 'Books','type' => 'user','func' => 'editBook','bookId' => $this->_tpl_vars['bookInfoBook']['bookId']), $this);?>
">
            <?php echo smarty_function_gt(array('text' => 'Edita les característiques del llibre','assign' => 'alt'), $this);?>

            <?php echo smarty_function_img(array('modname' => 'Books','src' => "editfolder.gif",'altml' => true,'titleml' => true,'alt' => $this->_tpl_vars['alt'],'title' => $this->_tpl_vars['alt']), $this);?>

        </a>
        <?php if ($this->_tpl_vars['bookInfoBook']['bookAdminName'] == $this->_tpl_vars['userName']): ?>
        <a href="<?php echo smarty_function_modurl(array('modname' => 'Books','type' => 'user','func' => 'newPublic'), $this);?>
">
            <?php echo smarty_function_gt(array('text' => 'Publicita el teu llibre','assign' => 'alt'), $this);?>

            <?php echo smarty_function_img(array('modname' => 'Books','src' => "publi.gif",'altml' => true,'titleml' => true,'alt' => $this->_tpl_vars['alt'],'title' => $this->_tpl_vars['alt']), $this);?>

        </a>
        <?php endif; ?>		
        <?php endif; ?>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['canExport']): ?>
        <a href="<?php echo smarty_function_modurl(array('modname' => 'Books','type' => 'user','func' => 'exportBook','bookId' => $this->_tpl_vars['bookInfoBook']['bookId']), $this);?>
">
            <?php echo smarty_function_gt(array('text' => 'Exporta el llibre','assign' => 'alt'), $this);?>

            <?php echo smarty_function_img(array('modname' => 'Books','src' => "export_book.png",'altml' => true,'titleml' => true,'alt' => $this->_tpl_vars['alt'],'title' => $this->_tpl_vars['alt']), $this);?>

        </a>
        <a href="<?php echo smarty_function_modurl(array('modname' => 'Books','type' => 'user','func' => 'getHtmlBook','bookId' => $this->_tpl_vars['bookInfoBook']['bookId']), $this);?>
">
            <?php echo smarty_function_gt(array('text' => 'Exporta el llibre en format html','assign' => 'alt'), $this);?>

            <?php echo smarty_function_img(array('modname' => 'Books','src' => "html.png",'altml' => true,'titleml' => true,'alt' => $this->_tpl_vars['alt'],'title' => $this->_tpl_vars['alt']), $this);?>

        </a>
        <a href="<?php echo smarty_function_modurl(array('modname' => 'Books','type' => 'user','func' => 'getScormBook','bookId' => $this->_tpl_vars['bookInfoBook']['bookId']), $this);?>
">
            <?php echo smarty_function_gt(array('text' => 'Exporta el llibre en format scorm','assign' => 'alt'), $this);?>

            <?php echo smarty_function_img(array('modname' => 'Books','src' => "scorm.png",'altml' => true,'titleml' => true,'alt' => $this->_tpl_vars['alt'],'title' => $this->_tpl_vars['alt']), $this);?>

        </a>
        <a href="<?php echo smarty_function_modurl(array('modname' => 'Books','type' => 'user','func' => 'getEpubBook','bookId' => $this->_tpl_vars['bookInfoBook']['bookId']), $this);?>
">
            <?php echo smarty_function_gt(array('text' => 'Exporta el llibre en format epub','assign' => 'alt'), $this);?>

            <?php echo smarty_function_img(array('modname' => 'Books','src' => "epub.png",'altml' => true,'titleml' => true,'alt' => $this->_tpl_vars['alt'],'title' => $this->_tpl_vars['alt']), $this);?>

        </a>
        <?php endif; ?>
        <a href="index.php?module=Books&func=getRss&fisbn=<?php echo $this->_tpl_vars['bookInfoBook']['schoolCode']; ?>
_<?php echo $this->_tpl_vars['bookInfoBook']['bookId']; ?>
" target="_blank">
            <?php echo smarty_function_gt(array('text' => 'Subscriu-te a aquest llibre','assign' => 'alt'), $this);?>

            <?php echo smarty_function_img(array('modname' => 'Books','src' => "feed.gif",'altml' => true,'titleml' => true,'alt' => $this->_tpl_vars['alt'],'title' => $this->_tpl_vars['alt']), $this);?>

        </a>

    </div>
    <div class="fieldBookLine"><?php echo smarty_function_gt(array('text' => 'Propietari/ària'), $this);?>
:
        <a href="javascript:catalogue('<?php echo $this->_tpl_vars['order']; ?>
','schoolCode',1,'<?php echo $this->_tpl_vars['bookInfoBook']['schoolCode']; ?>
',1)">
            <?php echo $this->_tpl_vars['bookInfoBook']['schoolType']; ?>
 <?php echo $this->_tpl_vars['bookInfoBook']['schoolName']; ?>

        </a>
    </div>
    <div class="fieldBookLine">
        <?php echo smarty_function_gt(array('text' => 'Nombre de pàgines'), $this);?>
: <?php echo $this->_tpl_vars['bookInfoBook']['bookPages']; ?>

    </div>
    <div class="fieldBookLine">
        <?php echo smarty_function_gt(array('text' => "Data d'edició"), $this);?>
: <?php echo $this->_tpl_vars['bookInfoBook']['bookDayInit']; ?>

    </div>	
    <div class="fieldBookLine">
        <?php echo smarty_function_gt(array('text' => 'Nombre de visites'), $this);?>
: <?php echo $this->_tpl_vars['bookInfoBook']['bookHits']; ?>

    </div>
    <div class="fieldBookLine">
        <?php echo smarty_function_gt(array('text' => 'Darrera visita'), $this);?>
: <?php if ($this->_tpl_vars['bookInfoBook']['bookDayLastVisit'] != ''): ?><?php echo $this->_tpl_vars['bookInfoBook']['bookDayLastVisit']; ?>
 - <?php echo $this->_tpl_vars['bookInfoBook']['bookTimeLastVisit']; ?>
<?php endif; ?>
    </div>
    <div class="fieldBookLine">
        <?php echo smarty_function_gt(array('text' => 'Administrador/a'), $this);?>
: <?php echo $this->_tpl_vars['bookInfoBook']['bookAdminName']; ?>

    </div>
    <div class="urlBook">
        <a href="<?php echo $this->_tpl_vars['bookSoftwareUrl']; ?>
/<?php echo $this->_tpl_vars['bookInfoBook']['schoolCode']; ?>
_<?php echo $this->_tpl_vars['bookInfoBook']['bookId']; ?>
/llibre" target="_blank">
            <?php echo $this->_tpl_vars['bookSoftwareUrl']; ?>
/<?php echo $this->_tpl_vars['bookInfoBook']['schoolCode']; ?>
_<?php echo $this->_tpl_vars['bookInfoBook']['bookId']; ?>
/llibre
        </a>
    </div>		
</div>

<div>&nbsp;</div>

<div class="page">
    <div class="mainTitle"><?php echo smarty_function_gt(array('text' => 'Descripció'), $this);?>
:</div>
    <hr />
    <div class="fieldBookDescription"><?php echo ((is_array($_tmp=$this->_tpl_vars['bookInfoBook']['opentext'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</div>
</div>
<div>&nbsp;</div>

<?php if (count($this->_tpl_vars['comments']) > 0): ?>
<div class="page">
    <div class="mainTitle"><?php echo smarty_function_gt(array('text' => 'Comentaris'), $this);?>
:</div>
    <hr />
    <?php $_from = $this->_tpl_vars['comments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['comments']):
?>
    <div class="bookCommentUserName"><?php echo $this->_tpl_vars['comments']['userName']; ?>
</div>
    <div class="bookCommentDateTime">&nbsp;(<?php echo smarty_function_getDateFormat(array('format' => "d/m/Y",'date' => $this->_tpl_vars['comments']['date']), $this);?>
 - <?php echo smarty_function_getDateFormat(array('format' => "H.i",'date' => $this->_tpl_vars['comments']['date']), $this);?>
)</div>
    <div class="bookComment"><?php echo ((is_array($_tmp=$this->_tpl_vars['comments']['text'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</div>
    <div>&nbsp;</div>
    <?php endforeach; endif; unset($_from); ?>
</div>
<?php endif; ?>

<div class="return">
    <a href="#" onclick="catalogue('','','','',2)">
        <?php echo smarty_function_gt(array('text' => 'Torna al catàleg de llibres'), $this);?>

    </a>
</div>