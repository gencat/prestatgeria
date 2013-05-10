{include file="books_admin_menu.tpl"}
<div class="z-admincontainer">
    <div class="z-adminpageicon">{img modname=core src=configure.png set=icons/large}</div>
    <h2>{gt text='Llista de centres amb drets de creació de llibres nous'}</h2>
    <table class='z-datatable'>
        {foreach item=school from=$schools}
        <tr bgcolor="{cycle values='#ffffff, #eeeeee'}">
            <td>
                {$school.schoolCode}
            </td>
            <td>
                {$school.schoolType} {$school.schoolName}
            </td>
            <td>
                {$school.schoolCity}
            </td>
            <td>
                {$school.schoolZipCode}
            </td>
            <td>
                {$school.schoolRegion}
            </td>
        </tr>
        {/foreach}
    </table>
</div>
