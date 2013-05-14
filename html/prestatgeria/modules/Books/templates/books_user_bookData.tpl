{include file="books_user_menu.tpl"}

<div class="return">
    <a href="#" onclick="catalogue('','','','',2)">
        {gt text='Torna al catàleg de llibres'}
    </a>
</div>

<div class="field">
    <div class="fieldBookFisbn"><a href="{$bookSoftwareUrl}/{$bookInfoBook.schoolCode}_{$bookInfoBook.bookId}/llibre" target="_blank">{$bookInfoBook.schoolCode}_{$bookInfoBook.bookId}</a></div>
    <div class="fieldBookTitle">
        <a href="{$bookSoftwareUrl}/{$bookInfoBook.schoolCode}_{$bookInfoBook.bookId}/llibre" target="_blank">{$bookInfoBook.bookTitle}</a>
    </div>
    <div class="fieldIcons">
        {if $bookInfoBook.bookCollectionName neq ''}
        <div class="collectionNameField">{gt text='Col·lecció'}: {$bookInfoBook.bookCollectionName}</div>
        {/if}
        {userloggedin assign=userid}
        {if $userid neq ''}
        <a href="javascript:addPrefer({$bookInfoBook.bookId})">
            {gt text='Afegeix als llibres preferits' assign=alt}
            {img modname=Books src=prefer.gif altml=true titleml=true alt=$alt title=$alt}
        </a>
        {/if}

        {if $canComment}
        <a href="#" onClick="addComment('{$bookInfoBook.bookId}',3)">
            {gt text='Afegeix un comentari' assign=alt}
            {img modname=Books src=comment.gif altml=true titleml=true alt=$alt title=$alt}
        </a>
        {if $bookInfoBook.bookAdminName eq $userName || $userName eq $bookInfoBook.schoolCode}
        <a href="{modurl modname='Books' type='user' func='editBook' bookId=$bookInfoBook.bookId}">
            {gt text='Edita les característiques del llibre' assign=alt}
            {img modname=Books src=editfolder.gif altml=true titleml=true alt=$alt title=$alt}
        </a>
        {if $bookInfoBook.bookAdminName eq $userName}
        <a href="{modurl modname='Books' type='user' func='newPublic'}">
            {gt text='Publicita el teu llibre' assign=alt}
            {img modname=Books src=publi.gif altml=true titleml=true alt=$alt title=$alt}
        </a>
        {/if}		
        {/if}
        {/if}

        {if $canExport}
        <a href="{modurl modname='Books' type='user' func='exportBook' bookId=$bookInfoBook.bookId}">
            {gt text='Exporta el llibre' assign=alt}
            {img modname=Books src=export_book.png altml=true titleml=true alt=$alt title=$alt}
        </a>
        <a href="{modurl modname='Books' type='user' func='getHtmlBook' bookId=$bookInfoBook.bookId}">
            {gt text='Exporta el llibre en format html' assign=alt}
            {img modname=Books src=html.png altml=true titleml=true alt=$alt title=$alt}
        </a>
        <a href="{modurl modname='Books' type='user' func='getScormBook' bookId=$bookInfoBook.bookId}">
            {gt text='Exporta el llibre en format scorm' assign=alt}
            {img modname=Books src=scorm.png altml=true titleml=true alt=$alt title=$alt}
        </a>
        <a href="{modurl modname='Books' type='user' func='getEpubBook' bookId=$bookInfoBook.bookId}">
            {gt text='Exporta el llibre en format epub' assign=alt}
            {img modname=Books src=epub.png altml=true titleml=true alt=$alt title=$alt}
        </a>
        {/if}
        <a href="index.php?module=Books&func=getRss&fisbn={$bookInfoBook.schoolCode}_{$bookInfoBook.bookId}" target="_blank">
            {gt text='Subscriu-te a aquest llibre' assign=alt}
            {img modname=Books src=feed.gif altml=true titleml=true alt=$alt title=$alt}
        </a>

    </div>
    <div class="fieldBookLine">{gt text='Propietari/ària'}:
        <a href="javascript:catalogue('{$order}','schoolCode',1,'{$bookInfoBook.schoolCode}',1)">
            {$bookInfoBook.schoolType} {$bookInfoBook.schoolName}
        </a>
    </div>
    <div class="fieldBookLine">
        {gt text='Nombre de pàgines'}: {$bookInfoBook.bookPages}
    </div>
    <div class="fieldBookLine">
        {gt text="Data d'edició"}: {$bookInfoBook.bookDayInit}
    </div>	
    <div class="fieldBookLine">
        {gt text='Nombre de visites'}: {$bookInfoBook.bookHits}
    </div>
    <div class="fieldBookLine">
        {gt text='Darrera visita'}: {if $bookInfoBook.bookDayLastVisit neq ''}{$bookInfoBook.bookDayLastVisit} - {$bookInfoBook.bookTimeLastVisit}{/if}
    </div>
    <div class="fieldBookLine">
        {gt text='Administrador/a'}: {$bookInfoBook.bookAdminName}
    </div>
    <div class="urlBook">
        <a href="{$bookSoftwareUrl}/{$bookInfoBook.schoolCode}_{$bookInfoBook.bookId}/llibre" target="_blank">
            {$bookSoftwareUrl}/{$bookInfoBook.schoolCode}_{$bookInfoBook.bookId}/llibre
        </a>
    </div>		
</div>

<div>&nbsp;</div>

<div class="page">
    <div class="mainTitle">{gt text='Descripció'}:</div>
    <hr />
    <div class="fieldBookDescription">{$bookInfoBook.opentext|nl2br}</div>
</div>
<div>&nbsp;</div>

{if $comments|@count gt 0}
<div class="page">
    <div class="mainTitle">{gt text='Comentaris'}:</div>
    <hr />
    {foreach item=comments from=$comments}
    <div class="bookCommentUserName">{$comments.userName}</div>
    <div class="bookCommentDateTime">&nbsp;({getDateFormat format=d/m/Y date=$comments.date} - {getDateFormat format=H.i date=$comments.date})</div>
    <div class="bookComment">{$comments.text|nl2br}</div>
    <div>&nbsp;</div>
    {/foreach}
</div>
{/if}

<div class="return">
    <a href="#" onclick="catalogue('','','','',2)">
        {gt text='Torna al catàleg de llibres'}
    </a>
</div>
