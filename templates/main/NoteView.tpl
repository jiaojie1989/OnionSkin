{extends file="_centered.tpl"}
{block name=title}{$snippet->title}{/block}
{block name="innerbody"}
<div class="card  mb-3 mt-3">
  <div class="card-block">
<h2 class="">{$snippet->title|escape}</h2>
<p><span class="glyphicon glyphicon-user" aria-hidden="true"></span> {if isset($snippet->user)}{$snippet->user->username|escape}{else}Anonym{/if}</p>
<div class="limit-card card">
  <div class="card-header"><div class="w-50 float-left">
	  {$H->breadcrumbS($snippet)}</div>
<div class="btn-group float-right">
  <a href="#" class="btn btn-primary">Raw</a>
  <a href="#" class="btn btn-primary">Print</a>
  <a href="#" class="btn btn-primary">Get</a>
	{if $snippet->isOwner()}
  <div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      {$L.next_action}
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
      <a class="dropdown-item" href="#">{$L.edit}</a>
      <a class="dropdown-item" href="#">{$L.remove}</a>
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