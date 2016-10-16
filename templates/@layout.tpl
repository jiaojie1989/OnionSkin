<html>
<head>
<title>{block name=title}OnionSkin{/block}</title>
{include file="@styleMain.tpl"}
</head>
<body>
	<div class="header">
		<ul class="vertical-menu align-left">
			<li><h1>OnionSkin</h1></li>
			
		</ul>
		<ul class="vertical-menu align-right">
			{if isset($logged) && $logged}
				<li><a href="mycollections.php">{$lng["mycollections"]}</a></li>
				<li><a href="logout.php">{$lng["logout"]}</a></li>
			{else}
				<li><a href="login.php">{$lng["login"]}</a></li>
			{/if}
		</ul>
	</div>
	{block name=body}{/block}
</body>
</html>