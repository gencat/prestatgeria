{include file="books_user_menu.tpl"}
<div class="search" id="search">
    <form id="searchForm" name="searchForm" method="post" enctype="application/x-www-form-urlencoded" action="javascript:void(0);">
        <input type="hidden" name="a" value="search" />
        <input type="hidden" name="insearch" value="1" />
        <input type="hidden" name="searchAction" value="{$searchAction}" />
        {gt text='Cerca' assign=alt}
        {img modname=Books src=search.png altml=true titleml=true alt=$alt title=$alt id="searchIcon"}
        {if $filter eq 'title' || $filter eq 'name' || $filter eq 'schoolCode'}
        	{gt text='El'}&nbsp;
        {elseif $filter eq 'collection'}
        	{gt text='La'}&nbsp;
        {elseif $filter eq 'descriptor'}
        	{gt text='El'}&nbsp;
        {elseif $filter eq 'lang'}
        	{gt text="L'"}
        {elseif $filter eq 'city'}
        	{gt text='El'}&nbsp;
        {elseif $filter eq 'admin'}
        	{gt text="L'"}
        {else}
        	{gt text='El'}&nbsp;
        {/if}
        <select name="filter" onChange="searchReload(document.searchForm.filter.value, document.searchForm.filterValue.value, '{$order}')">
            <option value="title" {if $filter eq 'title'} selected {/if}>{gt text='títol'}</option>		
            <option value="name" {if $filter eq 'name' || $filter eq 'schoolCode'} selected {/if}>{gt text='nom del centre'}</option>
            <option value="descriptor" {if $filter eq 'descriptor'} selected {/if}>{gt text='descriptor'}</option>
            <option value="lang" {if $filter eq 'lang'} selected {/if}>{gt text='idioma'}</option>			
            <option value="city" {if $filter eq 'city'} selected {/if}>{gt text='municipi'}</option>
            <option value="admin" {if $filter eq 'admin'} selected {/if}>{gt text='usuari/ària administrador/a'}</option>
            <option value="collection" {if $filter eq 'collection'} selected {/if}>{gt text='col·lecció'}</option>
        </select>
        {if $filter eq 'name' || $filter eq 'schoolCode'}
	        {gt text='propietari del llibre és'} <input type="text" name="filterValue" autocomplete="off" maxlength="40" size="20" value="{$filterValue}" onKeyUp="autocompleteSearch('name',this.value,'{$order}')"/>
	        {gt text='Ajuda' assign=alt}
         	<a onClick="return overlay(this, 'help6')">{img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}</a>
        {elseif $filter eq 'collection'}
	        {gt text='a la qual pertany el llibre és'}
	        <select name="filterValue" id="filterValue"  onChange="catalogue('{$order}','collection',1,this.value,1)">
	            <option>{gt text='Tria una col·lecció...'}</option>
	            {foreach item=collection from=$collections}
	            <option label="{$collection.collectionName}" value="{$collection.collectionId}" {if $filterValue eq $collection.collectionId} selected {/if}>{$collection.collectionName}</option>				
	            {/foreach}
	        </select>
	        {gt text='Ajuda' assign=alt}
	        <a onClick="return overlay(this, 'help1')">{img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}</a>			
		{elseif $filter eq 'descriptor'}
	        {gt text='del llibre és'} <input type="text" name="filterValue" autocomplete="off" maxlength="40" size="20" value="{$filterValue}" onKeyUp="autocompleteSearch('descriptor',this.value,'{$order}')"/>
	        {gt text='Ajuda' assign=alt}
	        <a onClick="return overlay(this, 'help2')">
	            {img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}
	        </a>
	        <input type="button" value="Envia" onClick="catalogue('{$order}','descriptor',1,document.searchForm.filterValue.value,1)"/>			
		{elseif $filter eq 'lang'}
	        {gt text='del llibre és'}
	        <select name="filterValue" onChange="catalogue('{$order}','lang',1,this.value,1)">
	            <option>{gt text='Tria un idioma...'}</option>
	            <option value="ca" {if $filterValue eq 'ca'} selected {/if}>{gt text='català'}</option>
	            <option value="es" {if $filterValue eq 'es'} selected {/if}>{gt text='castellà'}</option>
	            <option value="en" {if $filterValue eq 'en'} selected {/if}>{gt text='anglès'}</option>
	            <option value="fr" {if $filterValue eq 'fr'} selected {/if}>{gt text='francès'}</option>			
	        </select>
	        {gt text='Ajuda' assign=alt}
	        <a onClick="return overlay(this, 'help3')">
	            {img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}
	        </a>			
		{elseif $filter eq 'city'}
	        {gt text='on està el centre és'} <input type="text" name="filterValue" autocomplete="off" maxlength="40" size="20" value="{$filterValue|replace:"--apos--":"'"}" onKeyUp="autocompleteSearch('city',this.value,'{$order}')"/>
	                                                {gt text='Ajuda' assign=alt}
	                                                <a onClick="return overlay(this, 'help4')">{img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}</a>
	        {elseif $filter eq 'admin'}
	        {gt text='del llibre és'} <input type="text" name="filterValue" autocomplete="off" maxlength="8" size="8" value="{$filterValue}" onKeyUp="autocompleteSearch('admin',this.value,'{$order}')"/>
	        {gt text='Ajuda' assign=alt}
	        <a onClick="return overlay(this, 'help5')">{img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}</a>
		{else}
	        {gt text='del llibre conté les paraules'} <input type="text" name="filterValue" autocomplete="off" maxlength="40" size="20" value="{$filterValue}"/>
	        {gt text='Ajuda' assign=alt}
	        <a onClick="return overlay(this, 'help7')">{img modname=Books src=info.gif altml=true titleml=true alt=$alt title=$alt}</a>
	        <input type="button" value="Envia" onClick="catalogue('{$order}','title',1,document.searchForm.filterValue.value,1);"/>
        {/if}
        <div style="visibility: hidden; border: 1px solid #ffff9f; background-color:#ffffcf; padding: 5px; width: 200px; margin-left: 80px; margin-top: 7px;" id="autocompletediv"></div>
    </form>
</div>

<div id="help1" class="helpBox">
    <div class="helpHeader">&nbsp;</div>
    <div class="helpContent"> 	
        {gt text='Tria una col·lecció de la llista.'}
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
        {gt text='Posa el descriptor sobre el qual vols fer la cerca.'}
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
        {gt text='Tria un idioma de la llista.'}
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
        {gt text="Posa la població a la qual pertany el centre. Pots cercar per més d'una població amb els noms separats per un espai."}
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
        {gt text="Posa el nom d'usuari/ària XTEC."}
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
        {gt text="Indica el nom del centre que vols cercar. Si vols posar més d'un centre, pots separar els noms per un espai."}
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
        {gt text='Indica la paraula o paraules que ha de tenir el títol del llibre. Cal separar les paraules per un espai.'}
        {gt text='Tanca' assign=alt}
        <div class="helpBoxClose">
            <a href="#" onClick="overlayclose('help7'); return false">
                {gt text='Tanca la finestra'} {img modname=Books src=close.png altml=true titleml=true alt=$alt title=$alt}
            </a>
        </div>
    </div>
</div>
