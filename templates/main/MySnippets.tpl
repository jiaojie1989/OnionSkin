{extends file="_centered.tpl"}
{block name=title}{$L.my_snippets}{/block}
{block name="body"}
<div class="container container-table">
<div class="card  mb-3 mt-3">
  <div class="card-block">
    <div class="row ">
		<h1 class="mt-3">{$L.my_snippets}</h1>
  <table class="table table-striped table-condensed table-hover">
    <thead>
      <tr>
        <th>{$L.name}</th>
        <th>{$L.date}</th>
        <th>{$L.type}</th>
        <th>{$L.location}</th>
      </tr>
    </thead>
    <tbody>
	  {foreach from=$snippets item=foo}
		<tr>
			<td><a href="{$R->Path("ViewPage",array($foo->id,$R->Normalize($foo->title)))}">{$foo->title|escape}</a></td>
			<td>{$foo->createdTime->format('Y-m-d H:i:s')}</td>
			<td>{$foo->syntax}</td>
			<td>{$H->breadcrumb($foo->folder)}</td>
		</tr>
	  {/foreach}
    </tbody>
  </table>
		{include file="fnc/Pagination.tpl" value=$pagination}
		</div></div></div>
	</div>
{/block}