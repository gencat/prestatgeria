{include file="books_user_menu.tpl"}
<div class="page">
    <div class="mainTitle">{gt text='Descriptors'}</div>
    <hr />
    {foreach item=cloud from=$cloud}
    <a style="font-size:{$cloud.size}px" class="tag_cloud" href="#" onclick="javascript:catalogue('','descriptor',1,'{$cloud.tag}',4)" title="{$cloud.tag} se n'han trobat {$cloud.count}">
        {$cloud.tag}
    </a>
    {/foreach}
</div>
