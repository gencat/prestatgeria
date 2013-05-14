{insert name="getstatusmsg"}
<div class="page">
    <div class="mainTitle">
        {$title}
    </div>
    <hr />
    <div>
        <div style="float: left; padding-right: 20px;">
            {if $result}
            {img modname=core src=button_ok.png set=icons/medium}
            {else}
            {img modname=core src=button_cancel.png set=icons/medium}
            {/if}
        </div>
        <div style="float: left;">
            {$msg}
        </div>
        <div style="clear: both;"></div>
        {if isset($returnURL)}
        <div style="text-align: right;">
            <a href="{$returnURL}">{gt text='Torna'}</a>
        </div>
        {/if}
    </div>
</div>