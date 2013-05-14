<div class="blocContent">
    {foreach item=cloud from=$cloud}
    <a style="font-size:{$cloud.size}px" class="tag_cloud" href="#" onclick="javascript:catalogue('','descriptor',1,'{$cloud.tag}',4)" title="{$cloud.tag} se n'han trobat {$cloud.count}">
        {$cloud.tag}
    </a>
    {/foreach}
    <div style="clear: both;">&nbsp;</div>
    <div class="more">
        <a href="#" onclick="javascript:descriptors()">
            {gt text='Més...'}
        </a>
    </div>
    <div style="clear: both;"></div>
</div>
