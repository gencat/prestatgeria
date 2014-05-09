{include file="books_user_menu.tpl"}
<div id="showState">
    {if $filter neq '' and $filterValue neq '' and $filter neq 'schoolCode'}
    {gt text='Llibres'} 
    {if $filter == 'descriptor'}
    {gt text='que tenen el descriptor'}
    {elseif $filter == 'collection'}
    {gt text='de la col·lecció'}
    {elseif $filter == 'name' || $filter == 'schoolCode'}
    {gt text='del centre'}
    {elseif $filter == 'lang'}
    {gt text='en'}
    {elseif $filter == 'city'}
    {gt text='de centres de'}
    {elseif $filter == 'title'}
    {gt text='que en el títol hi tenen la paraula o paraules'}
    {elseif $filter == 'admin'}
    {gt text='que tenen per administrador/a a'}
    {/if}
    <strong>{$filterValue|replace:"--apos--":"'"}</strong>
    {gt text='ordenats pels'}
    {else}
    {gt text='Ordenats pels'}
    {/if}

    {if $order eq 'lastEntry'}
    {gt text="que tenen l'entrada més recent."}
    {elseif $order eq 'lastCreated'}
    {gt text="darrers que s'han creat."}
    {elseif $order eq 'bookPages'}
    {gt text='que tenen més pàgines.'}
    {elseif $order eq 'bookHits'}
    {gt text='més llegits'}
    {/if}
</div>
