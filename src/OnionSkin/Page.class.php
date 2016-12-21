<?php

namespace OnionSkin;

class Page {

	private $UrlParts = array();
	public $RequireLogged = true;
	public $RequireAdmin = true;
	public $Url = array();

	public function req_metod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}
	public function req_accept()
	{
		return $_SERVER['HTTP_ACCEPT'];
	}
	protected function ok($page)
	{
		Bootstrap::$Smarty->display($page);
		die;
	}
    public function execute(){}

	public static function resolve($page)
	{
		$Page = null;
		$parts=explode('/',$page);
		$c=count($parts);
        if($c==0)
            $Page = new \OnionSkin\Pages\EditPage();
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
                $Page = new \OnionSkin\Pages\EditPage();
                break;
		}
		$Page->UrlParts = $parts;
        return $Page;
	}



}