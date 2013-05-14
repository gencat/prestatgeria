<form  name="editDescriptor_{$descriptor.descriptor}" id="editDescriptor_{$descriptor.descriptor}" method="post" enctype="multipart/form-data">
    <input type="text" name="descriptorValue" value="{$descriptor.descriptor}" />
    <a onClick="javascript:updateDescriptor({$descriptor.did},document.editDescriptor_{$descriptor.descriptor}.descriptorValue.value)">
        {img modname=core src=ok.gif set=icons/extrasmall}
    </a>
</form>