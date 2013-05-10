<div style="height:40px;">&nbsp;</div>
<div class="pagerTop">{$collections|@count} {gt text='col·leccions'}{if $pager neq ''} - {gt text='pàgina'} {$pager}{/if}</div>
<div class="page">
    <div class="mainTitle">{gt text='Índex de col·leccions'}</div>
    <hr />
    <table width="100%" class="pageend">
        {foreach item=collection from=$collections}
        <tr>
            <td valign="top" width="50%">
                <div class="collectionName">
                    <a href="#" onClick="catalogue('','collection',1,'{$collection.collectionId}',4)" title="{gt text='Accés als llibres de la col·lecció'}">
                        {$collection.collectionName}
                    </a>
                </div>
            </td>
            <td valign="top" width="24%">
                <div class="booksInCollection" title="{gt text='Nombre de llibres continguts a la col·lecció'}">
                    {$collection.booksInCollection}
                </div>
            </td>
            <td valign="top" width="24%">
                {if $collection.collectionState eq 1}
                <div class="collectionActive" title="{gt text='Estat de la col·lecció: activa'}">{gt text='Oberta'}</div>
                {else}
                <div class="collectionNotActive" title="{gt text='Estat de la col·lecció: no activa'}">{gt text='Tancada'}</div>
                {/if}
            </td>
            <td valign="top" width="24%">
                {if $collection.collectionAutoOut eq '' && $collection.collectionState eq 1}
                <div class="collectionAutoOut" title="{gt text='Data de desactivació de la col·lecció'}">
                    {gt text='Permanent'}
                </div>
                {/if}
            </td>
        </tr>
        {/foreach}
    </table>
    <table>
        <tr>
            <td bgcolor="#009933" width="20">&nbsp</td>
            <td valign="top">
                <div class="collectionActive" title="{gt text='Estat de la col·lecció: activa'}">
                    {gt text='Oberta'}
                </div>
            </td>
            <td>{gt text="Quan una col·lecció està oberta s'hi poden associar llibres que no formin part de cap altra col·lecció. A aquestes col·leccions també s'hi poden associar els llibres que es creïn nous."}</td>
        </tr>
        <tr>
            <td bgcolor="#990000" width="20">&nbsp</td>
            <td valign="top">
                <div class="collectionNotActive" title="{gt text='Estat de la col·lecció: no activa'}">
                    {gt text='Tancada'}
                </div>
            </td>
            <td>{gt text="Quan una col·lecció està tancada ja no s'hi poden associar més llibres. Els llibres associats a aquestes col·leccions es poden filtrar des de les opcions de cerca del catàleg."}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>{gt text='Les col·leccions permanents sempre estan obertes. Quan una col·lecció no és permanent i està oberta, la columna de la dreta de la llista indica la data prevista del tancament.'}</td>
        </tr>
    </table>
</div>
<div class="pagerBottom">
    {$collections|@count} {gt text='col·leccions'}{if $pager neq ''} - {gt text='pàgina'} {$pager}{/if}
</div>
