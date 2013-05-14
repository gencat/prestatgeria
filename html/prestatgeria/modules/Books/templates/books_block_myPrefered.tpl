<div id="prefered">
    <div class="blocContent">
        {foreach item=book from=$books}
        <div id="bookPrefered_{$book.bookId}" style="clear:both; width: 100%">
            <div class="blocLink">
                <a href="#" onclick="javascript:showBookData({$book.bookId})">
                    {$book.bookTitle}
                </a>
            </div>
            <div class="blocValue">
                <a href="javascript:delPrefer({$book.bookId})">
                    {gt text='Esborra de la llista de preferits' assign=alt}
                    {img modname=Books src=close.png altml=true titleml=true alt=$alt title=$alt}
                </a>
            </div>
        </div>
        {foreachelse}
        <div>{gt text='No tens llibres preferits'}</div>
        {/foreach}
        <div style="clear:both;"></div>
    </div>
</div>
