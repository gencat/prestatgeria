{include file="books_user_menu.tpl"}
{insert name="getstatusmsg"}
<div style="height:20px;">&nbsp;</div>
<div class="page">
    {if $canCreateToOthers}
    <div class="mainTitle">
        {gt text='Persones que poden crear llibres en nom del centre'}
    </div>
    <hr />
    {gt text="Les persones de la llista poden crear llibres en nom del centre i assignar-ne l'administració a terceres persones."}
    <br />
    <br />
    <div id="creatorsList">
        {include file="books_user_manageCreators.tpl"}
    </div>
    <br />
    <br />
    <form name="newCreator">
        {gt text='Autoritza la creació de llibres nous a'} <input type="text" size="12" maxlength="12" name="creatorUserName" />
        <input type="button" value="{gt text='Autoritza'}" onClick="allowUser('addCreator',creatorUserName.value)" />
    </form>
    {/if}
    <div class="mainTitle">{gt text='Estat dels llibres del centre'}</div>
    <hr />
    <table width="100%">
        <thead>
        <th align="center">{gt text='Títol'}</th>
        <th align="center">{gt text='Data de creació'}</th>
        <th align="center">{gt text='Darrera visita'}</th>
        {*}
        <th align="center">{gt text="_BOOKSMANAGECADUCITYDATE"}</th>
        {*}
        <th align="center">{gt text='Admin.'}</th>		
        <th align="center">{gt text='Pàg.'}</th>		
        <th align="center">{gt text='Vis.'}</th>
        <th align="center">{gt text='Opcions'}</th>
        </thead>
        {foreach item=book from=$books}
        {if $book.bookState neq -2}
        <tr bgcolor="{cycle values="#FFFFFF, #EEEEEE"}">
            <td class="bookTitle">
                {if $book.bookState eq 1}
                <div title="{gt text='Llibre penjat a la prestatgeria'}">
                    <a href="{$bookSoftwareUrl}/llibre.php?fisbn={$book.schoolCode}_{$book.bookId}" target="_blank">
                        <font color="#003300">
                        <strong>{$book.bookTitle}</strong>
                        </font>
                    </a></div>
                {elseif $book.bookState eq 0}
                <div title="{gt text='Llibre no penjat a la prestatgeria'}">
                    <a href="{$bookSoftwareUrl}/llibre.php?fisbn={$book.schoolCode}_{$book.bookId}" target="_blank">
                        <font color="#CC9900">
                        <strong>{$book.bookTitle}</strong>
                        </font>
                    </a>
                </div>					
                {else}
                <div title="{gt text="Llibre pendent d'activació"}">
                     <font color="#990000">
                    <strong>{$book.bookTitle}</strong>
                    </font>
                </div>
                {/if}
            </td>
            <td class="blocSchool">
                {$book.bookDayInit}
            </td>
            <td class="blocSchool">
                {$book.bookDateLastVisit}
            </td>
            {*}
            <td class="blocSchool">
                {$book.bookCaducity}
            </td>
            {*}
            <td class="blocSchool">
                {$book.bookAdminName}
                {if $book.bookAdminName eq '' AND $book.newBookAdminName neq ''}
                {$book.newBookAdminName}
                <div>({gt text="Ha d'acceptar"})</div>
                {/if}
            </td>
            <td class="blocSchool">
                {$book.bookPages}
            </td>
            <td class="blocSchool">
                {$book.bookHits}
            </td>
            <td class="blocSchool">
                <a href="{modurl modname='Books' type='user' func='editBook' bookId=$book.bookId}">
                    {gt text='Edita les característiques del llibre' assign=alt}
                    {img modname=Books src=editfolder.gif altml=true titleml=true alt=$alt title=$alt}
                </a>
                <a href="{modurl modname='Books' type='user' func='removeBook' bookId=$book.bookId}">
                    {gt text='Esborra completament el llibre' assign=alt}
                    {img modname=core src=14_layer_deletelayer.png set=icons/extrasmall altml=true titleml=true alt=$alt title=$alt}
                </a>
            </td>
        </tr>
        {/if}
        {/foreach}
    </table>
    <table>
        <tr>
            <td width="20" bgcolor="#003300">
                &nbsp;
            </td>
            <td>
                {gt text='Llibre penjat a la prestatgeria'}
            </td>
        </tr>
        <!--
        <tr>
                <td width="20" bgcolor="#CC9900">
                        &nbsp;
                </td>
                <td>
                        {gt text='Llibre no penjat a la prestatgeria'}
                </td>
        </tr>
        -->
        <tr>
            <td width="20" bgcolor="#990000">
                &nbsp;
            </td>
            <td>
                {gt text="Llibre pendent d'activació"}
            </td>
        </tr>				
    </table>
</div>