{include file="books_admin_menu.tpl"}
<div class="z-admincontainer">
    <div class="z-adminpageicon">{img modname=core src=configure.png set=icons/large}</div>
    <h2>{gt text='Configura el mòdul'}</h2>
    <form  class="z-form" method="post" name="configura" id="configura" action="{modurl modname='Books' type='admin' func='update_conf'}" >
        <input type="hidden" name="csrftoken" value="{insert name='csrftoken'}" />
        <div style="height:20px;">&nbsp;</div>
        <div class="z-formrow">
            <label for="bookSoftwareUrl">{gt text='Adreça relativa del programari de llibres'}</label>
            <input type="text" name="bookSoftwareUrl" size="50" value="{$bookSoftwareUrl}"  />
        </div>
        <div class="z-formrow">
            <label for="bookSoftwareUri">{gt text='URI relativa del programari de llibres'}</label>
            <input type="text" name="bookSoftwareUri" size="50" value="{$bookSoftwareUri}"  />
        </div>
        <div class="z-formrow">
            <label for="canCreateToOthers">{gt text='Els usuaris amb trets de creació de llibres poden crear llibres per a terceres persones'}</label>
            <input type="checkbox" name="canCreateToOthers"  {if $canCreateToOthers eq 1}checked{/if} value="1" />
        </div>
        <div class="z-formrow">
            <label for="mailDomServer">{gt text='Domini de correu dels usuaris'}</label>
            <input type="text" name="mailDomServer" size="10" value="{$mailDomServer}"  />
        </div>
        <div class="z-formrow">
            <label for="booksDatabase">{gt text='Nom de la base de dades dels llibres'}</label>
            <input type="text" name="booksDatabase" size="10" value="{$booksDatabase}"  />
        </div>
        <div class="z-formrow">
            <label for="serverImageFolder">{gt text='Directori on es desen les imatges dels llibres.'}</label>
            <input type="text" name="serverImageFolder" size="50" value="{$serverImageFolder}"  />
        </div>
        <div class="z-formrow">
            <label for="pwd">{gt text='Directori del Zikula'}</label>
            {$pwd}
        </div>
        {gt text='Create' assign=alt_create}
        {gt text='Cancel' assign=alt_cancel}
        <div class="z-center">
            <span class="z-buttons">
                <a href="#" onClick="javascript:document.forms['configura'].submit();">
                    {img modname=core src=button_ok.png set=icons/small altml=true titleml=true __alt='Crea' __title='Crea'}
                    {gt text="Crea"}
                </a>
            </span>
            <span class="z-buttons">
                <a href="{modurl modname='Books' type='admin' func='main'}">
                    {img modname=core src=button_cancel.png set=icons/small altml=true titleml=true __alt='Cancel·la' __title='Cancel·la'}
                    {gt text="Cancel·la"}
                </a>
            </span>
        </div>
    </form>
</div>
