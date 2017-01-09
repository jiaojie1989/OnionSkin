﻿{extends file="_centered.tpl"}
{block name=title}{$L.my_snippets}{/block}
{block name="body"}
<div class="container container-table">
    <div class="row ">
		<h1>{$L.my_snippets}</h1>
  <table class="table table-striped table-condensed table-hover">
    <thead>
      <tr>
        <th>Name</th>
        <th>Date</th>
        <th>Type</th>
        <th>Owner</th>
      </tr>
    </thead>
    <tbody>
	  {foreach from=$snippets item=foo}
		<tr>
			<td><a href="{$R->Path("ViewPage",array($foo->id,$R-normalize($foo->title)))}">{$foo->title}</a></td>
			<td>{$foo->createdTime->format('Y-m-d H:i:s')}</td>
			<td>{$foo->syntax}</td>
			<td>{$H->breadcrumb($foo->folder)}</td>
		</tr>
	  {/foreach}
    </tbody>
  </table>
		{include file="fnc/Pagination.tpl" value=$pagination}
		</div>
	</div>
{/block}