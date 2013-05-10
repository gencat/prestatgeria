<table>
    {foreach item=allow from=$allowed}
    <tr>
        <td>
            <strong>{$allow.userName}</strong>
        </td>
        <td>
            {gt text='Esborra assignació' assign=alt}
            <a href="javascript:allowUser('deleteCreator','{$allow.userName}')">
                {img modname=Books src=close.png altml=true titleml=true alt=$alt title=$alt}
            </a>
        </td>
    </tr>
    {foreachelse}
    {gt text="No s'ha donat a cap persona la capacitat de crear llibres en nom del centre."}		
    {/foreach}
</table>
