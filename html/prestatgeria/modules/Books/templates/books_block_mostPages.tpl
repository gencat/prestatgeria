<div class="blocContent">
    {foreach item=book from=$books}
    <div class="blocLink">
        <a href="#" onclick="javascript:showBookData({$book.bookId})">
            {$book.bookTitle}
        </a>
    </div>
    <div class="blocValue">
        {$book.bookPages} {gt text='Pàg.'}
    </div>
    {/foreach}
    <div class="more">
        <a href="#" onclick="javascript:catalogue('bookPages','',1,'',1)">
            {gt text='Més...'}
        </a>
    </div>
    <div style="clear: both;"></div>
</div>
