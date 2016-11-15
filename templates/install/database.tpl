{extends file="@layoutInstall.tpl"}
{block name=header}{$lng.Titles.onionskin} {$lng.Install.install} - {$lng.Install.installStep1}{/block}
{block name=body}
<form class="structured-form">
	<h3>{$lng.Install.databaseConnector}</h3>
	<label for="databaseCon">{$lng.Install.databaseConString}</label>
	<input id="databaseCon" name="databaseCon" type="text" placeholder="{$lng.Install.databaseCon}"/><br/>
	<label for="databaseUser">{$lng.Install.databaseUser}</label>
	<input id="databaseUser" name="databaseUser" type="text" placeholder="{$lng.Install.databaseUser}"/><br/>
	<label for="databasePass">{$lng.Install.databasePassword}</label>
	<input id="databasePass" name="databasePass" type="password" placeholder="{$lng.Install.databasePassword}"/><br/>
	
	<div class="align-right">
		<a class="button" href="#">{$lng.Install.test}</a>
		<a class="button" href="#">{$lng.Install.next}</a>
	</div>
</form>

<form class="structured-form">
	<h3>{$lng.Install.databaseConnector}</h3>
	<label for="databaseCon">{$lng.Install.databaseConString}</label>
	<input id="databaseCon" name="databaseCon" type="text" placeholder="{$lng.Install.databaseCon}"/><br/>
	<label for="databaseUser">{$lng.Install.databaseUser}</label>
	<input id="databaseUser" name="databaseUser" type="text" placeholder="{$lng.Install.databaseUser}"/><br/>
	<label for="databasePass">{$lng.Install.databasePassword}</label>
	<input id="databasePass" name="databasePass" type="password" placeholder="{$lng.Install.databasePassword}"/><br/>
	
	<div class="align-right">
		<a class="button" href="#">{$lng.Install.test}</a>
		<a class="button" href="#">{$lng.Install.next}</a>
	</div>
</form>
{/block}