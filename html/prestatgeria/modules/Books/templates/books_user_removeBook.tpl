<div class="page">
    <div class="mainTitle">
        {gt text='Esborra el llibre'} {$book.bookTitle}
    </div>
    <hr />
    <form name="removeBook" id="removeBook" action="{modurl modname='Books' type='user' func='removeBook'}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="confirmation" value="1" />
        <input type="hidden" name="bookId" value="{$book.bookId}" />
        {gt text='Confirma que vols esborrar el llibre de forma permanent i definitiva. Tingués present que no serà possible recuperar-ne els continguts.'}
        <br />
        <br />
        <div>
            <input type="submit" name="submit" value="{gt text='Esborra el llibre'}" />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit" name="submit" value="{gt text='Cancel·la}" />
        </div>
    </form>
</div>