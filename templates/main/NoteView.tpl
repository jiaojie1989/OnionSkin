{extends file="_centered.tpl"}
{block name=title}{$snippet->title}{/block}
{block name="innerbody"}
<h2 class="mt-3">{$snippet->title|escape}</h2>
<p><span class="glyphicon glyphicon-user" aria-hidden="true"></span> {if isset($snippet->user)}{$snippet->user->username|escape}{else}Anonym{/if}</p>
<div class="limit-card card">
  <div class="card-header  text-right">
<div class="btn-group">
  <a href="#" class="btn btn-primary">Raw</a>
  <a href="#" class="btn btn-primary">Print</a>
  <a href="#" class="btn btn-primary">Get</a>
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