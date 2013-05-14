{include file="books_admin_menu.tpl"}
<div class="z-admincontainer">
    <div class="z-adminpageicon">{img modname=core src=configure.png set=icons/large}</div>
    <h2>{gt text='Crea un centre nou amb drets de creació de llibres'}</h2>
    <form id="newBook" class="z-form" action="{modurl modname='Books' type='admin' func='createSchool'}" method="post" enctype="multipart/form-data">
        <div class="z-formrow">
            <label for="schoolCode">{gt text='Codi del centre'}:</label>
            <input name="schoolCode" id="schoolCode" type="text" title="{gt text='Codi del centre'}" value="" />			
        </div>
        <div class="z-formrow">
            <label for="schoolType">{gt text='Tipus de centre'}:</label>
            <input name="schoolType" id="schoolType" type="text" title="{gt text='Tipus de centre'}" value="" />			
        </div>
        <div class="z-formrow">
            <label for="schoolName">{gt text='Nom del centre'}:</label>
            <input name="schoolName" id="schoolName" type="text" title="{gt text='Nom del centre'}" value="" />			
        </div>
        <div class="z-formrow">
            <label for="schoolCity">{gt text='Municipi del centre'}:</label>
            <input name="schoolCity" id="schoolCity" type="text" title="{gt text='Municipi del centre'}" value="" />			
        </div>
        <div class="z-formrow">
            <label for="schoolZipCode">{gt text='Codi postal'}:</label>
            <input name="schoolZipCode" id="schoolZipCode" type="text" title="{gt text='Codi postal'}" value="" />			
        </div>
        <div class="z-formrow">
            <label for="schoolRegion">{gt text='Delegació Territorial del centre'}:</label>
            <input name="schoolRegion" id="schoolRegion" type="text" title="{gt text='Delegació Territorial del centre'}" value="" />			
        </div>
        <div class="z-center">
            <div class="z-buttons">
                <a href="javascript:document.forms['newBook'].submit();">
                    {*button src=button_ok.gif set=icons/small __alt="Crea" __title="Crea"*}
                    {img modname=core src=button_ok.png set=icons/small altml=true titleml=true __alt='Crea' __title='Crea'}
                    {gt text="Crea"}
                </a>
            </div>
        </div>
    </form>
</div>