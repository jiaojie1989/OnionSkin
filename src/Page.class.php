<?php

namespace OnionSkin;

class Page {
	
	private $UrlParts;
	
	public static function resolve($page)
	{
		$Page = null;
		$parts;
		$c=count($parts);
		switch($parts[0])
		{
			case "index":  $Page = new \OnionSkin\Pages\EditPage(); break;
			case "login":  $Page = new \OnionSkin\Pages\LoginPage(); break;
			case "logout": $Page = new \OnionSkin\Pages\LogoutPage(); break;
			case "category": $Page = new \OnionSkin\Pages\CategoryPage(); break;
			default:
				if(is_numeric($parts[0]))
				{
					if($c===3 && $parts[count($parts)]=="edit")
						$Page = new \OnionSkin\Pages\EditPage();
					elseif($c===2 && $c===1)
						$Page = new \OnionSkin\Pages\ShowPage();
					break;
				}
		}
		$Page->UrlParts = $parts;
	}
	
	
}