{extends file="_centered.tpl"}
{block name=title}{$L.settings}{/block}
{block name="innerbody"}
<div class="card  mb-3 mt-3">
  <div class="card-block">
<h2 class="mt-3">{$L.settings}</h2>
	{$Form->Start("form-settings","Profile\\SettingsPage","post",["role"=>"form","class"=>"form-horizontal"])}
	{$Form->AntiForgeryToken()}
	{$Form->Select("style",["light"=>"Light Style","dark"=>"Dark Style"],"Style",["select"=>["tabindex"=>"1"]])}
	{$Form->Button("settings_submit",$L.save,["tabindex"=>"2","class"=>"btn-success"])}
	{$Form->End()}
  </div>
</div>

{/block}