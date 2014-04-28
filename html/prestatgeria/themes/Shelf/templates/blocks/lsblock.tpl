
<!-- Inici d'un bloc esquerre -->
<div class="left_inside">
    {if ! empty($title) }{* Nom�s mostra el t�tol si existeix *}
    <h3>
        {$title}&nbsp;{$minbox}
    </h3>
    {/if}
    <div class="left_content">
        {$content}
    </div>
</div>
<!-- Final del bloc esquerre -->

