{insert name="getstatusmsg"}
<noscript>
<div class="noscript">
    <p>
        {gt text='Sembla que el teu navegador té el JavaScript inhabilitat. Aquesta aplicacó web necesita JavaScript per funcionar correctament. Si us plau, habilita el JavaScript a les preferències del teu navegador o actualitza a un navegador amb suport de JavaScript i intenta-ho de nou.'}
    </p>
</div>
</noscript>
<div class="page">
    <div class="mainTitle">{gt text='Edita el llibre'}</div>
    <hr />
    <form id="editBook" action="{modurl modname='Books' type='user' func='updateEditBook'}" method="post" enctype="application/x-www-form-urlencoded">
        <div class="form">
            <input type="hidden" name="bookId" value="{$book.bookId}" />
            <input type="hidden" name="csrftoken" value="{insert name='csrftoken'}" />
            <label for="ccentre">{gt text='Codi de correu del centre'}:</label> <strong>{$book.schoolCode}</strong>
        </div>
        <div id="mainBookInfo">
            <div class="form">
                <label for="bookTitle">{gt text='Títol del llibre'}:</label>
                <input name="bookTitle" id="bookTitle" type="text" title="{gt text='Introdueix el títol del llibre'}" maxlength="100" size="40" value="{$book.bookTitle}" />
                {gt text='Ajuda' assign=alt}
                <a onClick="return overlay(this, 'help2')" style="cursor: pointer;">
                    {img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}
                </a>				
            </div>
            <div class="form">
                <label for="bookLang">{gt text='Idioma del llibre'}: </label>
                <select name="bookLang" id="llibre">
                    <option label="{gt text='català'}" value="ca" {if $book.bookLang eq 'ca'}selected{/if}>{gt text='català'}</option>
                    <option label="{gt text='castellà'"}" value="es" {if $book.bookLang eq 'es'}selected{/if}>{gt text='castellà'}</option>
                    <option label="{gt text='anglès'}" value="en" {if $book.bookLang eq 'en'}selected{/if}>{gt text='anglès'}</option>
                    <option label="{gt text='francès'}" value="fr" {if $book.bookLang eq 'fr'}selected{/if}>{gt text='francès'}</option>
                </select>
                {gt text='Ajuda' assign=alt}
                <a onClick="return overlay(this, 'help3')" style="cursor: pointer;">
                    {img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}
                </a>		
            </div>
            <div class="form">
                <label for="descllibre">{gt text='Descripció del llibre'}:</label>
                {gt text='Ajuda' assign=alt}
                <a onClick="return overlay(this, 'help4')" style="cursor: pointer;">
                    {img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}
                </a>		
                <br />
                <textarea name="opentext" rows="10" cols="45" title="{gt text='Introdueix una descripció del llibre'}" id="editbook">{$bookSettings.opentext}</textarea>
            </div>
            <div class="form">
                <table>
                    <tr>
                        <td>
                            <label for="theme">{gt text='Estil del llibre'}: </label>
                            <select name="theme" id="theme" onChange="changeImg(view,theme.value)">
                                <option label="Classic" value="classic" {if $bookSettings.theme eq 'classic'}selected{/if}>Classic</option>
                                <option label="Workbook" value="workbook" {if $bookSettings.theme eq 'workbook'}selected{/if}>WorkBook</option>
                                <option label="Modern" value="modern" {if $bookSettings.theme eq 'modern'}selected{/if}>Modern</option>
                                <option label="Marble" value="marble" {if $bookSettings.theme eq 'marble'}selected{/if}>Marble</option>
                                <option label="Leaves" value="leaves" {if $bookSettings.theme eq 'leaves'}selected{/if}>Leaves</option>
                                <option label="Stars" value="stars" {if $bookSettings.theme eq 'stars'}selected{/if}>Stars</option>
                            </select>
                            {gt text='Ajuda' assign=alt}
                            <a onClick="return overlay(this, 'help5')" style="cursor: pointer;">
                                {img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}
                            </a>					
                        </td>
                        <td>
                            <img src="../llibre/themes/{$bookSettings.theme}/view.png" name="view" alt="{gt text="Mostra de l'estil"}"/>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form">
                <label for="bookDescript">{gt text='Descriptors de cerca'}:</label>
                <input name="bookDescript" id="bookDescript" type="text" title="{gt text='Introdueix els descriptors del llibre'}" maxlength="100" size="25" value="{$book.bookDescript}" class="errMsg_alphanumall" />
                {gt text='Ajuda' assign=alt}
                <a onClick="return overlay(this, 'help6')" style="cursor: pointer;">
                    {img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}
                </a>				
            </div>
        </div>
        <div class="form">
            {if $collections|@count gt 0 AND $book.collectionId eq 0}
            <label for="bookCollection">{gt text='Col·lecció'}:</label>
            <select name="bookCollection" id="bookCollection">
                <option value="0">{gt text='-- Associa el llibre a una col·lecció --'}</option>
                {foreach item=collection from=$collections}
                <option label="{$collection.collectionName}" value="{$collection.collectionId}" {if $book.bookCollection eq $collection.collectionId} selected {/if}>{$collection.collectionName}</option>				
                {/foreach}
            </select>
            {gt text='Ajuda' assign=alt}
            <a onClick="return overlay(this, 'help10')" style="cursor: pointer;">
                {img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}
            </a>		
            {else}
            {if $book.collectionId eq 0}
            <div class="form">
                {gt text='-- No hi ha col·leccions disponibles --'}
            </div>
            {else}
            <label for="bookCollection">{gt text='Col·lecció'}:</label>
            <strong>{$collections[$book.collectionId].collectionName}</strong>
            {/if}
            {/if}
        </div>
        {if $isOwner}
        <div class="form">		
            <label for="mailxtec">{gt text="Correu de l'administrador/a"}:</label>
            {if $canCreateToOthers eq 1}
            <input name="bookAdminName" id="bookAdminName" type="text" title="{gt text='Correu XTEC'}" maxlength="8" value="{$book.bookAdminName}" size="8" />@xtec.cat
            {else}
            <input name="bookAdminName" id="bookAdminName" type="hidden" value="{$book.bookAdminName}"/>{$userName}@xtec.cat
            {/if}
            {gt text='Ajuda' assign=alt}
            <a onClick="return overlay(this, 'help7')" style="cursor: pointer;">{img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}</a>		
        </div>
        {else}
        <input name="bookAdminName" id="bookAdminName" type="hidden" value="{$book.bookAdminName}"/>
        {/if}
        <input type="button" name="submitButton" id="submitButton" value="{gt text='Edita el llibre'}" onClick="editExistingBook()"/>
        <input type="button" name="fesn" id="fesn" value="{gt text='Cancel·la'}" onClick="history.go(-1)" />
    </form>
