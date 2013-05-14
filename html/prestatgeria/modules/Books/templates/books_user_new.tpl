{insert name="getstatusmsg"}
<noscript>
<div class="noscript">
    <p>{gt text='Sembla que el teu navegador té el JavaScript inhabilitat. Aquesta aplicacó web necesita JavaScript per funcionar correctament. Si us plau, habilita el JavaScript a les preferències del teu navegador o actualitza a un navegador amb suport de JavaScript i intenta-ho de nou.'}</p>
</div>
</noscript>
<div class="page">
    <div class="mainTitle">{gt text='Crea un llibre nou'}</div>
    <hr />
    <form id="newBook" action="{modurl modname='Books' type='user' func='updateBook'}" method="post" enctype="multipart/form-data">
        <div class="form">
            <input type="hidden" name="ccentre" value="{$schoolCode}" />
            <input type="hidden" name="csrftoken" value="{insert name='csrftoken'}" />
            <label for="ccentre">{gt text='Codi de correu del centre'}:</label> <strong>{$schoolCode}</strong>
        </div>
        <div class="form">
            <label for="importBook">{gt text='Importa un llibre'}:</label>
            <input name="importBook" id="importBook" type="checkbox" title="{gt text='Importa un llibre'}" value="1" onclick="javascript:exportBook();" />
            {gt text='Ajuda' assign=alt}
            <a onClick="return overlay(this, 'help1')" style="cursor: pointer;">
                {img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}
            </a>				
        </div>
        <div id="importFile" class="z-hide">
            <div class="form">
                <label for="importFile">{gt text="Fitxer d'importació"}:</label>
                <input type="file" name="importFile" />
            </div>
        </div>
        <div id="mainBookInfo">
            <div class="form">
                <label for="tllibre">{gt text='Títol del llibre'}:</label>
                <input name="tllibre" id="tllibre" type="text" title="{gt text='Introdueix el títol del llibre'}" maxlength="100" size="40" value="" />
                {gt text='Ajuda' assign=alt}
                <a onClick="return overlay(this, 'help2')" style="cursor: pointer;">
                    {img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}
                </a>				
            </div>
            <div class="form">
                <label for="illibre">{gt text='Idioma del llibre'}: </label>
                <select name="illibre" id="llibre">
                    <option label="{gt text='català'}" value="ca">{gt text='català'}</option>
                    <option label="{gt text='castellà'}" value="es">{gt text='castellà'}</option>
                    <option label="{gt text='anglès'}" value="en">{gt text='anglès'}</option>
                    <option label="{gt text='francès'}" value="fr">{gt text='francès'}</option>
                </select>
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
                <textarea name="descllibre" rows="10" cols="45"	title="{gt text='Introduïu una descripció del llibre'}" id="editbook"></textarea>
            </div>
            <div class="form">
                <table>
                    <tr>
                        <td>
                            <label for="ellibre">{gt text='Estil del llibre'}: </label>
                            <select name="ellibre" id="ellibre" onChange="changeImg(view,ellibre.value)">
                                <option label="Classic" value="classic">Classic</option>
                                <option label="Workbook" value="workbook">WorkBook</option>
                                <option label="Modern" value="modern">Modern</option>
                                <option label="Marble" value="marble">Marble</option>
                                <option label="Leaves" value="leaves">Leaves</option>
                                <option label="Stars" value="stars">Stars</option>
                            </select>
                            {gt text='Ajuda' assign=alt}
                            <a onClick="return overlay(this, 'help5')" style="cursor: pointer;">
                                {img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}
                            </a>					
                        </td>
                        <td>
                            <img src="../llibre/themes/classic/view.png" name="view" alt="{gt text="Mostra de l'estil"}" />
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form">
                <label for="dllibre">{gt text='Descriptors de cerca'}:</label>
                <input name="dllibre" id="dllibre" type="text" title="{gt text='Introduïu els descriptors del llibre'}" maxlength="100" size="25" value="" class="errMsg_alphanumall" />
                {gt text='Ajuda' assign=alt}
                <a onClick="return overlay(this, 'help6')" style="cursor: pointer;">
                    {img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}
                </a>				
            </div>
        </div>
        {if $collections|@count gt 0}
        <div class="form">
            <label for="bookCollection">{gt text='Col·lecció'}:</label>
            <select name="bookCollection" id="cllibre">
                <option value="0">{gt text='-- Associa el llibre a una col·lecció --'}</option>
                {foreach item=collection from=$collections}
                <option label="{$collection.collectionName}" value="{$collection.collectionId}">{$collection.collectionName}</option>				
                {/foreach}
            </select>
            {gt text='Ajuda' assign=alt}
            <a onClick="return overlay(this, 'help10')" style="cursor: pointer;">
                {img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}
            </a>		
        </div>
        {else}
        <input type="hidden" name="bookCollection" value="0">
        <div class="form">
            {gt text='-- No hi ha col·leccions disponibles --'}
            {gt text='Ajuda' assign=alt}
            <a onClick="return overlay(this, 'help10')" style="cursor: pointer;">
                {img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}
            </a>	
        </div>		
        {/if}
        <div class="form">		
            <label for="mailxtec">{gt text="Correu de l'administrador/a"}:</label>
            {if $canCreateToOthers eq 1}
            <input name="mailxtec" id="mailxtec" type="text" title="{gt text='Correu XTEC'}" maxlength="8" value="" size="8" />@xtec.cat
            {else}
            <input name="mailxtec" id="mailxtec" type="hidden" value="{$userName}"/>{$userName}@xtec.cat
            {/if}
            {gt text='Ajuda' assign=alt}
            <a onClick="return overlay(this, 'help7')" style="cursor: pointer;">
                {img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}
            </a>		
        </div>
        <div class="form" id="rdCondicions">
            <label for="condicions">{gt text="Condicions d'ús dels llibres"}:</label>
            <br />
            <div class="condicions">
                {include file="books_user_terms1.tpl"}
            </div>
        </div>
        <div class="form" id="rdCondicions">	
            <label for="idSi" class="radio">{gt text='No accepto'}</label>		
            <input name="confirm" value="-1" title="{gt text='Escull entre una de les opcions'}" type="radio" checked="checked" />
            <label for="idNo" class="radio">{gt text='Accepto'}</label>			
            <input name="confirm" value="1" title="{gt text='Escull entre una de les opcions'}" type="radio" />
            {gt text='Ajuda' assign=alt}
            <a onClick="return overlay(this, 'help9')" style="cursor: pointer;">
                {img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}
            </a>
        </div>
        <input type="button" name="submitButton" id="submitButton" value="{gt text='Entra llibre'}" onClick="createNewBook()"/>
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
<div id="help9" class="helpBox">
    <div class="helpHeader">&nbsp;</div>
    <div class="helpContent">
        {$helpTexts._BOOKSACCEPTTOSHOW}
        {gt text='Tanca' assign=alt}
        <div class="helpBoxClose">
            <a href="#" onClick="overlayclose('help9'); return false">
                {gt text='Tanca la finestra'} {img modname=Books src=close.png altml=true titleml=true alt=$alt title=$alt}
            </a>
        </div>
    </div>
</div>
<div id="help10" class="helpBox">
    <div class="helpHeader">&nbsp;</div>
    <div class="helpContent">
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
    var noBookTitle	= "{{gt text='No has escrit el nom del llibre'}}";
    var noRulesAccepted	= "{{gt text='No has acceptat les condicions d\'ús del servei'}}";
    var noAdminUser	= "{{gt text='No has especificat l\'usuari/ària administrador del llibre'}}";
    var adminPassToShort = "{{gt text='La contrasenya de l\'usuari/ària administrador és massa curta. Ha de tenir com a mínim sis caràcters'}}";
    var noImportFile	= "{{gt text='No has triat el fitxer d\'importació'}}";
</script>