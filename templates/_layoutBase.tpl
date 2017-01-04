<html>
<head>
<title>{block name=title}OnionSkin{/block}</title>
	{block name="css"}{/block}
</head>
<body>
	{block name="js_start"}{/block}
	<nav class="navbar navbar-default navbar-static-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">{$L.menu}</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">{$L.onionskin}</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="#">{$L.public_snippets}</a></li>
			{if isset($logged) && $logged}
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{$L.my_snippets} <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">{$L.folders}</a></li>
            <li><a href="#">{$L.file_types}</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">{$L.display_all}</a></li>
          </ul>
        </li>
		  {/if}
        <li><p class="navbar-btn"><a class="btn btn-default" href="{$R->Path("EditPage")}">{$L.create_new_snippet}</a></p></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
		
			{if isset($logged) && $logged}
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          Signed in as Mark Otto <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Settings</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">{$L.logout}</a></li>
          </ul>
        </li>
			{else}
        <li><p class="navbar-btn"><a class="btn btn-default" href="{$R->Path("Profile\LoginPage")}">{$L.login}</a></p></li>
			{/if}
      </ul>
      <form class="navbar-form navbar-right" action="{$R->Path("SearchPage")}">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="{$L.search}">
        </div>
        <button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-search"></span></button>
      </form>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	{block name="body"}{/block}
	{block name="js_end"}{/block}
</body>
</html>