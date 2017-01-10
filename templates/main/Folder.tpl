{extends file="_centered.tpl"}
{block name=title}{$L.my_snippets}{/block}
{block name="body"}
<div class="container container-table">
<div class="card  mb-3 mt-3">
  <div class="card-block">
    <div class="row ">
		<h1 class="mt-3">{$L.my_folders}</h1>
	  <div class="container">
	  {if isset($folder)}
	  <form class="form form-inline" method="post" action="{$R->Path("MySnippets\\FolderPage",array($folder->id))}">
			{else}
	  <form class="form form-inline" method="post" action="{$R->Path("MySnippets\\FolderPage")}">
			{/if}

		  <div class="btn-group mt-1 mb-2">
		  <input type="text" id="value" name="value" placeholder="{$L.folder_name}"/>
		  <button class="btn btn-success btn-sm">{$L.add}</button></div>
		  </form></div>
  <table class="table table-striped table-condensed table-hover">
    <thead>
      <tr>
        <th>{$L.name}</th>
        <th>{$L.type}</th>
        <th>{$L.date}</th>
        <th>{$L.action}</th>
      </tr>
    </thead>
    <tbody>
	  {if isset($folder)}
		<tr>
	  {if isset($folder->parentFolder)}
			<td><a href="{$R->Path("MySnippets\\FolderPage",array($folder->parentFolder->id))}">..</a></td>
			<td>{$L.folder}</td>
			<td>{$folder->parentFolder->modifiedTime->format('Y-m-d H:i:s')}</td>
			<td></td>
		{else}
			<td><a href="{$R->Path("MySnippets\\FolderPage")}">..</a></td>
			<td>{$L.folder}</td>
			<td></td>
			<td></td>
		{/if}
		</tr>
	   {/if}
	  {foreach from=$childs item=foo}
		<tr class="table-warning">
			<td><a href="{$R->Path("MySnippets\\FolderPage",array($foo->id))}">{$foo->name}</a></td>
			<td>{$L.folder}</td>
			<td>{$foo->modifiedTime->format('Y-m-d H:i:s')}</td>
			<td>
				<form class="" action="{$R->Path("MySnippets\\FolderPage",array($foo->id))}" method="get">
					<input type="hidden" name="_method" value="DELETE"><input type="hidden" class="btn ">
					<button class="btn btn-sm btn-danger">{$L.remove}
					</button>
				</form>
			</td>
		</tr>
	  {/foreach}
	  {foreach from=$snippets item=foo}
		<tr>
			<td><a href="{$R->Path("ViewPage",array($foo->id))}">{$foo->title}</a></td>
			<td>{$foo->syntax}</td>
			<td>{$foo->modifiedTime->format('Y-m-d H:i:s')}</td>
			<td>
				<form class="btn-group" action="Edit/'+aData.id+'" method="get">
					<button class="btn btn-sm btn-info">{$L.edit}</button>
					<input type="hidden" class="btn">
				</form>
				<form class="btn-group" action="Edit/'+aData.id+'" method="get">
					<input type="hidden" name="_method" value="DELETE"><input type="hidden" class="btn ">
					<button class="btn btn-sm btn-danger">{$L.remove}
					</button>
				</form>
			</td>
		</tr>
	  {/foreach}
    </tbody>
  </table>
		{include file="fnc/Pagination.tpl" value=$pagination}
		</div></div></div>
	</div>
{/block}