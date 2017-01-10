<!DOCTYPE html>
<html>
<head>
<title>{block name=title}OnionSkin{/block}</title>
	{block name="css"}{/block}
</head>
<body class="{$body_class}">
	{block name="js_start"}{/block}
	<nav class="navbar navbar-toggleable-md hidden-print {$navbar_color}">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
	<a class="navbar-brand" href="{$R->Path("@/")}">{$L.onionskin}</a>
      <ul class="navbar-nav nav mt-2   mt-md-0">
        <li class="nav-item"><a class="nav-link" href="{$R->Path("PublicSnippetsPage")}">{$L.public_snippets}</a></li>
			{if $logged}
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{$L.my_snippets}</a>
          <div class="dropdown-menu">
            <a href="{$R->Path("MySnippets\FolderPage")}" class="dropdown-item">{$L.folders}</a>
            <a href="{$R->Path("MySnippets\TypePage")}" class="dropdown-item">{$L.file_types}</a>
			  <div class="dropdown-divider"></div>
            <a href="{$R->Path("MySnippets\AllSnippetsPage")}" class="dropdown-item">{$L.display_all}</a>
          </div>
        </li>
		  {/if}
      </ul>
		<form class="form-inline my-2 mt-md-0 my-lg-0" action="{$R->Path("EditPage")}" method="get">
				<button class="btn btn-sm align-middle btn-outline-success" type="submit">{$L.create_new_snippet}</button>
			</form>
	
		{if $logged}
		<ul class="navbar-nav my-2 ml-auto my-lg-0 nav">
        <li class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
           {$L.signed_in_as} {$user->username}</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{$R->Path("Profile\SettingsPage")}">{$L.settings}</a>
			  <div class="dropdown-divider"></div>
			  {$Form->Start("logout","Profile\LogoutPage","post",["class"=>"form-inline dropdown-item"])}
			  {$Form->AntiForgeryToken()}
			  {$Form->Button("logout-submit",$L.sign_out,["class"=>"btn-link"])}
			  {$Form->End()}
          </div>
        </li>
      </ul>
			{else}
		
  <form class="form-inline my-2 ml-auto mr-2 my-lg-0" method="get" action="{$R->Path("Profile\LoginPage")}">
    <button class="btn btn-sm align-middle btn-outline-success" type="submit">{$L.login}</button>
  </form>
  <form class="form-inline my-2 my-lg-0" method="get" action="{$R->Path("Profile\RegisterPage")}">
    <button class="btn btn-sm align-middle btn-outline-success" type="submit">{$L.sign_up}</button>
  </form>
			{/if}</div>
</nav>
	{block name="body"}{/block}
	{block name="js_end"}{/block}
</body>
</html>