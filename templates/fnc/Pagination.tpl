<ul class="pagination pagination-lg">
{if isset($value->first)}
  <li><a href="{$R->Path($value->page,array($value->first))}">{$value->first}</a></li>
  <li class="disabled"><a href="#">...</a></li>
{/if}
{foreach from=$value->data item=foo}
  <li {if $value->current eq $foo}class="active"{/if}><a href="{$R->Path($value->page,array($foo))}">{$foo}</a></li>
{/foreach}
{if isset($pagination->last)}
  <li class="disabled"><a href="#">...</a></li>
  <li><a href="{$R->Path($value->page,array($value->last))}">{$value->last}</a></li>
{/if}
</ul>