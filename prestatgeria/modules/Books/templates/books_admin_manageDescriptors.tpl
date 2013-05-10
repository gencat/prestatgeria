{include file="books_admin_menu.tpl"}
<div class="z-admincontainer">
    <div class="z-adminpageicon">{img modname=core src=configure.png set=icons/large}</div>
    <h2>{gt text='Administra els descriptors'}</h2>
    <div class="descriptorsNumber">
        {gt text='Nombre total de descriptors'}: {$descriptors|@count}
        <a href="{modurl modname='Books' type='admin' func='purge'}">&nbsp;&nbsp;&nbsp;({gt text='Purga els descriptors'})</a>
    </div>
    <table class="z-datatable">
        {foreach item=descriptor from=$descriptors}
        <tr bgcolor="{cycle values='#ffffff, #eeeeee'}" id="row_{$descriptor.did}">
            <td>
                <div id="descriptor_{$descriptor.did}">
                    {$descriptor.descriptor}
                </div>
            </td>
            <td>
                {$descriptor.number}
            </td>
            <td>
                <a href="javascript:editDescriptor({$descriptor.did})">
                    {img modname=core src=edit.png set=icons/extrasmall}
                </a>
                <a href="javascript:deleteDescriptor({$descriptor.did})">
                    {img modname=core src=14_layer_deletelayer.png set=icons/extrasmall}
                </a>
            </td>
        </tr>
        {/foreach}
    </table>
</div>