</div>
<div id="help1" class="helpBox">
    <div class="helpHeader">&nbsp;</div>
    <div class="helpContent">
        {$helpTexts._BOOKSIMPORTEXPORTEDBOOK}
        {gt text='Tanca' assign=alt}
        <div class="helpBoxClose">
            <a href="#" onClick="overlayclose('help1'); return false">
                {gt text='Tanca la finestra'} {img modname=Books src=close.png altml=true titleml=true alt=$alt title=$alt}
            </a>
        </div>
    </div>
</div>
<div id="help2" class="helpBox">
    <div class="helpHeader">&nbsp;</div>
    <div class="helpContent">
        {$helpTexts._BOOKSTITLETOSHOW}
        {gt text='Tanca' assign=alt}
        <div class="helpBoxClose">
            <a href="#" onClick="overlayclose('help2'); return false">
                {gt text='Tanca la finestra'} {img modname=Books src=close.png altml=true titleml=true alt=$alt title=$alt}
            </a>
        </div>
    </div>
</div>
<div id="help3" class="helpBox">
    <div class="helpHeader">&nbsp;</div>
    <div class="helpContent">
        {$helpTexts._BOOKSLANGUAGETOSHOW}
        {gt text='Tanca' assign=alt}
        <div class="helpBoxClose">
            <a href="#" onClick="overlayclose('help3'); return false">
                {gt text='Tanca la finestra'} {img modname=Books src=close.png altml=true titleml=true alt=$alt title=$alt}
            </a>
        </div>
    </div>
</div>
<div id="help4" class="helpBox">
    <div class="helpHeader">&nbsp;</div>
    <div class="helpContent">
        {$helpTexts._BOOKSINTRODUCTIONTOSHOW}
        {gt text='Tanca' assign=alt}
        <div class="helpBoxClose">
            <a href="#" onClick="overlayclose('help4'); return false">
                {gt text='Tanca la finestra'} {img modname=Books src=close.png altml=true titleml=true alt=$alt title=$alt}
            </a>
        </div>
    </div>
</div>
<div id="help5" class="helpBox">
    <div class="helpHeader">&nbsp;</div>
    <div class="helpContent">
        {$helpTexts._BOOKSSTYLETOSHOW}
        {gt text='Tanca' assign=alt}
        <div class="helpBoxClose">
            <a href="#" onClick="overlayclose('help5'); return false">
                {gt text='Tanca la finestra'} {img modname=Books src=close.png altml=true titleml=true alt=$alt title=$alt}
            </a>
        </div>
    </div>
</div>
<div id="help6" class="helpBox">
    <div class="helpHeader">&nbsp;</div>
    <div class="helpContent">
        {$helpTexts._BOOKSDESCRIPTORSTOSHOW}
        {gt text='Tanca' assign=alt}
        <div class="helpBoxClose">
            <a href="#" onClick="overlayclose('help6'); return false">
                {gt text='Tanca la finestra'} {img modname=Books src=close.png altml=true titleml=true alt=$alt title=$alt}
            </a>
        </div>
    </div>
</div>
<div id="help7" class="helpBox">
    <div class="helpHeader">&nbsp;</div>
    <div class="helpContent">
        {$helpTexts._BOOKSADMINTOSHOW}
        {gt text='Tanca' assign=alt}
        <div class="helpBoxClose">
            <a href="#" onClick="overlayclose('help7'); return false">
                {gt text='Tanca la finestra'} {img modname=Books src=close.png altml=true titleml=true alt=$alt title=$alt}
            </a>
        </div>
    </div>
</div>
<div id="help10" class="helpBox">
    <div class="helpHeader">&nbsp;</div>
    <div class="helpContent">
        {gt text='Si hi ha col·leccions disponibles, podeu associar el llibre a una de les col·leccions proposades.<br />Això farà possible llistar els llibres per col·leccions.' assign=alt}
        {$helpTexts._BOOKSCOLLECTIONSTOSHOW}
        {gt text='Tanca' assign=alt}
        <div class="helpBoxClose">
            <a href="#" onClick="overlayclose('help10'); return false">
                {gt text='Tanca la finestra'} {img modname=Books src=close.png altml=true titleml=true alt=$alt title=$alt}
            </a>
        </div>
    </div>
</div>
<script>
    var noBookTitle = "{{gt text='No has escrit el nom del llibre'}}";
    var noAdminUser = "{{gt text="No has especificat l'usuari/ària administrador del llibre"}}";
    var adminPassToShort = "{{gt text="La contrasenya de l'usuari/ària administrador és massa curta. Ha de tenir com a mínim sis caràcters"}}";
</script>