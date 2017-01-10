{extends file="_centered.tpl"}
{block name=title}{$snippet->title}{/block}
{block name="innerbody"}
<div class="card  mb-3 mt-3">
  <div class="card-block">
<h2 class="">{$snippet->title|escape} </h2>
	  
  <h3><small class="text-muted"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> {if isset($snippet->user)}{$snippet->user->username|escape}{else}Anonym{/if}</small></h3>

<div class="limit-card card">
  <div class="card-header">
	{if $snippet->isOwner()}
	  <div class="w-50 float-left">
	  {$H->breadcrumbS($snippet)}</div>
	  {else}
	{/if}
<div class="btn-group float-right">
  <a href="{$R->Path("RawPage",array($snippet->id))}" class="btn btn-primary">Raw</a>
  <a href="{$R->Path("PrintPage",array($snippet->id))}" class="btn btn-primary">Print</a>
  <a href="{$R->Path("GetPage",array($snippet->id))}" class="btn btn-primary">Get</a>
	{if $snippet->isOwner()}
  <div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      {$L.next_action}
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
      <a class="dropdown-item" href="{$R->Path("EditPage",array($snippet->id))}">{$L.edit}</a>
		  
	  <form action="{$R->Path("EditPage",array($snippet->id))}" method="get">
		<input type="hidden" name="_method" value="DELETE">
      <button class="dropdown-item btn btn-link" type="submit">{$L.remove}</button></form>
    </div>
  </div>
	{/if}
</div>
  </div>
  <div class="card-block">
	<pre><code class="{$snippet->syntax}">{$snippet->text|escape}
		</code></pre>
  </div>
  <div class="card-footer text-muted text-right">
    {$snippet->createdTime->format("d.m.y h:i:s")}
  </div>
</div>
	  </div></div>

{/block}
{block name="js_end" append}
<script src="/js_c/highlight.js"></script>
<script>
	$(document).ready(function() {
  $('pre code').each(function(i, block) {
    hljs.highlightBlock(block);
  });
});
</script>
{/block}