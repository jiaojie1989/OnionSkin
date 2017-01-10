{extends file="_centered.tpl"}
{block name=title}Snippet{/block}
{block name="innerbody"}

<div class="card  mb-3 mt-3">
  <div class="card-block">
<h2 class="">{$L.newsnippet}</h2>

<div class="container">
	{$Form->Start("form-edit","EditPage","post",["role"=>"form","class"=>"form-horizontal"],array($id))}
	{$Form->BindModel("form_edit")}
	{$Form->AntiForgeryToken()}
	{$Form->TextBox("name",
					$H->cat($L.name," *"),
					$L.name,
					[	"help"=>$H->cat("* ",$L.requiredfield),
						"input"=>["tabindex"=>"1","required"=>"required","pattern"=>$H->cat([".",$ldim,"1,",$rdim]),"title"=>$L.one_character_minimal]])}
	{$Form->TextArea("snippet",
					$H->cat($L.content," *"),
					$L.content,
					[	"help"=>$H->cat("* ",$L.requiredfield),
						"textarea"=>["tabindex"=>"2","required"=>"required","pattern"=>$H->cat(".",$ldim,"1, ",$rdim),"title"=>$L.one_character_minimal]])}
	{$Form->Select("syntax",$H->arrayAddBegin($syntax_list,"txt",$L.syntax_none),$L.syntaxHighlight,["select"=>["tabindex"=>"3"]])}
	{if isset($user)}
		{$Form->Select("folder",$user->foldersToArray(),$L.folder,["select"=>["tabindex"=>"4"]])}
	{$Form->Select("visibility",["2"=>$L.visibility_public,"1"=>$L.visibility_link,"0"=>$L.visibility_private],$L.visibility,["select"=>["tabindex"=>"5"]])}
	{else}
	{$Form->Select("visibility",["2"=>$L.visibility_public],$L.visibility,["select"=>["tabindex"=>"5"],"help"=>$L.login_for_private_link])}
	{/if}
	{$Form->Select("expiration",["never"=>$L.expiration_never,"10m"=>$H->cat("10 ",$L.time_m_p),"1h"=>$H->cat("1 ",$L.time_h_s),"1d"=>$H->cat("1 ",$L.time_d_s),"1w"=>$H->cat("1 ",$L.time_w_s)],$L.expiration,["select"=>["tabindex"=>"6"]])}
	{$Form->Button("edit_submit",$L.save,["tabindex"=>"7","class"=>"btn-success"])}
	{$Form->End()}
</div></div></div>

{/block}
{block name="js_end" append}
<script src="/js_c/editor.js"></script>
{/block}