{include file="books_user_menu.tpl"}
<div class="blocContent">
    {if $canAdmin}
    <div class="blocLink">
        <a href="admin.php">
            {gt text='Administració'}
        </a>
    </div>
    <div style="clear:both;"></div>
    {/if}
    <div class="blocLink">
        <a href="javascript:catalogue('lastEntry','',1,'',2)">
            {gt text='Catàleg de llibres'}
        </a>
    </div>
    <div style="clear:both;"></div>
    <div class="blocLink">
        <a href="javascript:collections()">
            {gt text='Col·leccions'}
        </a>
    </div>
    {if $canAdminCreateBooks}
    <div style="clear:both;"></div>
    <div class="blocLink">
        <a href="javascript:manage()">
            {gt text='Gestiona els llibres'}
        </a>

    </div>
    {/if}
    <div style="clear:both;"></div>
    <div class="blocLink">
        <a href="index.php?module=IWwebbox&ref=pmf">
            {gt text='Preguntes més freqüents'}
        </a>
    </div>
    <div style="clear:both;"></div>
    {userloggedin assign=userid}
    {if $userid neq ''}
    <div class="blocLink">
        <a href="{modurl modname='books' type='user' func='newItem'}">
            {gt text='Crea un llibre nou'}
        </a>
    </div>
    {/if}
    <div style="clear:both;"></div>
    {if $mustInscribe}
    <div class="blocLink">
        <a href="{modurl modname='books' type='user' func='inscribe'}">
            {gt text='Inscriure el centre'}
        </a>
    </div>
    <div style="clear:both;"></div>
    {/if}
    <div class="blocLink">
        <a href="{$bookSoftwareUrl}/llibre.php?fisbn=llibres_1" target="_blank">
            Com funcionen els llibres?
        </a>
    </div>
</div>
<div style="clear:both; padding-bottom: 20px;"></div>
